<?php
require_once dirname(__FILE__) . "/../include/admin.php";
require_once dirname(__FILE__) . "/../include/config.php";
require_once dirname(__FILE__) . "/../include/utils.php";
?>
<!DOCTYPE html>
<html lang="<?= get_current_language() ?>">
    <head>
        <meta charset="utf-8" />
        <title><?= $CONFIG['SITENAME'] ?> - <?= $TITLE ?></title>
        <?php if (!empty($HEADERS)) echo $HEADERS ?>
    </head>
    <body>
        <header>
            <div><?= $CONFIG['SITENAME'] ?> - <?= $TITLE ?></div>
            <div><?= auth_link() ?></div>
        </header>
        <main>
            <?= $CONTENTS ?>
        </main>
        <footer>Copyright &copy; <?= date('Y') ?> <?= $CONFIG['AUTHOR'] ?> - Powered by <a href="https://github.com/SushiBits/miniblog">miniblog</a></footer>
    </body>
</html>