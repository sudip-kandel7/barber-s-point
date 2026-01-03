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
            $cookieData['sid'] ?? null
        );
        return;
    }
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'msg' => 'Not authenticated']);
    exit;
}

header("Location: login.php");
exit;
