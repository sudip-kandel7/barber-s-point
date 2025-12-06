<?php

if (isset($_POST['email'])) {
    header('Content-Type: text/plain');

    $email = $_POST['email'];

    $conn = new mysqli("localhost", "root", "", "trypoint");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {

        echo "available";
    }

    $conn->close();
    exit();
}
