<?php

header('Content-Type: application/json');


include 'sessionCheck.php';

$conn = mysqli_connect("localhost", "root", "", "barber_point");

$uid = $_SESSION['user']->uid;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $qry1 = "UPDATE users SET name = '$name', phone = '$phone', email = '$email', address = '$address' WHERE uid = $uid";

    if (mysqli_query($conn, $qry1)) {
        $_SESSION['user']->email = $email;
        echo json_encode(['status' => 'success', 'msg' => 'updated']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Database error: ' . mysqli_error($conn)]);
        exit;
    }
}

mysqli_close($conn);
