<?php
require_once dirname(__FILE__) . "/config.php";
require_once dirname(__FILE__) ."/contrib/i18n.class.php";

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
    header('Location: ' . (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . get_current_language() . "." . $GLOBALS['CONFIG']['HOSTNAME'] . $_SERVER['REQUEST_URI'], true, 307);
    exit;
}

function get_available_languages(): array {
    $languages = glob($GLOBALS['LANGDIR'] . DIRECTORY_SEPARATOR . '*.ini');
    return array_map(function(string $name): string { return basename($name, ".ini"); }, $languages);
}

function get_host_language(): ?string {
    $host = $_SERVER['HTTP_HOST'];
    if (!str_ends_with($host, $GLOBALS['CONFIG']['HOSTNAME']))
        return null;

    $host = substr($host, 0, -strlen($GLOBALS['CONFIG']['HOSTNAME']));
    if (str_ends_with($host, '.'))
        $host = substr($host, 0, -1);

    if (in_array($host, get_available_languages()))
        return $host;
    else
        return null;
}

function get_current_language(): string {
    return $GLOBALS['I18N']->getAppliedLang();
}

function get_language_name(string $lang): string {
    static $langnames = [];
    if (isset($langnames[$lang]))
        return $langnames[$lang];

    $langfile = $GLOBALS['LANGDIR'] . DIRECTORY_SEPARATOR . $lang . '.ini';
    if (!file_exists($langfile) || !is_readable($langfile))
        return $langnames[$lang] = $lang;

    $langdoc = parse_ini_file($langfile, true);
    if (empty($langdoc))
        return $langnames[$lang] = $lang;
    
    return $langnames[$lang] = $langdoc['LANGNAME'] ?? $lang;
}
