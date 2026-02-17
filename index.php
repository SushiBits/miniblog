<?php
require_once dirname(__FILE__) . "/include/config.php";
require_once dirname(__FILE__) . "/include/article.php";

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_path = preg_replace('/\/+/', '/', $request_path);

if ($request_path === '/') {
    // Home page. (WIP)
    $TITLE = '';
    $articles = Article::articles();
    ob_start();
?>
    <h1><?= L::SITENAME ?></h1>
    <hr />
<?php if (empty($articles)) { ?>
    <p class="no-article"><?= L::Article_NO_ARTICLE ?></p>
<?php
    } else {
        foreach ($articles as $article) {
?>
    <div class="article">
        <h2><a class="article-link" href="/<?= urlencode($article->get_slug()) ?>.html"><?= htmlspecialchars($article->get_article_name()) ?></a></h2>
        <?= $article->get_abstract() ?>
        <hr />
    </div>
<?php
        }
    }

    $CONTENTS = ob_get_contents();
    ob_end_clean();
} else if (in_array($request_path, ['/index.php', '/index.html', '/index.htm'])) {
    // Non-standard home page addresses
    header('Location: /');
    exit;
} else {
    // Article display.
    $slug = basename($request_path, '.html');
    $article = Article::article($slug);
    if (!$article->file_exists()) {
        // 404. Try to load 404.md instead.
        http_response_code(404);
        $article = Article::article('404');
        if (!$article->file_exists()) exit; // Now we have no nice 404 page. Let the Web server create one.
    }
    $TITLE = htmlspecialchars($article->get_article_name());
    $CONTENTS = $article->render();
}

require_once dirname(__FILE__) .'/include/templates/page.php';