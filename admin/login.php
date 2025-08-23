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
<form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
    <div><label for="username"><?= L::Admin_USERNAME ?></label><input type="text" autocomplete="username" name="username" id="username" /></div>
    <div><label for="password"><?= L::Admin_PASSWORD ?></label><input type="password" autocomplete="current-password" name="password" id="password" /></div>
    <?php if (!empty($error)) { ?>
    <div class="errormsg"><?= htmlentities($error) ?></div>
    <?php } ?>
    <div class="buttons"><input type="submit" value="<?= L::Admin_LOGIN ?>" /></div>
</form>
<?php
$CONTENTS = ob_get_clean();
require_once dirname(__FILE__) .'/../include/templates/admin.php';
