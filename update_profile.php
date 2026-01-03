<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 0); 
// ini_set('log_errors', 1);

include 'sessionCheck.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'msg' => 'Invalid request']);
    exit;
}

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->uid)) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'msg' => 'Not logged in']);
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "barber_point");

if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'msg' => 'Connection failed']);
    exit;
}

$uid = $_SESSION['user']->uid;

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];

$qry1 = "UPDATE users SET name = '$name', phone = '$phone', email = '$email', address = '$address' WHERE uid = $uid";

header('Content-Type: application/json');

if (mysqli_query($conn, $qry1)) {
    $_SESSION['user']->email = $email;
    echo json_encode(['status' => 'success', 'msg' => 'updated']);
    mysqli_close($conn);
    exit;
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Database error: ' . mysqli_error($conn)]);
    mysqli_close($conn);
    exit;
}
