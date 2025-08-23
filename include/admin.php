<?php
require_once dirname(__FILE__) . "/../include/utils.php";

/**
 * Check authentication status for the current page. Send to login page if not authenticated.
 * @return void
 */
function require_auth() {
    session_start();

    if (!empty($_SESSION['username'])) {
        return;
    } else {
        header('Location: /admin/login.php?return_uri=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

/**
 * Create a link to the login or logout page.
 * @return string HTML elements with the link to login, or a greeting and a link to logout.
 */
function auth_link(): string {
    session_start();

    if (!empty($_SESSION['username'])) {
        return htmlentities($_SESSION['username']) . ' · <a href="/admin/logout.php">' . L::Admin_LOGOUT . '</a>';
    } else {
        return L::Admin_NO_USER . ' · <a href="/admin/login.php?return_uri=' . urlencode($_SERVER['REQUEST_URI']) .'">' . L::Admin_LOGIN . '</a>';
    }
}
