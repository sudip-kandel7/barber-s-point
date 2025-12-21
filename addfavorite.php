<?php

include 'sessionCheck.php';

$conn = new mysqli("localhost", "root", "", "trypoint");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sid'])) {
    $sid = (int)$_POST['sid'];
    $uid = $_SESSION['user']->uid;

    echo $sid;

    $qry1 = "SELECT * FROM favorites WHERE uid=$uid AND sid=$sid";
    $result = mysqli_query($conn, $qry1);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Already added']);
        exit;
    }

    $qry2 = "INSERT INTO favorites (uid, sid) VALUES ($uid, $sid)";
    if (mysqli_query($conn, $qry2)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed']);
    }
    exit;
}
