<?php

session_start();
require_once 'User.php';

if (isset($_COOKIE['user'])) {
    $cookieData = json_decode($_COOKIE['user'], true);
    if ($cookieData) {
        $_SESSION['user'] = new User(
            $cookieData['email'],
            $cookieData['type'],
            $cookieData['uid'],
            $cookieData['sid']
        );
    }
}
