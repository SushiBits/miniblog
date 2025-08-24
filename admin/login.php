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
        display: grid;
        grid-template-columns: auto auto;
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

    form h1 {
        grid-column: span 2;
    }

    form div.label {
        text-align: right;
    }

    form div.input input {
        width: 100%;
    }

    form div.errormsg, form div.buttons {
        grid-column: span 2;
    }

    form div.errormsg {
        color: red;
    }

    form div.buttons {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
</style>
<?php
$HEADERS = ob_get_clean();
ob_start();
?>
<form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
    <h1><?= $TITLE ?></h1>
    <div class="label"><label for="username"><?= L::Admin_USERNAME ?></label></div><div class="input"><input type="text" autocomplete="username" name="username" id="username" /></div>
    <div class="label"><label for="password"><?= L::Admin_PASSWORD ?></label></div><div class="input"><input type="password" autocomplete="current-password" name="password" id="password" /></div>
    <?php if (!empty($error)) { ?>
    <div class="errormsg"><?= htmlentities($error) ?></div>
    <?php } ?>
    <div class="buttons"><input type="submit" value="<?= L::Admin_LOGIN ?>" /></div>
</form>
<?php
$CONTENTS = ob_get_clean();
require_once dirname(__FILE__) .'/../include/templates/admin.php';
