<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['password'];

$sql = "INSERT INTO users (name, email, password)
        VALUES ('$name', '$email', '$pass')";

if (mysqli_query($conn, $sql)) {
    echo "Registration successful";
} else {
    echo "Error: " . mysqli_error($conn);
}
