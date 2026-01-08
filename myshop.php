<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include 'sessionCheck.php';

if ($_SESSION['user']->type !== 'barber') {
    header("Location: index.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uid = $_SESSION['user']->uid;
$sid = $_SESSION['user']->sid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if (isset($_POST['status'])) {
        $new_status = $_POST['status'];
        $qry = "UPDATE shop SET status = '$new_status' WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Status updated']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Failed to update']);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'start_service') {
        $bid = (int)$_POST['bid'];
        $qry = "UPDATE booking SET status = 'in_service', service_started_at = NOW() WHERE bid = $bid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Service started']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['bid']) && $_POST['totalD']) {
        $bid = (int)$_POST['bid'];
        $totalD = (int)$_POST['totalD'];

        $qry = "SELECT booking_number FROM booking WHERE bid = $bid";
        $result = mysqli_query($conn, $qry);
        $completed = mysqli_fetch_assoc($result);
        $booking_number = $completed['booking_number'];

        $qry1 = "UPDATE booking SET status = 'completed', completed_at = NOW() WHERE bid = $bid";

        $qry2 = "UPDATE booking 
                 SET booking_number = booking_number - 1 
                 WHERE sid = $sid 
                 AND booking_number > $booking_number
                 AND status IN ('waiting', 'in_service')";

        $qry3 = "UPDATE queue 
                 SET current_queue = GREATEST(0, current_queue - 1),
                     total_wait_time = SEC_TO_TIME(TIME_TO_SEC(total_wait_time) - ($totalD * 60))
                 WHERE sid = $sid";

        if (mysqli_query($conn, $qry1) && mysqli_query($conn, $qry2) && mysqli_query($conn, $qry3)) {
            echo json_encode(['status' => 'success', 'msg' => 'Service completed']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }
}

$qry1 = "SELECT 
    shop.*,
    queue.current_queue,
    queue.total_wait_time,
    COUNT(DISTINCT review.rid) as total_reviews
FROM shop
LEFT JOIN queue ON shop.sid = queue.sid
LEFT JOIN review ON shop.sid = review.sid
WHERE shop.sid = $sid
GROUP BY shop.sid";

$result1 = mysqli_query($conn, $qry1);
$shopData = mysqli_fetch_assoc($result1);

$qry2 = "SELECT 
    services.services_id,
    services.services_name,
    shop_services.price,
    shop_services.duration
FROM shop_services
JOIN services ON shop_services.services_id = services.services_id
WHERE shop_services.sid = $sid";

$result2 = mysqli_query($conn, $qry2);

$qry3 = "SELECT 
    booking.bid,
    booking.booking_number,
    booking.status,
    booking.total_duration,
    booking.total_price,
    booking.joined_at,
    booking.service_started_at,
    users.name as customer_name,
    users.phone as customer_phone
FROM booking
JOIN users ON booking.uid = users.uid
WHERE booking.sid = $sid 
AND booking.status IN ('waiting', 'in_service')
ORDER BY booking.booking_number ASC";

$result3 = mysqli_query($conn, $qry3);

$qry4 = "SELECT 
    booking.bid,
    booking.total_price,
    booking.completed_at,
    users.name as customer_name
FROM booking
JOIN users ON booking.uid = users.uid
WHERE booking.sid = $sid 
AND booking.status = 'completed'
AND DATE(booking.completed_at) = CURDATE()
ORDER BY booking.completed_at DESC";

$result4 = mysqli_query($conn, $qry4);

$qry5 = "SELECT SUM(total_price) as earnings 
FROM booking 
WHERE sid = $sid 
AND status = 'completed' 
AND DATE(completed_at) = CURDATE()";

$result5 = mysqli_query($conn, $qry5);
$data = mysqli_fetch_assoc($result5);
$todayEarnings = number_format($data['earnings'] ?? 0);

function getBookingServices($conn, $bid)
{
    $qry = "SELECT 
        services.services_name,
        shop_services.duration,
        shop_services.price
    FROM booking_services
    JOIN services ON booking_services.services_id = services.services_id
    JOIN booking ON booking_services.bid = booking.bid
    JOIN shop_services ON shop_services.services_id = services.services_id 
        AND shop_services.sid = booking.sid
    WHERE booking_services.bid = $bid";

    $result = mysqli_query($conn, $qry);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$qry6 = "SELECT 
    review.rid,
    review.review,
    review.date_added,
    users.name as customer_name
FROM review
JOIN users ON review.uid = users.uid
WHERE review.sid = $sid
ORDER BY review.date_added DESC
LIMIT 10";

$result6 = mysqli_query($conn, $qry6);

include 'header.php';
include 'navbar.php';
?>

<section class="bg-[#F1F4F9] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="bg-white rounded-lg p-6 mb-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <img src="<?php echo $shopData['photo']; ?>" alt="<?php echo $shopData['sname']; ?>"
                    class="w-full lg:w-48 h-48 rounded-lg border-2 border-yellow-400">

                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900"><?php echo $shopData['sname']; ?></h1>
                            <p class="text-gray-600 mt-1"><?php echo $shopData['saddress']; ?></p>
                        </div>

                        <div class="flex gap-2">
                            <span
                                class="px-4 py-2 rounded-lg text-sm font-semibold
                            <?php echo $shopData['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo ucfirst($shopData['status']); ?>
                            </span>
                            <button onclick="toggleStatus('<?php echo $shopData['status']; ?>')" class="px-4 py-2 rounded-lg font-semibold text-sm
                                <?php echo $shopData['status'] === 'open' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'; ?> 
                                text-white transition-colors">
                                <?php
                                if ($shopData['status'] === 'open') {
                                    echo 'Closing Shop';
                                } elseif ($shopData['status'] === 'closing') {
                                    echo 'Close Shop';
                                } else {
                                    echo 'Open Shop';
                                }
                                ?>

                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div
                            class="bg-white border-2 border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-lg transition-all hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm text-gray-600 font-medium">Current Queue</p>
                                <div class="bg-gray-100 p-2 rounded-full">
                                    <img src="./public/images/web/user.png" class="w-4 h-4" alt="">
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $shopData['current_queue'] ?? 0; ?>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">people waiting</p>
                        </div>

                        <div
                            class="bg-white border-2 border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-lg transition-all hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm text-gray-600 font-medium">Today's Earnings</p>
                                <div class="bg-gray-100 p-2 rounded-full">
                                    <img src="./public/images/web/upward.png" class="w-4 h-4" alt="">
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">Rs. <?php echo $todayEarnings; ?></p>
                            <p class="text-xs text-gray-500 mt-1">total revenue</p>
                        </div>

                        <div
                            class="bg-white border-2 border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-lg transition-all hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm text-gray-600 font-medium">Total Reviews</p>
                                <div class="bg-gray-100 p-2 rounded-full">
                                    <img src="./public/images/web/review.png" class="w-4 h-4" alt="">
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $shopData['total_reviews']; ?></p>
                            <p class="text-xs text-gray-500 mt-1">customer feedback</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-t-lg shadow-md">
            <div class="flex border-b overflow-x-auto">
                <button onclick="switchDiv('queue')" id="queue"
                    class="btn px-6 py-3 font-semibold border-b-2 border-yellow-400 text-yellow-500 whitespace-nowrap">
                    Queue Management
                </button>
                <button onclick="switchDiv('services')" id="services"
                    class="btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Services
                </button>
                <button onclick="switchDiv('history')" id="history"
                    class="btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Today's History
                </button>
                <button onclick="switchDiv('reviews')" id="reviews"
                    class="btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Reviews
                </button>
            </div>
        </div>

        <div id="Dqueue" class="divs bg-white rounded-b-lg shadow-md p-6">
            <?php if (mysqli_num_rows($result3) > 0): ?>
                <h2 class="text-2xl font-bold mb-6">Active Queue</h2>

                <?php
                $inService = null;
                $waiting = [];

                while ($booking = mysqli_fetch_assoc($result3)) {
                    if ($booking['status'] === 'in_service') {
                        $inService = $booking;
                    } else {
                        $waiting[] = $booking;
                    }
                }
                ?>

                <?php if ($inService):
                    $services = getBookingServices($conn, $inService['bid']);
                ?>
                    <div class="bg-green-50 border-2 border-green-400 rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-green-800">Currently in Service</h3>
                                <p class="text-green-600">Booking <?php echo $inService['booking_number']; ?></p>
                            </div>
                            <span class="px-4 py-2 bg-green-500 text-white rounded-full font-semibold">
                                In Progress
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Customer Name</p>
                                <p class="font-semibold text-lg"><?php echo $inService['customer_name']; ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-semibold"><?php echo $inService['customer_phone']; ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Service Started</p>
                                <p class="font-semibold">
                                    <?php echo date("g:i A", strtotime($inService['service_started_at'])); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Duration</p>
                                <p class="font-semibold"><?php echo $inService['total_duration']; ?> min</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Services:</p>
                            <div class="space-y-2">
                                <?php foreach ($services as $service): ?>
                                    <div class="flex justify-between bg-white px-3 py-2 rounded">
                                        <span><?php echo $service['services_name']; ?> (<?php echo $service['duration']; ?>
                                            min)</span>
                                        <span class="font-semibold">Rs. <?php echo $service['price']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button
                            onclick="completeService(<?php echo $inService['bid']; ?>, <?php echo $inService['total_duration']; ?>)"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition-all">
                            Complete Service
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (count($waiting) > 0): ?>
                    <h3 class="text-xl font-bold mb-4">Waiting Queue</h3>
                    <div class="space-y-4">
                        <?php foreach ($waiting as $booking):
                            $services = getBookingServices($conn, $booking['bid']);
                        ?>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span
                                            class="inline-block bg-yellow-300 text-white px-3 py-1 rounded-full text-sm font-semibold mb-2">
                                            Booking <?php echo $booking['booking_number']; ?>
                                        </span>
                                        <h4 class="font-bold text-lg"><?php echo $booking['customer_name']; ?></h4>
                                        <p class="text-sm text-gray-600"><?php echo $booking['customer_phone']; ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Duration</p>
                                        <p class="font-bold"><?php echo $booking['total_duration']; ?> min</p>
                                        <p class="text-sm text-gray-600 mt-1">Price</p>
                                        <p class="font-bold text-yellow-400">Rs.
                                            <?php echo number_format($booking['total_price']); ?></p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Services:</p>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($services as $service): ?>
                                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                <?php echo $service['services_name']; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <?php if ($booking['booking_number'] == 1 && !$inService): ?>
                                    <button onclick="startService(<?php echo $booking['bid']; ?>)"
                                        class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-lg transition-colors">
                                        Start Service
                                    </button>
                                <?php else: ?>
                                    <div class="text-center text-sm text-gray-500 py-2">
                                        Waiting in queue
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-16">
                    <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                    <p class="text-gray-500 text-lg">No customers in queue</p>
                    <p class="text-gray-400 text-sm mt-2">Customers will appear here when they book services</p>
                </div>
            <?php endif; ?>
        </div>


        <div id="Dservices" class="divs bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Shop Services</h2>

            <?php if (mysqli_num_rows($result2) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php while ($service = mysqli_fetch_assoc($result2)): ?>
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg"><?php echo $service['services_name']; ?></h3>
                                    <p class="text-sm text-gray-600 mt-1"><?php echo $service['duration']; ?> minutes</p>
                                </div>
                                <p class="text-xl font-bold text-yellow-400">Rs. <?php echo $service['price']; ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No services available</p>
            <?php endif; ?>
        </div>

        <div id="Dhistory" class="divs bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Today's Completed Bookings</h2>

            <?php if (mysqli_num_rows($result4) > 0): ?>
                <div class="space-y-4">
                    <?php while ($completed = mysqli_fetch_assoc($result4)): ?>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold"><?php echo $completed['customer_name']; ?></p>
                                    <p class="text-sm text-gray-600">
                                        <?php echo date("g:i A", strtotime($completed['completed_at'])); ?>
                                    </p>
                                </div>
                                <p class="font-bold text-yellow-400">Rs.
                                    <?php echo number_format($completed['total_price']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                    <p class="text-center text-lg">
                        <span class="text-gray-600">Total Earnings:</span>
                        <span class="font-bold text-yellow-500 text-2xl ml-2">Rs.
                            <?php echo number_format($todayEarnings); ?></span>
                    </p>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <p class="text-gray-500">No completed services today</p>
                </div>
            <?php endif; ?>
        </div>

        <div id="Dreviews" class="divs bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>

            <?php if (mysqli_num_rows($result6) > 0): ?>
                <div class="space-y-4">
                    <?php while ($review = mysqli_fetch_assoc($result6)): ?>
                        <div class="border rounded-lg p-4 flex items-start gap-3">
                            <img src="./public/images/web/profile.png" class="w-12 h-12 rounded-full" alt="">
                            <div class="flex-1 flex flex-col justify-between items-start">
                                <div>
                                    <p class="font-semibold"><?php echo $review['customer_name']; ?></p>
                                    <p class="text-xs text-gray-500">
                                        <?php echo date("M d, Y | g:i A", strtotime($review['date_added'])); ?>
                                    </p>
                                </div>
                                <p class="mt-2 text-gray-700"><?php echo $review['review']; ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <p class="text-gray-500">No reviews yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php
mysqli_close($conn);
include 'footer.php';
?>