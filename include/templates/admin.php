<?php
require_once dirname(__FILE__) . "/../admin.php";
require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/../utils.php";

session_start();
?>
<!DOCTYPE html>
<html lang="<?= get_current_language() ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= L::SITENAME ?><?= !empty($TITLE) ? " · $TITLE" : "" ?></title>
        <link href="/images/harmonyos-sans/harmonyos-sans.css" rel="stylesheet" />
        <link href="/images/admin.css" rel="stylesheet" />
        <?php if (!empty($HEADERS)) echo $HEADERS ?>
    </head>
    <body>
        <header>
            <div><a href="/" style="text-decoration: none"><?= L::SITENAME ?></a><?= !empty($TITLE) ? " · $TITLE" : "" ?></div>
            <div class="authlink"><?= auth_link() ?></div>
        </header>
        <main>
            <?= $CONTENTS ?>
        </main>
        <footer>Copyright &copy; <?= date('Y') ?> <a href="/"><?= L::AUTHOR ?></a> - Powered by <a href="https://github.com/SushiBits/miniblog">miniblog</a></footer>
    </body>
</html>