<?php
require_once dirname(__FILE__) . "/../include/admin.php";
require_once dirname(__FILE__) . "/../include/article.php";
require_once dirname(__FILE__) . "/../include/config.php";
require_once dirname(__FILE__) . "/../include/utils.php";

$TITLE = L::Admin_CONTROL_PANEL;
require_auth();

$articles = Article::articles();

ob_start();
?>
<style>
table, nav.operations {
    background-color: white;
    border-radius: 6px;
    border-color: #333333;
    border-width: 1px;
    border-style: solid;
    max-width: 600px;
    margin: 12px auto 12px auto;
    width: 100%;
    color: #333333;
    overflow: hidden;
}

nav.operations {
    display: flex;
    flex-direction: row;
    align-items: first baseline;
    vertical-align: middle;
    padding: 0px;
}

nav.operations a {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    height: 36px;
    padding-left: 12px;
    padding-right: 12px;
    color: #333333;
    text-decoration: none;
}

nav.operations a span {
    margin: 6px;
}

nav.operations a:hover {
    color: white;
    background-color: #333333;
}

nav.operations a:hover img {
    filter: invert(100%);
}
</style>
<?php
$HEADERS = ob_get_clean();

ob_start();
?>
<nav class="operations">
    <a href="/admin/edit.php"><img src="/images/ic_public_add.svg" alt="<?= L::Admin_NEW_ARTICLE ?>" /><span><?= L::Admin_NEW_ARTICLE ?></span></a>
</nav>
<table>
    <tr>
        <th><?= L::Article_TITLE ?></th>
        <th><?= L::Article_SLUG ?></th>
        <th><?= L::Article_CTIME ?></th>
        <th><?= L::Article_MTIME ?></th>
        <th><?= L::Article_OPERATION ?></th>
    </tr>
    <?php if (empty($articles)) { ?>
    <tr><td colspan="5" class="noarticle"><?= L::Article_NO_ARTICLE ?></td></tr>
    <?php } else {
        array_walk($articles, function(Article $article) { ?>
    <tr>
        <td><a href="/admin/edit.php?article=<?= $article->get_slug() ?>"><?= htmlspecialchars($article->get_article_name()) ?></a></td>
        <td><?= $article->get_slug() ?></td>
        <td><?= htmlspecialchars(date($GLOBALS['CONFIG']['DATE_FORMAT'], $article->get_ctime())) ?></td>
        <td><?= htmlspecialchars(date($GLOBALS['CONFIG']['DATE_FORMAT'], $article->get_mtime())) ?></td>
        <td><a href="/admin/edit.php?delete=<?= $article->get_slug() ?>"><?= L::Article_DELETE ?></a></td>
    </tr>    
    <?php }); ?>
    <tr>
        <td colspan="5" class="pagination"></td>
    </tr>
    <?php } ?>
</table>
<?php
$CONTENTS = ob_get_clean();
require_once dirname(__FILE__) .'/../include/templates/admin.php';
