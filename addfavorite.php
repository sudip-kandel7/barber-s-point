<?php

include 'sessionCheck.php';

$conn = new mysqli("localhost", "root", "", "barber_point");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sid'])) {
    $sid = (int)$_POST['sid'];
    $saved = filter_var($_POST['status'], FILTER_VALIDATE_BOOLEAN);
    $uid = $_SESSION['user']->uid;

    // echo $sid;
    if (!$saved) {
        $qry = "INSERT INTO favorites (uid, sid) VALUES ($uid, $sid)";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Added to Favorite']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Could not Add']);
        }
        exit;
    } else {
        $qry1 = "DELETE FROM favorites WHERE uid=$uid AND sid=$sid";
        if (mysqli_query($conn, $qry1)) {
            echo json_encode(['status' => 'success', 'msg' => 'Removed from Favorite']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Could not Remove']);
        }
    }
}
