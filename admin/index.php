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
    <?php } else array_walk($articles, function(Article $article) { ?>
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
</table>
<?php
$CONTENTS = ob_get_clean();
require_once dirname(__FILE__) .'/../include/templates/admin.php';
