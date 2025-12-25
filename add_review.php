<?php
include 'sessionCheck.php';

$conn = new mysqli("localhost", "root", "", "trypoint");


if (!isset($_POST['sid']) && !isset($_POST['reviewtxt'])) {
    exit;
}

$uid = $_SESSION['user']->uid;
$sid = $_POST['sid'];
$reviewtxt = $_POST['reviewtxt'];


$qry = "INSERT INTO review (uid,sid,review) values($uid,$sid,'$reviewtxt')";

if (mysqli_query($conn, $qry)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}

exit;
