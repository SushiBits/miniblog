<?php
require_once dirname(__FILE__) . "/include/config.php";

$TITLE = 'Home Page';

ob_start();
?>
<?php
$CONTENTS = ob_get_contents();
ob_end_clean();
require_once dirname(__FILE__) .'/templates/page.php';