<?php
session_start();
require_once 'User.php';

if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
    return;
}

if (isset($_COOKIE['user'])) {
    $cookieData = json_decode($_COOKIE['user'], true);

    if ($cookieData && isset($cookieData['email'])) {
        $_SESSION['user'] = new User(
            $cookieData['email'],
            $cookieData['type'],
            $cookieData['uid'],
            $cookieData['sid']
        );
        return;
    }
}

header("Location: login.php");
exit;
