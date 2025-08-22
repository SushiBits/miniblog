<?php
require_once dirname(__FILE__) . "/config.php";

function get_current_language(): string {
    return $GLOBALS['CONFIG']['DEFAULTLANG'];
}
