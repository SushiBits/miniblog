<?php
require_once dirname(__FILE__) . "/../admin.php";
require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/../utils.php";
?>
<!DOCTYPE html>
<html lang="<?= get_current_language() ?>">
    <head>
        <meta charset="utf-8" />
        <title><?= L::SITENAME ?> - <?= $TITLE ?></title>
        <?php if (!empty($HEADERS)) echo $HEADERS ?>
    </head>
    <body>
        <header>
            <div><?= L::SITENAME ?> - <?= $TITLE ?></div>
            <div><?= auth_link() ?></div>
        </header>
        <main>
            <?= $CONTENTS ?>
        </main>
        <footer>Copyright &copy; <?= date('Y') ?> <a href="/"><?= L::AUTHOR ?></a> - Powered by <a href="https://github.com/SushiBits/miniblog">miniblog</a></footer>
    </body>
</html>