<?php
include 'sessionCheck.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'not', 'msg' => 'Not logged in']);
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "barber_point");
if (!$conn) {
    die("failed db connection");
}

$uid = (int) $_SESSION['user']->uid;

$data = json_decode(file_get_contents("php://input"), true);


$sid = (int) $data['sid'];
$totalDuration = (int) $data['totalDuration'];
$totalPrice = (int) $data['totalPrice'];
$selected = $data['selected'];


$qry1 = "
SELECT bid 
FROM booking 
WHERE uid = $uid 
  AND sid = $sid 
  AND status = 'waiting'
";

$result1 = mysqli_query($conn, $qry1);

if (mysqli_num_rows($result1) > 0) {
    echo json_encode(['status' => 'good', 'msg' => 'Already exist']);
    exit;
}


$qry2 = "SELECT current_queue, total_wait_time FROM queue WHERE sid = $sid";
$result2 = mysqli_query($conn, $qry2);
$row2 = mysqli_fetch_assoc($result2);

if ($row2) {
    $newQ = $row2['current_queue'] + 1;
} else {
    $newQ = 1;
}


$qry3 = "
INSERT INTO booking 
(uid, sid, booking_number, total_duration, total_price, status)
VALUES 
($uid, $sid, $newQ, $totalDuration, $totalPrice, 'waiting')
";

if (!mysqli_query($conn, $qry3)) {
    echo json_encode(['status' => 'err', 'msg' => 'Booking failed']);
    exit;
}

$bid = mysqli_insert_id($conn);


foreach ($selected as $service) {
    $services_id = (int) $service['serviceId'];

    $qry4 = "INSERT INTO booking_services (bid, services_id) VALUES ($bid, $services_id) ";

    mysqli_query($conn, $qry4);
}


if ($row2) {
    $qry5 = "UPDATE queue SET current_queue = $newQ, total_wait_time = ADDTIME(total_wait_time,SEC_TO_TIME($totalDuration * 60))WHERE sid = $sid";
} else {
    $qry5 = "INSERT INTO queue (sid, current_queue, total_wait_time) VALUES ($sid, $newQ, SEC_TO_TIME($totalDuration * 60))";
}

mysqli_query($conn, $qry5);

echo json_encode(['status' => 'success', 'msg' => 'Booked']);
