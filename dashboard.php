<?php
include 'sessionCheck.php';

// Verify user is an admin
if ($_SESSION['user']->type !== 'admin') {
    header("Location: index.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Approve shop
    if (isset($_POST['action']) && $_POST['action'] === 'approve_shop') {
        $sid = (int)$_POST['sid'];
        $admin_uid = $_SESSION['user']->uid;

        $qry = "UPDATE shop SET status = 'open', approved_at = NOW(), approved_by = $admin_uid WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop approved']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    // Reject shop
    if (isset($_POST['action']) && $_POST['action'] === 'reject_shop') {
        $sid = (int)$_POST['sid'];

        $qry = "UPDATE shop SET status = 'suspended' WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop rejected']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    // Suspend shop
    if (isset($_POST['action']) && $_POST['action'] === 'suspend_shop') {
        $sid = (int)$_POST['sid'];

        $qry = "UPDATE shop SET status = 'suspended' WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop suspended']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    // Delete shop
    if (isset($_POST['action']) && $_POST['action'] === 'delete_shop') {
        $sid = (int)$_POST['sid'];

        $qry = "DELETE FROM shop WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    // Delete user
    if (isset($_POST['action']) && $_POST['action'] === 'delete_user') {
        $uid = (int)$_POST['uid'];

        $qry = "DELETE FROM users WHERE uid = $uid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'User deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    // Delete review
    if (isset($_POST['action']) && $_POST['action'] === 'delete_review') {
        $rid = (int)$_POST['rid'];

        $qry = "DELETE FROM review WHERE rid = $rid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Review deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }
}

// Get statistics
$statsQry = "SELECT 
    (SELECT COUNT(*) FROM users WHERE type = 'customer') as total_customers,
    (SELECT COUNT(*) FROM users WHERE type = 'barber') as total_barbers,
    (SELECT COUNT(*) FROM shop WHERE status = 'open') as active_shops,
    (SELECT COUNT(*) FROM shop WHERE status = 'pending') as pending_shops,
    (SELECT COUNT(*) FROM booking WHERE status = 'completed' AND DATE(completed_at) = CURDATE()) as today_bookings,
    (SELECT SUM(total_price) FROM booking WHERE status = 'completed' AND DATE(completed_at) = CURDATE()) as today_revenue,
    (SELECT COUNT(*) FROM review) as total_reviews,
    (SELECT COUNT(*) FROM booking WHERE status IN ('waiting', 'in_service')) as active_bookings";

$statsResult = mysqli_query($conn, $statsQry);
$stats = mysqli_fetch_assoc($statsResult);

// Get pending shops
$pendingShopsQry = "SELECT 
    shop.*,
    users.name as owner_name,
    users.email as owner_email,
    users.phone as owner_phone
FROM shop
JOIN users ON shop.uid = users.uid
WHERE shop.status = 'pending'
ORDER BY shop.created_at DESC";

$pendingShopsResult = mysqli_query($conn, $pendingShopsQry);

// Get all shops
$allShopsQry = "SELECT 
    shop.*,
    users.name as owner_name,
    users.email as owner_email,
    COUNT(DISTINCT review.rid) as total_reviews,
    queue.current_queue
FROM shop
JOIN users ON shop.uid = users.uid
LEFT JOIN review ON shop.sid = review.sid
LEFT JOIN queue ON shop.sid = queue.sid
WHERE shop.status != 'pending'
GROUP BY shop.sid
ORDER BY shop.created_at DESC";

$allShopsResult = mysqli_query($conn, $allShopsQry);

// Get all users
$allUsersQry = "SELECT 
    users.*,
    COUNT(DISTINCT booking.bid) as total_bookings,
    COUNT(DISTINCT review.rid) as total_reviews,
    COUNT(DISTINCT favorites.sid) as total_favorites
FROM users
LEFT JOIN booking ON users.uid = booking.uid
LEFT JOIN review ON users.uid = review.uid
LEFT JOIN favorites ON users.uid = favorites.uid
WHERE users.type != 'admin'
GROUP BY users.uid
ORDER BY users.created_at DESC";

$allUsersResult = mysqli_query($conn, $allUsersQry);

// Get all bookings
$allBookingsQry = "SELECT 
    booking.*,
    users.name as customer_name,
    users.email as customer_email,
    shop.sname as shop_name
FROM booking
JOIN users ON booking.uid = users.uid
JOIN shop ON booking.sid = shop.sid
ORDER BY booking.joined_at DESC
LIMIT 50";

$allBookingsResult = mysqli_query($conn, $allBookingsQry);

// Get recent reviews
$recentReviewsQry = "SELECT 
    review.*,
    users.name as customer_name,
    shop.sname as shop_name
FROM review
JOIN users ON review.uid = users.uid
JOIN shop ON review.sid = shop.sid
ORDER BY review.date_added DESC
LIMIT 20";

$recentReviewsResult = mysqli_query($conn, $recentReviewsQry);

include 'header.php';
include 'navbar.php';
?>

<section class="bg-[#F1F4F9] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-1">Manage your barbershop platform</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Customers</p>
                        <p class="text-3xl font-bold text-blue-600"><?php echo $stats['total_customers']; ?></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <img src="./public/images/web/user.png" class="w-8 h-8" alt="">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Barbers</p>
                        <p class="text-3xl font-bold text-green-600"><?php echo $stats['total_barbers']; ?></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <img src="./public/images/web/shop.png" class="w-8 h-8" alt="">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Active Shops</p>
                        <p class="text-3xl font-bold text-purple-600"><?php echo $stats['active_shops']; ?></p>
                        <?php if ($stats['pending_shops'] > 0): ?>
                            <p class="text-xs text-yellow-600 mt-1">
                                <?php echo $stats['pending_shops']; ?> pending approval
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <img src="./public/images/web/shop.png" class="w-8 h-8" alt="">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Today's Revenue</p>
                        <p class="text-3xl font-bold text-yellow-600">
                            Rs. <?php echo number_format($stats['today_revenue'] ?? 0); ?>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            <?php echo $stats['today_bookings']; ?> bookings
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <img src="./public/images/web/upward.png" class="w-8 h-8" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Total Reviews</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $stats['total_reviews']; ?></p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Active Bookings</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $stats['active_bookings']; ?></p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600">Pending Approvals</p>
                <p class="text-2xl font-bold text-orange-600"><?php echo $stats['pending_shops']; ?></p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-t-lg shadow-md">
            <div class="flex border-b overflow-x-auto">
                <button onclick="switchTab('pending')" id="tab-pending"
                    class="tab-btn px-6 py-3 font-semibold border-b-2 border-yellow-400 text-yellow-600 whitespace-nowrap relative">
                    Pending Approvals
                    <?php if ($stats['pending_shops'] > 0): ?>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            <?php echo $stats['pending_shops']; ?>
                        </span>
                    <?php endif; ?>
                </button>
                <button onclick="switchTab('shops')" id="tab-shops"
                    class="tab-btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    All Shops
                </button>
                <button onclick="switchTab('users')" id="tab-users"
                    class="tab-btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Users
                </button>
                <button onclick="switchTab('bookings')" id="tab-bookings"
                    class="tab-btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Bookings
                </button>
                <button onclick="switchTab('reviews')" id="tab-reviews"
                    class="tab-btn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Reviews
                </button>
            </div>
        </div>

        <!-- Pending Approvals Tab -->
        <div id="content-pending" class="tab-content bg-white rounded-b-lg shadow-md p-6">
            <?php if (mysqli_num_rows($pendingShopsResult) > 0): ?>
                <h2 class="text-2xl font-bold mb-6">Pending Shop Approvals</h2>
                <div class="space-y-4">
                    <?php while ($shop = mysqli_fetch_assoc($pendingShopsResult)): ?>
                        <div id="pending-shop-<?php echo $shop['sid']; ?>"
                            class="border-2 border-yellow-300 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <img src="<?php echo $shop['photo']; ?>" alt="<?php echo $shop['sname']; ?>"
                                    class="w-full lg:w-48 h-48 object-cover rounded-lg border-2 border-yellow-400">

                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900"><?php echo $shop['sname']; ?></h3>
                                            <p class="text-gray-600 mt-1"><?php echo $shop['saddress']; ?></p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Submitted: <?php echo date("M d, Y", strtotime($shop['created_at'])); ?>
                                            </p>
                                        </div>
                                        <span
                                            class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            Pending
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Owner Name</p>
                                            <p class="font-semibold"><?php echo $shop['owner_name']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Email</p>
                                            <p class="font-semibold"><?php echo $shop['owner_email']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Phone</p>
                                            <p class="font-semibold"><?php echo $shop['owner_phone']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Total Barbers</p>
                                            <p class="font-semibold"><?php echo $shop['total_barbers']; ?></p>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <button onclick="approveShop(<?php echo $shop['sid']; ?>)"
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                            Approve
                                        </button>
                                        <button onclick="rejectShop(<?php echo $shop['sid']; ?>)"
                                            class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                    <p class="text-gray-500 text-lg">No pending approvals</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- All Shops Tab -->
        <div id="content-shops" class="tab-content bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">All Shops</h2>

            <?php if (mysqli_num_rows($allShopsResult) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Shop</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Owner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Queue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reviews</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            mysqli_data_seek($allShopsResult, 0);
                            while ($shop = mysqli_fetch_assoc($allShopsResult)):
                            ?>
                                <tr id="shop-row-<?php echo $shop['sid']; ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="<?php echo $shop['photo']; ?>"
                                                class="w-12 h-12 rounded-lg object-cover mr-3" alt="">
                                            <div>
                                                <div class="font-semibold"><?php echo $shop['sname']; ?></div>
                                                <div class="text-sm text-gray-500"><?php echo $shop['saddress']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium"><?php echo $shop['owner_name']; ?></div>
                                        <div class="text-sm text-gray-500"><?php echo $shop['owner_email']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php
                                            echo $shop['status'] === 'open' ? 'bg-green-100 text-green-800' : ($shop['status'] === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800');
                                            ?>">
                                            <?php echo ucfirst($shop['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php echo $shop['current_queue'] ?? 0; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php echo $shop['total_reviews']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex gap-2">
                                            <?php if ($shop['status'] !== 'suspended'): ?>
                                                <button onclick="suspendShop(<?php echo $shop['sid']; ?>)"
                                                    class="text-orange-600 hover:text-orange-900 font-medium">
                                                    Suspend
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="deleteShop(<?php echo $shop['sid']; ?>)"
                                                class="text-red-600 hover:text-red-900 font-medium">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No shops found</p>
            <?php endif; ?>
        </div>

        <!-- Users Tab -->
        <div id="content-users" class="tab-content bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">All Users</h2>

            <?php if (mysqli_num_rows($allUsersResult) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Activity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            mysqli_data_seek($allUsersResult, 0);
                            while ($user = mysqli_fetch_assoc($allUsersResult)):
                            ?>
                                <tr id="user-row-<?php echo $user['uid']; ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="./public/images/web/profile.png" class="w-10 h-10 rounded-full mr-3"
                                                alt="">
                                            <div>
                                                <div class="font-semibold"><?php echo $user['name']; ?></div>
                                                <div class="text-sm text-gray-500">
                                                    Joined <?php echo date("M d, Y", strtotime($user['created_at'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php echo $user['type'] === 'customer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'; ?>">
                                            <?php echo ucfirst($user['type']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div><?php echo $user['email']; ?></div>
                                        <div class="text-gray-500"><?php echo $user['phone']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div>Bookings: <?php echo $user['total_bookings']; ?></div>
                                        <div>Reviews: <?php echo $user['total_reviews']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button onclick="deleteUser(<?php echo $user['uid']; ?>)"
                                            class="text-red-600 hover:text-red-900 font-medium">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No users found</p>
            <?php endif; ?>
        </div>

        <!-- Bookings Tab -->
        <div id="content-bookings" class="tab-content bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Recent Bookings</h2>

            <?php if (mysqli_num_rows($allBookingsResult) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Booking #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Shop</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            mysqli_data_seek($allBookingsResult, 0);
                            while ($booking = mysqli_fetch_assoc($allBookingsResult)):
                            ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                        #<?php echo $booking['booking_number']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium"><?php echo $booking['customer_name']; ?></div>
                                        <div class="text-sm text-gray-500"><?php echo $booking['customer_email']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php echo $booking['shop_name']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php
                                            echo $booking['status'] === 'completed' ? 'bg-green-100 text-green-800' : ($booking['status'] === 'in_service' ? 'bg-blue-100 text-blue-800' : ($booking['status'] === 'waiting' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'));
                                            ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-yellow-600">
                                        Rs. <?php echo $booking['total_price']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date("M d, Y | g:i A", strtotime($booking['joined_at'])); ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No bookings found</p>
            <?php endif; ?>
        </div>

        <!-- Reviews Tab -->
        <div id="content-reviews" class="tab-content bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Recent Reviews</h2>

            <?php if (mysqli_num_rows($recentReviewsResult) > 0): ?>
                <div class="space-y-4">
                    <?php while ($review = mysqli_fetch_assoc($recentReviewsResult)): ?>
                        <div id="review-<?php echo $review['rid']; ?>" class="border rounded-lg p-4">
                            <div class="flex items-start gap-4">
                                <img src="./public/images/web/profile.png" class="w-12 h-12 rounded-full" alt="">
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold"><?php echo $review['customer_name']; ?></p>
                                            <p class="text-sm text-gray-600">
                                                for <?php echo $review['shop_name']; ?>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                <?php echo date("M d, Y | g:i A", strtotime($review['date_added'])); ?>
                                            </p>
                                        </div>
                                        <button onclick="deleteReview(<?php echo $review['rid']; ?>)"
                                            class="text-red-600 hover:text-red-900 text-sm font-medium">
                                            Delete
                                        </button>
                                    </div>
                                    <p class="mt-2 text-gray-700"><?php echo $review['review']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No reviews found</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="./public/js/admin.js"></script>

<?php
mysqli_close($conn);
include 'footer.php';
?>