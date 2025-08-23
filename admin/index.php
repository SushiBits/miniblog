<?php
require_once dirname(__FILE__) . "/../include/admin.php";
require_once dirname(__FILE__) . "/../include/article.php";
require_once dirname(__FILE__) . "/../include/config.php";

$TITLE = 'Control Panel';
require_auth();

$articles = Article::articles();

ob_start();
?>
<table>
    <tr>
        <th>Title</th>
        <th>Slug</th>
        <th>Create Time</th>
        <th>Modify Time</th>
        <th>Operation</th>
    </tr>
    <?php if (empty($articles)) { ?>
    <tr><td colspan="5" class="noarticle">No article found. Create a new one?</td></tr>
    <?php } else array_walk($articles, function(Article $article) { ?>
    <tr>
        <td><a href="/admin/edit.php?article=<?= $article->get_slug() ?>"><?= $article->get_article_name() ?></a></td>
        <td><?= $article->get_slug() ?></td>
        <td><?= date($GLOBALS['CONFIG']['DATE_FORMAT'], $article->get_ctime()) ?></td>
        <td><?= date($GLOBALS['CONFIG']['DATE_FORMAT'], $article->get_mtime()) ?></td>
        <td><a href="/admin/edit.php?delete=<?= $article->get_slug() ?>"><?= $article->get_article_name() ?></a></td>
    </tr>    
    <?php }); ?>
    <tr>
        <td colspan="5" class="pagination"></td>
    </tr>
</table>
<?php
$CONTENTS = ob_get_clean();
require_once dirname(__FILE__) .'/../templates/admin.php';
