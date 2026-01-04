<?php
// include 'sessionCheck.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "barber_point");

// update reeview for a shop

if (isset($_GET['review']) && isset($_GET['rid'])) {
    header('Content-Type: application/json');

    $review = $_GET['review'];
    $rid = $_GET['rid'];

    $qryr = "UPDATE review SET review = '$review' WHERE rid = '$rid'";

    if (mysqli_query($conn, $qryr)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => mysqli_error($conn)
        ]);
    }
    exit;
}

// delete review for a shop

if (isset($_GET['rid'])) {
    header('Content-Type: application/json');

    $rid = $_GET['rid'];

    $qryd = "DELETE  FROM review WHERE rid = '$rid'";

    if (mysqli_query($conn, $qryd)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => mysqli_error($conn)
        ]);
    }
    exit;
}

if (isset($_POST['sid'])) {
    header('Content-Type: application/json');
    $sid = (int) $_POST['sid'];
    $uid = $_SESSION['user']->uid;
    if (mysqli_query($conn, "DELETE FROM favorites WHERE uid = '$uid' AND sid = '$sid'")) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
    exit;
}


include 'header.php';
include 'navbar.php';


$user = $_SESSION['user'];
$uid = $user->uid;

// qry to select user info 
$qry = "
SELECT 
    users.name,
    users.email,
    users.phone,
    users.address,
    users.created_at,
    COUNT(review.rid) AS total_reviews
FROM users 
LEFT JOIN review ON review.uid = users.uid
WHERE users.email = '{$user->email}'
GROUP BY users.uid
";

$result = mysqli_query($conn, $qry);

$rows = mysqli_fetch_assoc($result);

// qry to select review of a user
$qry2 = " 
SELECT 
    review.rid,
    review.review,
    review.date_added,
    shop.sname,
    shop.saddress,
    shop.photo
FROM review 
LEFT JOIN shop ON review.sid = shop.sid
WHERE review.uid = (SELECT uid FROM users WHERE email = '{$user->email}')";


$result2 = mysqli_query($conn, $qry2);
$rows2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

// qry to select fav shop of a user
$qry3 = "SELECT 
    shop.sname,
    shop.saddress,
    shop.sid,
    shop.photo,
    shop.status,
    queue.current_queue,
    queue.total_wait_time
FROM favorites
JOIN shop ON favorites.sid = shop.sid
LEFT JOIN queue ON shop.sid = queue.sid
WHERE favorites.uid = (SELECT uid FROM users WHERE email = '{$user->email}');
";

$result3 = mysqli_query($conn, $qry3);

// qry to select booking info of a user
$qry4 = "SELECT 
    booking.bid,
    booking.booking_number,
    booking.status,
    booking.total_duration,
    booking.total_price,
    booking.joined_at,
    booking.service_started_at,
    booking.completed_at,
    shop.sid,
    shop.sname,
    shop.saddress,
    shop.photo,
    queue.current_queue,
    queue.total_wait_time
FROM booking 
LEFT JOIN shop ON booking.sid = shop.sid
LEFT JOIN queue ON queue.sid = shop.sid 
WHERE booking.uid = '$uid'
ORDER BY booking.joined_at DESC";

$result4 = mysqli_query($conn, $qry4);

function getBookingServices($conn, $bid)
{
    $qry5 = "SELECT 
        services.services_name,
        shop_services.duration,
        shop_services.price
    FROM booking_services
    JOIN services ON booking_services.services_id = services.services_id
    JOIN booking ON booking_services.bid = booking.bid
    JOIN shop_services ON shop_services.services_id = services.services_id 
        AND shop_services.sid = booking.sid
    WHERE booking_services.bid = '$bid'";

    $result = mysqli_query($conn, $qry5);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<section class="">
    <div class="bg-[#F1F4F9] min-h-screen w-full px-5 py-5 flex flex-col items-center ">

        <div
            class="w-full bg-white rounded-lg shadow-md max-w-6xl p-4 md:p-8 flex items-center justify-between mt-6 mb-4">
            <div class="flex gap-4 items-center">
                <img src="./public/images/web/profile.png" class="w-24 h-24" alt="">
                <div>
                    <div>
                        <h2 class="text-3xl font-bold"><?php echo $rows['name']; ?></h2>
                        <div class="flex gap-2 mt-2 items-center">
                            <img src="./public/images/web/calendar.png" class=" w-4 h-4" alt="">
                            <span class="text-gray-500 text-md">Member since
                                <?php echo date("M j, Y", strtotime($rows['created_at'])); ?>
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="inline-block p-3">
                            <span
                                class="block text-2xl text-yellow-600 text-center"><?php echo $rows['total_reviews']; ?></span>
                            <p class="text-sm text-gray-600 whitespace-nowrap">Total Reviews</p>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="viewp()"
                class="flex items-center justify-center  whitespace-nowrap border hover:cursor-pointer hover:border-none hover:translate-x-0.5 hover:-translate-y-0.5 hover:bg-yellow-300 text-sm border-gray-200 rounded-md font-medium  h-10 px-4 py-2 gap-2">
                <img src="./public/images/web/edit.png" class="w-4 h-4" alt="">
                <span>Edit Profile</span>
            </div>
        </div>

        <div class="w-full bg-white rounded-lg shadow-md max-w-6xl p-4 md:p-8  mt-6 mb-4">
            <h2 class="text-3xl font-bold">Contact Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-11 mt-4">
                <div class="flex gap-3 items-center">
                    <img src="./public/images/web/email.png" class="w-6 h-6  alt="">
                    <div>
                        <p class=" text-sm text-gray-600">Email</p>
                    <p class="font-medium text-gray-900"><?php echo $rows['email']; ?></p>
                </div>
            </div>
            <div class=" flex gap-3 items-center">
                <img src=" ./public/images/web/phone.png" class="w-6 h-6  alt="">
                    <div>
                        <p class=" text-sm text-gray-600">Phone</p>
                <p class="font-medium text-gray-900"><?php echo $rows['phone']; ?></p>
            </div>
        </div>
        <div class=" flex gap-3 items-center">
            <img src=" ./public/images/web/map.png" class="w-6 h-6  alt="">
                    <div>
                        <p class=" text-sm text-gray-600">Location</p>
            <p class="font-medium text-gray-900"><?php echo $rows['address']; ?></p>
        </div>
    </div>
    </div>

    </div>

    <div class="bg-[#c7d8f3] w-full rounded-t-lg py-0.5 px-1 shadow-md max-w-6xl flex items-center justify-evenly">
        <button onclick="toggleDiv('booking')" id="mybooking" class="flex items-center justify-center text-black bg-[#f1f5f9] rounded-md whitespace-nowrap px-32 py-1 text-sm
            font-medium gap-2 hover:cursor-pointer">
            <img id="imgb" src=" ./public/images/web/bookingB.png" class="w-6 h-6" alt="">
            <span>My Booking</span>
        </button>
        <button onclick="toggleDiv('review')" id="myreview" class="flex items-center justify-center text-gray-500 rounded-md whitespace-nowrap px-32 py-1 text-sm
            font-medium gap-2 hover:cursor-pointer">
            <img id="imgr" src=" ./public/images/web/time.png" class="w-6 h-6" alt="">
            <span>My Reviews</span>
        </button>
        <button onclick="toggleDiv('fav')" id="myfav" class="flex items-center justify-center text-gray-500 whitespace-nowrap rounded-md px-32 py-1 text-sm
            font-semibold gap-2 hover:cursor-pointer">
            <img id="imgf" src=" ./public/images/web/favoriteG.png" class="w-6 h-6" alt="">
            <span>Favorite Shops</span>
        </button>
    </div>

    <!-- div to show booking of a user  -->

    <div id="bookingD" class="w-full max-w-6xl mt-1 p-4 md:p-8 bg-white rounded-lg shadow-md">
        <?php if (mysqli_num_rows($result4) > 0): ?>
            <h2 class="text-2xl font-bold mb-4">My Bookings</h2>

            <?php
            $activeBookings = [];
            $completedBookings = [];

            while ($booking = mysqli_fetch_assoc($result4)) {
                if ($booking['status'] == 'waiting' || $booking['status'] == 'in_service') {
                    $activeBookings[] = $booking;
                } else {
                    $completedBookings[] = $booking;
                }
            }
            ?>

            <?php if (count($activeBookings) > 0): ?>
                <h3 class="text-xl font-semibold mb-4">Active Bookings</h3>
                <?php foreach ($activeBookings as $booking):
                    $services = getBookingServices($conn, $booking['bid']);
                ?>
                    <div id="<?php echo $booking['bid'] ?>"
                        class="border rounded-lg border-<?php echo $booking['status'] == 'in_service' ? 'green' : 'yellow'; ?>-300  w-full mb-4 transition-all duration-300 hover:shadow-md">
                        <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-b">
                            <div class="flex items-center gap-3">
                                <img src="<?php echo $booking['photo']; ?>" alt="image of shop"
                                    class="w-12 h-12 rounded-lg object-cover border-2 <?php echo $booking['status'] == 'in_service' ? 'border-green-300' : 'border-yellow-300' ?>" />
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo $booking['sname']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $booking['saddress']; ?></p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $booking['status'] == 'in_service' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo ucfirst($booking['status']); ?>
                            </span>
                        </div>

                        <div class="px-4 py-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center gap-2">
                                <img src="./public/images/web/ticket.png" class="w-5 h-5" alt="">
                                <div>
                                    <p class="text-xs text-gray-500">Booking Number</p>
                                    <p class="font-bold text-lg text-yellow-600">#<?php echo $booking['booking_number']; ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <img src="./public/images/web/timeB.png" class="w-5 h-5" alt="">
                                <div>
                                    <p class="text-xs text-gray-500">Est. Wait Time</p>
                                    <p class="font-semibold">
                                        <?php
                                        if ($booking['status'] == 'in_service') {
                                            echo 0;
                                        } else {
                                            // Calculate actual wait time based on position in queue
                                            $queuePosition = $booking['booking_number'];
                                            $currentQueue = $booking['current_queue'];

                                            if ($queuePosition == 1) {
                                                echo 0;
                                            } else {
                                                $qry = "SELECT SUM(total_duration) as wait_time 
                                  FROM booking 
                                  WHERE sid = {$booking['sid']} 
                                  AND booking_number < $queuePosition 
                                  AND status = 'waiting'";
                                                $result_ahead = mysqli_query($conn, $qry);
                                                $row = mysqli_fetch_assoc($result_ahead);
                                                echo $row['wait_time'] ?? 0;
                                            }
                                        }
                                        ?> min
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <img src="./public/images/web/user.png" class="w-5 h-5" alt="">
                                <div>
                                    <p class="text-xs text-gray-500">Ahead of You</p>
                                    <p class="font-semibold">
                                        <?php
                                        if ($booking['status'] == 'in_service') {
                                            echo 0;
                                        } else {
                                            $queuePosition = $booking['booking_number'];

                                            if ($queuePosition == 1) {
                                                echo 0;
                                            } else {
                                                $qry_count = "SELECT COUNT(*) as people_ahead 
                                  FROM booking 
                                  WHERE sid = {$booking['sid']} 
                                  AND booking_number < $queuePosition 
                                  AND status = 'waiting'";
                                                $result_count = mysqli_query($conn, $qry_count);
                                                $row_count = mysqli_fetch_assoc($result_count);
                                                echo $row_count['people_ahead'] ?? 0;
                                            }
                                        }
                                        ?> people
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Selected Services:</p>
                            <div class="space-y-2">
                                <?php foreach ($services as $service): ?>
                                    <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                                        <span class="text-sm"><?php echo $service['services_name']; ?>
                                            (<?php echo $service['duration']; ?> min)</span>
                                        <span class="text-sm font-semibold">Rs. <?php echo $service['price']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-3 pt-3 border-t flex justify-between items-center">
                                <span class="font-semibold">Total Price:</span>
                                <span class="text-lg font-bold text-yellow-600">Rs. <?php echo $booking['total_price']; ?></span>
                            </div>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>Duration: <?php echo $booking['total_duration']; ?> min</span>
                                <span class="text-sm">Joined at:
                                    <?php echo date("M d, Y | g:i A", strtotime($booking['joined_at'])); ?></span>
                            </div>
                        </div>

                        <?php if ($booking['status'] == 'waiting'): ?>
                            <div class="px-4 pb-4">
                                <button
                                    onclick="cancelBooking(<?php echo $booking['bid']; ?>,<?php echo $booking['sid'] ?>,<?php echo $booking['total_duration']; ?>)"
                                    class="w-full flex items-center justify-center gap-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-md transition-colors">
                                    <img src="./public/images/web/cancel.png" class="w-6 h-6" alt=""> Cancel Booking
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($booking['status'] == 'in_service'): ?>
                            <div class="px-4 pb-4">
                                <div class="bg-green-50 border border-green-200 rounded-md p-3 flex items-center gap-2">
                                    <img src="./public/images/web/correct.png" class="w-6 h-6" />
                                    <span class="text-sm text-green-700 font-medium">Your service is now in progress</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (count($completedBookings) > 0): ?>
                <h3 class="text-xl font-semibold mb-4 mt-8">Booking History</h3>
                <?php foreach ($completedBookings as $booking):
                    $services = getBookingServices($conn, $booking['bid']);
                ?>
                    <div
                        class="border rounded-lg border-gray-200 w-full mb-4 opacity-75 hover:opacity-100  transition-all duration-300 hover:shadow-md">
                        <div class="bg-gray-50 px-4 py-3 flex items-center justify-between gap-3 border-b">
                            <div class="flex gap-3 items-center">
                                <img src="<?php echo $booking['photo']; ?>" alt="shop"
                                    class="w-12 h-12 rounded-lg object-cover border-2 border-gray-300" />
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo $booking['sname']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $booking['saddress']; ?></p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $booking['status'] == 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo ucfirst($booking['status']); ?>
                            </span>
                        </div>

                        <div class="px-4 py-4">
                            <div class="flex justify-between mb-3">
                                <span class="text-sm text-gray-500">Booking #<?php echo $booking['booking_number']; ?></span>
                                <span class="text-sm text-gray-500">
                                    <?php
                                    $date = $booking['status'] == 'completed' ? $booking['completed_at'] : $booking['joined_at'];
                                    echo date("M d, Y | g:i A", strtotime($date));
                                    ?>
                                </span>
                            </div>

                            <div class="space-y-1 mb-3">
                                <?php foreach ($services as $service): ?>
                                    <div class="flex justify-between text-sm">
                                        <span><?php echo $service['services_name']; ?></span>
                                        <span>Rs. <?php echo $service['price']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="pt-2 border-t flex justify-between font-semibold">
                                <span>Total:</span>
                                <span>Rs. <?php echo $booking['total_price']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php else: ?>
            <div class="text-center py-16">
                <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                <p class="text-gray-500 text-lg">You haven't made any booking yet</p>
                <p class="text-gray-400 text-sm mt-2"><a href="./index.php" class="text-yellow-300">Visit a
                        shop</a> and book any service!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- // my reviews  -->
    <div id="reviewD" class="w-full max-w-6xl mt-1 p-4 md:p-8 bg-white rounded-lg shadow-md hidden">
        <?php if (mysqli_num_rows($result2) > 0): ?>
            <h2 class="text-2xl font-bold mb-6">My Reviews</h2>
            <div class="r">
                <?php foreach ($rows2 as $rows): ?>
                    <div id="review-shop-<?php echo $rows['rid']; ?>"
                        class="border rounded-lg border-gray-300 w-full mb-4 overflow-y-auto transition-all duration-300 hover:shadow-md">

                        <div class="bg-gray-50 px-4 py-3 flex items-center gap-3 border-b">
                            <img src="<?php echo $rows['photo'] ?>" alt="shop"
                                class="w-12 h-12 rounded-lg object-cover border-2 border-yellow-300" />
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900"><?php echo $rows['sname'] ?></p>
                                <p class="text-sm text-gray-500"><?php echo $rows['saddress'] ?></p>
                            </div>
                            <span class="text-xs text-gray-500"><?php
                                                                $datetime = $rows['date_added'];
                                                                echo date("M d, Y | g:i A", strtotime($datetime));
                                                                ?>
                            </span>
                        </div>

                        <div class="px-4 py-4">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <textarea id="review<?php echo $rows['rid']; ?>" disabled
                                        class="w-full p-3 border border-gray-300 rounded-md resize-none text-gray-700 bg-gray-50 disabled:bg-gray-50  focus:bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all"
                                        rows="3"><?php echo $rows['review'] ?></textarea>
                                </div>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="changer(this, 'edit')" data-rid="<?php echo $rows['rid']; ?>"
                                    class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-md">

                                    <img id="scrE<?php echo $rows['rid']; ?>" src="./public/images/web/edit.png"
                                        class="w-4 h-4 edit-icon" alt="edit">
                                    <span id="edit<?php echo $rows['rid']; ?>">Edit</span>

                                </button>

                                <button type="button" onclick="changer(this, 'delete')" data-rid="<?php echo $rows['rid']; ?>"
                                    class="delete flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-md">

                                    <img src="./public/images/web/remove.png" class="w-4 h-4 invert">

                                    <span>Delete</span>
                                </button>

                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>

        <?php else: ?>

            <div class="text-center py-16">
                <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                <p class="text-gray-500 text-lg">You haven't written any reviews yet</p>
                <p class="text-gray-400 text-sm mt-2"><a href="./index.php" class="text-yellow-300">Visit a
                        shop</a> and share your experience!</p>
            </div>
        <?php endif ?>
    </div>


    <!-- // favorite shops  -->
    <div id="favD" class="w-full max-w-6xl mt-1 p-4 md:p-8 bg-white rounded-lg shadow-md hidden">
        <?php if (mysqli_num_rows($result3) > 0): ?>
            <div>
                <h2 class="text-2xl font-bold mb-6">Favorite Shops</h2>


                <div class="w-full mt-3 sm:mt-4 p-2 sm:p-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                    <?php while ($rows3 = mysqli_fetch_assoc($result3)) { ?>


                        <div id="fav-shop-<?php echo $rows3['sid']; ?>"
                            class="w-full max-w-[450px] mx-auto relative bg-white shadow-md rounded-lg hover:-translate-y-1 hover:shadow-xl transition-all group">

                            <img src="<?php echo $rows3['photo']; ?>" alt="<?php echo $rows3['sname']; ?>"
                                class="w-full h-48 sm:h-56 object-cover rounded-t-lg">

                            <p
                                class="bg-opacity-70 px-2 sm:px-2.5 font-semibold absolute top-2 sm:top-3 right-2 sm:right-3 rounded-full 
                     inline-flex items-center py-0.5 text-[10px] sm:text-xs cursor-pointer bg-yellow-400 group-hover:bg-<?php echo $statusColor; ?>-500">
                                <?php echo ucfirst($rows3['status']); ?>
                            </p>


                            <div class="px-3 sm:px-4 py-3">

                                <p
                                    class="text-base sm:text-lg font-semibold text-start pl-2 sm:pl-3 group-hover:text-yellow-400 truncate">
                                    <?php echo $rows3['sname']; ?>
                                </p>

                                <div class="flex items-center gap-1 mt-1">
                                    <img src="./public/images/web/shop-location.png" class="w-4 h-4 flex-shrink-0" alt="">
                                    <p class="text-xs sm:text-sm text-gray-500 truncate">
                                        <?php echo $rows3['saddress']; ?>
                                    </p>
                                </div>

                                <div class="flex flex-col sm:flex-row justify-between gap-2 sm:gap-0 mt-3">

                                    <div class="flex gap-1.5 sm:gap-2 items-center">
                                        <img src="./public/images/web/user.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0"
                                            alt="">
                                        <p class="text-xs sm:text-sm text-gray-500">
                                            Queue:
                                            <span class="text-yellow-400 font-semibold">
                                                <?php echo $rows3['current_queue']; ?> People
                                            </span>
                                        </p>
                                    </div>

                                    <div class="flex gap-1.5 sm:gap-2 items-center">
                                        <img src="./public/images/web/time.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0"
                                            alt="">
                                        <p class="text-xs sm:text-sm text-gray-500">
                                            Est. wait:
                                            <span class="text-yellow-400 font-semibold">
                                                <?php echo $rows3['total_wait_time']; ?> Min
                                            </span>
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <button onclick="viewf('<?php echo $rows3['sid']; ?>')"
                                class="w-[96%] text-xs sm:text-sm font-semibold rounded-md bg-[#f8f9fa] border py-2 mb-4  group-hover:bg-yellow-400 group-hover:text-white group-hover:shadow-md mx-2 mt-3  transition-all">
                                View Details
                            </button>

                        </div>



                    <?php } ?>
                </div>


            </div>
        <?php else: ?>
            <!-- No fav shops  -->
            <div class="text-center py-16">
                <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                <p class="text-gray-500 text-lg">You haven no favorite shops yet</p>
                <p class="text-gray-400 text-sm mt-2"><a href="./index.php" class="text-yellow-300">Visit a
                        shop</a> and add to your favorite!</p>
            </div>
        <?php endif ?>

    </div>


    </div>
</section>

<?php include 'footer.php' ?>