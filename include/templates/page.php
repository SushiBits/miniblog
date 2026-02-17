<?php
require_once dirname(__FILE__) . "/../config.php";
require_once dirname(__FILE__) . "/../utils.php";

session_start();
?>
<!DOCTYPE html>
<html lang="<?= get_current_language() ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= !empty($TITLE) ? "$TITLE · " : "" ?><?= L::SITENAME ?></title>
        <link href="/images/harmonyos-sans/harmonyos-sans.css" rel="stylesheet" />
        <link href="/images/index.css" rel="stylesheet" />
        <?php if (!empty($HEADERS)) echo $HEADERS ?>
    </head>
    <body>
        <header>
            <div><a href="/" style="text-decoration: none"><?= L::SITENAME ?></a><?= !empty($TITLE) ? " · $TITLE" : "" ?></div>
            <?php if (!empty($_SESSION['username'])) { ?>
            <div class="authlink"><a href="/admin/"><?= L::Admin_CONTROL_PANEL ?></a></div>
            <?php } ?>
        </header>
        <main>
            <?= $CONTENTS ?>
        </main>
        <footer>Copyright &copy; <?= date('Y') ?> <a href="/"><?= L::AUTHOR ?></a>
        <?php if (!empty($CONFIG['MIITBEIAN'])) { ?>· <a href="http://beian.miit.gov.cn/"><?= htmlspecialchars($CONFIG['MIITBEIAN']) ?></a><?php } ?>
        <?php if (!empty($CONFIG['MPSBEIAN'])) { ?>· <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?= preg_replace('/[^0-9]/', '', $CONFIG['MPSBEIAN']) ?>"><img style="height: 1em" src="/images/mpsbeian.png" /><?= htmlspecialchars($CONFIG['MPSBEIAN']) ?></a><?php } ?>
        · Powered by <a href="https://github.com/SushiBits/miniblog">miniblog</a></footer>
    </body>
</html>