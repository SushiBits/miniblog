<?php

function require_auth() {
    session_start();

    if (!empty($_SESSION['username'])) {
        return;
    } else {
        header('Location: /admin/login.php?return_uri=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function auth_link(): string {
    session_start();

    if (!empty($_SESSION['username'])) {
        return htmlentities($_SESSION['username']) . '<a href="/admin/logout.php">Logout</a>';
    } else {
        return '<a href="/admin/login.php?return_uri=' . urlencode($_SERVER['REQUEST_URI']) .'">Login</a>';
    }
}
