<?php
$weights = [
    100 => 'Thin',
    300 => 'Light',
    400 => 'Regular',
    500 => 'Medium',
    700 => 'Bold',
    900 => 'Black',
];

foreach ([false, true] as $condensed)
    foreach ([false, true] as $italic)
        array_walk($weights, function (&$value, $key) {
            $parts = ['HarmonyOS_Sans'];
            if ($GLOBALS['condensed'])
                $parts[] = 'Condensed';
            $parts[] = $value;
            if ($GLOBALS['italic'])
                $parts[] = 'Italic';
            $name = join('_', $parts);
    ?>
@font-face {
    font-family: "HarmonyOS Sans";
    font-weight: <?= $key ?>;
    font-stretch: <?= $GLOBALS['condensed'] ? 'condensed' : 'normal' ?>;
    font-style: <?= $GLOBALS['italic'] ? 'italic' : 'normal' ?>;
    src:
        url("/images/harmonyos-sans/<?= $name ?>.woff2") format("woff2"),
        url("/images/harmonyos-sans/<?= $name ?>.ttf") format("truetype");
}

<?php
        });