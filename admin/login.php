<?php
require_once dirname(__FILE__) . "/../include/admin.php";
require_once dirname(__FILE__) . "/../include/config.php";
require_once dirname(__FILE__) . "/../include/utils.php";

$TITLE = L::Admin_LOGIN;

$error = '';

$username = $_POST['username'];
$password = $_POST['password'];
$return_uri = $_GET['return_uri'];
if (empty($return_uri)) $return_uri = '/admin/';

session_start();
if (!empty($_SESSION['username'])) {
    header('Location: ' . $return_uri);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    if (pam_auth($username, $password, $error)) {
        $_SESSION['username'] = $username;
        header('Location: ' . $return_uri);
        exit;
    }
}
ob_start();
?>
<style type="text/css">
    form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
        padding: 12px;
        border-width: 1px;
        border-style: solid;
        border-radius: 12px;
        border-color: #333333;
        background-color: white;
        color: black;
        max-width: 360px;
    }

    h1 {
        padding: 12px;
        margin: 0px;
        font-size: 2.5em;
        text-align: center;
    }

    input {
        font-family: 'HarmonyOS Sans', 'HarmonyOS Sans SC', '微软雅黑', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1em;
    }

    form h1 {
        grid-column: span 2;
    }

    form div {
        margin: 8px;
    }

    form div.textbox {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    form div.textbox input {
        height: 36px;
        width: 100%;
        background-repeat: no-repeat;
        background-position-x: 4px;
        background-position-y: center;
        padding-left: 36px;
        border-style: solid;
        border-color: #333333;
        border-radius: 6px;
        border-width: 1px;
    }

    form div.textbox input:focus-visible {
        outline: none;
    }

    form div.textbox input.username {
        background-image: url("/images/ic_public_contacts.svg");
        border-radius: 6px 6px 0px 0px;
        border-bottom-style: none;
    }

    form div.textbox input.password {
        background-image: url("/images/ic_public_lock.svg");
        border-radius: 0px 0px 6px 6px;
    }

    form div.errormsg {
        color: red;
        text-align: center;
    }

    form div.buttons {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    form div.buttons input.login {
        border-style: solid;
        border-width: 2px;
        border-color: #333333;
        background-color: #eeeeee;
        height: 36px;
        padding-left: 12px;
        padding-right: 12px;
        border-radius: 6px;
    }

    form div.buttons input.login:hover {
        background-color: #333333;
        color: white;
    }
</style>
<?php
$HEADERS = ob_get_clean();
ob_start();
?>
<form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
    <h1><?= $TITLE ?></h1>
    <div class="textbox"><input class="username" type="text" autocomplete="username" name="username" id="username" placeholder="<?= L::Admin_USERNAME ?>" /></div>
    <div class="textbox"><input class="password" type="password" autocomplete="current-password" name="password" id="password" placeholder="<?= L::Admin_PASSWORD ?>" /></div>
    <?php if (!empty($error)) { ?>
    <div class="errormsg"><?= htmlentities($error) ?></div>
    <?php } ?>
    <div class="buttons"><input class="login" type="submit" value="<?= L::Admin_LOGIN ?>" /></div>
</form>
<?php
$CONTENTS = ob_get_clean();
require_once dirname(__FILE__) .'/../include/templates/admin.php';
