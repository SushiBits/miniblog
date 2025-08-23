<?php
require_once dirname(__FILE__) ."/contrib/Parsedown.php";

class Renderer extends Parsedown {
    protected function inlineImage($Excerpt) {
        $image = parent::inlineImage($Excerpt);
        if (!$image)
            return null;

        $src = $image['element']['attributes']['src'];
        $alt = $image['element']['attributes']['alt'] ?? '';
        $extent = $image['extent'];
        $extension = strtolower(pathinfo($src, PATHINFO_EXTENSION));

        if (strtolower($alt) == 'bilibili')
            return $this->embedBilibili($src, $alt, $extent);
        if ($extension === 'pdf')
            return $this->embedPDF($src, $alt, $extent);
        if ($extension === 'svg')
            return $this->embedSVG($src, $alt, $extent);

        $image['element']['attributes']['src'] = $this->embedPath($src);
        return $image;
    }

    protected function embedBilibili(string $src, string $alt, $extent) {
        $src = preg_replace('/[^a-zA-Z0-9]/', '', $src);
        if (empty($src))
            return null;

        ob_start();
?>
<div class="video-container bilibili">
    <iframe src="//player.bilibili.com/player.html?isOutside=true&bvid=<?= $src ?>&p=1" scrolling="no" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>
</div>
<?php
        $html = ob_get_clean();
        return ['extent' => $extent, 'markup' => $html];
    }

    protected function embedPath(string $src): string {
        if (strpos($src, '://') === false && substr($src, 0, 1) !== '/')
            return "/attachments/$src";
        else
            return $src;
    }

    protected function embedPDF(string $src, string $alt, $extent) {
        $src = $this->embedPath($src);

        ob_start();
?>
<div class="embed-container pdf">
    <embed src="<?= $src ?>" type="application/pdf" width="100%" height="600px" />
</div>
<?php
        $html = ob_get_clean();
        return ['extent' => $extent, 'markup' => $html];
    }

    protected function embedSVG(string $src, string $alt, $extent) {
                $src = $this->embedPath($src);

        ob_start();
?>
<div class="embed-container svg">
    <object data="<?= $src ?>" type="image/svg+xml" width="100%">
        <img src="<?= $src ?>" alt="<?= htmlspecialchars($alt) ?>" />
    </object>
</div>
<?php
        $html = ob_get_clean();
        return ['extent' => $extent, 'markup' => $html];
    }
}