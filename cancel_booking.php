<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'sessionCheck.php';

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "barber_point");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['bid']) || !isset($data['totalD']) || !isset($data['sid'])) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit;
}

$bid    = (int)$data['bid'];
$totalD = (int)$data['totalD'];
$sid    = (int)$data['sid'];

$qry = "SELECT booking_number FROM booking WHERE bid = $bid";
$result = mysqli_query($conn, $qry);
$cancelled_booking = mysqli_fetch_assoc($result);
$cancelled_number = $cancelled_booking['booking_number'];

$qry1 = "UPDATE booking SET status = 'cancelled' WHERE bid = $bid";

$qry2 = "UPDATE booking 
         SET booking_number = booking_number - 1 
         WHERE sid = $sid 
         AND booking_number > $cancelled_number 
         AND status IN ('waiting', 'in_service')";

$qry3 = "UPDATE queue 
         SET current_queue = GREATEST(0, current_queue - 1),
             total_wait_time = SEC_TO_TIME(GREATEST(0, TIME_TO_SEC(total_wait_time) - ($totalD * 60)))
         WHERE sid = $sid";

$qry4 = "DELETE FROM booking_services WHERE bid = $bid";

$result1 = mysqli_query($conn, $qry1);
$result2 = mysqli_query($conn, $qry2);
$result3 = mysqli_query($conn, $qry3);
$result4 = mysqli_query($conn, $qry4);



if (!$result1 || !$result2 || !$result3 || !$result4) {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    exit;
}

echo json_encode([
    "status" => "success",
    "message" => "Booking cancelled successfully"
]);

$conn->close();
exit;
