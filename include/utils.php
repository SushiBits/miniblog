<?php
require_once dirname(__FILE__) . "/config.php";
require_once dirname(__FILE__) ."/i18n.class.php";

$LANGDIR = dirname(__FILE__) . "/languages";
$LANGCACHE = dirname(__FILE__) . "/.langcache";
if (!is_dir($LANGCACHE))
    mkdir($LANGCACHE,0777, true);

$I18N = new i18n($LANGDIR . DIRECTORY_SEPARATOR . '{LANGUAGE}.ini', $LANGCACHE, $GLOBALS['CONFIG']['DEFAULTLANG']);
$hostlang = get_host_language();
if (!empty($hostlang))
    $I18N->setForcedLang($hostlang);
$I18N->init();

if ($hostlang != get_current_language()) {
    header('Location: ' . (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . get_current_language() . "." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 307);
    exit;
}

function get_available_languages(): array {
    $languages = glob($GLOBALS['LANGDIR'] . DIRECTORY_SEPARATOR . '*.ini');
    return array_map(function(string $name): string { return basename($name, ".ini"); }, $languages);
}

function get_host_language(): string|null {
    $host_language = reset(explode('.', $_SERVER['HTTP_HOST']));
    if (in_array($host_language, get_available_languages()))
        return $host_language;
    else
        return null;
}

function get_current_language(): string {
    return $GLOBALS['I18N']->getAppliedLang();
}
