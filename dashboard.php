<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

include 'sessionCheck.php';

if ($_SESSION['user']->type !== 'admin') {
    header("Location: index.php");
    exit;
}

$uid = $_SESSION['user']->uid;

$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if (isset($_POST['action']) && $_POST['action'] === 'approve') {
        $sid = (int)$_POST['sid'];
        $admin_uid = $_SESSION['user']->uid;

        $qry = "UPDATE shop SET status = 'closed', approved_at = NOW(), approved_by = $admin_uid WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop approved']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'reject') {
        $sid = (int)$_POST['sid'];
        $result = mysqli_query($conn, "SELECT uid FROM shop WHERE sid = $sid");
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];

        $qry1 = "DELETE FROM shop WHERE sid = $sid";

        if (mysqli_query($conn, $qry1)) {
            $qry2 = "DELETE FROM users WHERE uid = $uid";
            if (mysqli_query($conn, $qry2)) {
                echo json_encode(['status' => 'success', 'msg' => 'Shop and user deleted']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Shop deleted but user deletion failed: ' . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Failed to delete shop: ' . mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'suspend') {
        $sid = (int)$_POST['sid'];

        $qry = "UPDATE shop SET status = 'suspended' WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop suspended']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'unsuspend') {
        $sid = (int)$_POST['sid'];

        $qry = "UPDATE shop SET status = 'closed' WHERE sid = $sid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop unsuspended']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete_shop') {
        header('Content-Type: application/json');

        $sid = (int)$_POST['sid'];

        if (mysqli_query($conn, "DELETE FROM shop WHERE sid = $sid")) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }

        exit;
    }




    if (isset($_POST['action']) && $_POST['action'] === 'suspend_user') {
        $uid = (int)$_POST['uid'];

        $qry = "UPDATE users SET status = 'suspended' WHERE uid = $uid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop unsuspended']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'unsuspend_user') {
        $uid = (int)$_POST['uid'];

        $qry = "UPDATE users SET status = 'active' WHERE uid = $uid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Shop unsuspended']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete_user') {
        $uid = (int)$_POST['uid'];

        $qry = "DELETE FROM users WHERE uid = $uid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'User deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'failed"']);
        }
        exit;
    }

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
    if (isset($_POST['action']) && $_POST['action'] === 'update_complaint') {
        $fid = (int)$_POST['fid'];
        $new_status = $_POST['new_status'];

        $qry = "UPDATE feedback 
                SET status = '$new_status', 
                    responded_by = '$uid', 
                    date_resolved = NOW() 
                WHERE fid = $fid";

        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Complaint status updated']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete_complaint') {
        $fid = (int)$_POST['fid'];

        $qry = "DELETE FROM feedback WHERE fid = $fid";
        if (mysqli_query($conn, $qry)) {
            echo json_encode(['status' => 'success', 'msg' => 'Complaint deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
        }
        exit;
    }
}

$qry1 = "SELECT 
    (SELECT COUNT(*) FROM users WHERE type = 'customer') as total_customers,
    (SELECT COUNT(*) FROM shop WHERE status = 'open') as active_shops,
    (SELECT COUNT(*) FROM shop WHERE status = 'pending') as pending_shops,
    (SELECT COUNT(*) FROM feedback WHERE status IN ('pending')) as pending_complaints";

$result1 = mysqli_query($conn, $qry1);
$stats = mysqli_fetch_assoc($result1);

$qry2 = "SELECT 
    shop.*,
    users.name,
    users.email,
    users.phone
FROM shop
JOIN users ON shop.uid = users.uid
WHERE shop.status = 'pending'
ORDER BY shop.created_at DESC";

$result2 = mysqli_query($conn, $qry2);

$qry3 = "SELECT 
    shop.*,
    users.name,
    users.email,
    COUNT(DISTINCT review.rid) as total_reviews,
    queue.current_queue
FROM shop
JOIN users ON shop.uid = users.uid
LEFT JOIN review ON shop.sid = review.sid
LEFT JOIN queue ON shop.sid = queue.sid
WHERE shop.status != 'pending'
GROUP BY shop.sid
ORDER BY shop.created_at DESC";

$result3 = mysqli_query($conn, $qry3);

$qry4 = "SELECT * FROM users WHERE users.type != 'admin'
ORDER BY users.created_at DESC";

$result4 = mysqli_query($conn, $qry4);

$qry5 = "SELECT 
    review.*,
    users.name,
    shop.sname
FROM review
JOIN users ON review.uid = users.uid
JOIN shop ON review.sid = shop.sid
ORDER BY review.date_added DESC
LIMIT 20";

$result5 = mysqli_query($conn, $qry5);

$qryAdmin = "SELECT name from users WHERE uid = '$uid' AND type = 'admin'";
$resultAdmin = mysqli_query($conn, $qryAdmin);

$adminData = mysqli_fetch_assoc($resultAdmin);
$admin_name = $adminData['name'];

$qry6 = "SELECT 
    feedback.*,
    users.name,
    users.email,
    shop.sname
FROM feedback
JOIN users ON feedback.uid = users.uid
LEFT JOIN shop ON feedback.sid = shop.sid
ORDER BY FIELD(feedback.status, 'pending', 'resolved'),
    feedback.date_added DESC";

$result6 = mysqli_query($conn, $qry6);

include 'header.php';
include 'navbar.php';
?>

<section class="bg-[#F4F4F9] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-grey-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-1">Manage users, approve barbers, and handle compaints</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div
                class="rounded-lg border shadow-sm bg-white flex items-start justify-between p-6 hover:shadow-lg transition-shadow m-2 gap-2">
                <div>
                    <p class="text-sm font-medium">Total Customers</p>
                    <p class="text-2xl font-bold"><?php echo $stats['total_customers']; ?></p>
                </div>
                <img src="./public/images/web/user.png" class="w-4 h-4" alt="">
            </div>

            <div
                class="rounded-lg border shadow-sm bg-white flex items-start justify-between p-6 hover:shadow-lg transition-shadow m-2 gap-2">
                <div>
                    <p class="text-sm font-medium">Active Shops</p>
                    <p class="text-2xl font-bold"><?php echo $stats['active_shops']; ?></p>
                </div>
                <img src="./public/images/web/shop1.png" class="w-5 h-5" alt="">
            </div>

            <div
                class="rounded-lg border shadow-sm bg-white flex items-start justify-between p-6 hover:shadow-lg transition-shadow m-2 gap-2">
                <div>
                    <p class="text-sm font-medium">Pending Approvals</p>
                    <p class="text-2xl font-bold text-yellow-500"><?php echo $stats['pending_shops']; ?></p>
                </div>
                <img src="./public/images/web/report1.png" class="w-5 h-5" alt="">
            </div>

            <div
                class="rounded-lg border shadow-sm bg-white flex items-start justify-between p-6 hover:shadow-lg transition-shadow m-2 gap-2">
                <div>
                    <p class="text-sm font-medium">Pending Complaints</p>
                    <p class="text-2xl font-bold text-red-500"><?php echo $stats['pending_complaints']; ?></p>
                </div>
                <img src="./public/images/web/complaint.png" class="w-5 h-5" alt="">
            </div>
        </div>


        <div class="bg-white rounded-t-lg shadow-md mb-0.5">
            <div class="flex border-b overflow-x-auto">
                <button onclick="switchTab('pending')" id="Apending"
                    class="Abtn px-6 py-3 font-semibold border-b-2 border-yellow-400 text-yellow-500 whitespace-nowrap relative">
                    Pending Approvals
                </button>
                <button onclick="switchTab('shops')" id="Ashops"
                    class="Abtn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    All Shops
                </button>
                <button onclick="switchTab('users')" id="Ausers"
                    class="Abtn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Users
                </button>
                <button onclick="switchTab('reviews')" id="Areviews"
                    class="Abtn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Reviews
                </button>
                <button onclick="switchTab('complaints')" id="Acomplaints"
                    class="Abtn px-6 py-3 font-semibold text-gray-600 hover:text-gray-900 whitespace-nowrap">
                    Complaints
                </button>
            </div>
        </div>

        <div id="abpending" class="Acontent bg-white rounded-b-lg shadow-md p-6">
            <?php if (mysqli_num_rows($result2) > 0): ?>
                <h2 class="text-2xl font-bold mb-6">Pending Shop Approvals</h2>
                <div class="space-y-4">
                    <?php while ($shop = mysqli_fetch_assoc($result2)): ?>
                        <div id="pending-shop-<?php echo $shop['sid']; ?>"
                            class="border-2 border-gray-300 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <img src="<?php echo $shop['photo']; ?>" alt=""
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
                                            class="bg-yellow-100 text-yellow-500 px-3 py-1 rounded-full text-sm font-semibold">
                                            Pending
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Owner Name</p>
                                            <p class="font-semibold"><?php echo $shop['name']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Email</p>
                                            <p class="font-semibold"><?php echo $shop['email']; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Phone</p>
                                            <p class="font-semibold"><?php echo $shop['phone']; ?></p>
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

        <div id="abshops" class="Acontent bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">All Shops</h2>

            <?php if (mysqli_num_rows($result3) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                    SHOP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                    OWNER</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                    STATUS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                    QUEUE</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                    REVIEWS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                    ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="shopslist" class="bg-white divide-y divide-gray-200">
                            <?php
                            while ($shop = mysqli_fetch_assoc($result3)):
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
                                        <div class="text-sm font-medium"><?php echo $shop['name']; ?></div>
                                        <div class="text-sm text-gray-500"><?php echo $shop['email']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            <?php
                                            echo $shop['status'] === 'open' ? 'bg-green-100 text-green-800' : ($shop['status'] === 'closed' || $shop['closing'] === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800');
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
                                                    class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md font-medium">
                                                    Suspend
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($shop['status'] == 'suspended'): ?>
                                                <button onclick="unsuspendShop(<?php echo $shop['sid']; ?>)"
                                                    class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md font-medium">
                                                    Unsuspend
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="deleteShop(<?php echo $shop['sid']; ?>)"
                                                class="px-3 py-2 bg-red-400 hover:bg-red-500 text-black rounded-md font-medium">
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

        <div id="abusers" class="Acontent bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">All Users</h2>

            <?php if (mysqli_num_rows($result4) > 0): ?>
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
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userslist" class="bg-white divide-y divide-gray-200">
                            <?php
                            while ($user = mysqli_fetch_assoc($result4)):
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
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-500">
                                            <?php echo ucfirst($user['type']); ?> </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div><?php echo $user['email']; ?></div>
                                        <div class="text-gray-500"><?php echo $user['phone']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex gap-4">
                                            <?php if ($user['status'] !== 'suspended'): ?>
                                                <button onclick="suspendUser(<?php echo $user['uid']; ?>)"
                                                    class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md font-medium">
                                                    Suspend
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($user['status'] == 'suspended'): ?>
                                                <button onclick="unsuspendUser(<?php echo $user['uid']; ?>)"
                                                    class="px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md font-medium">
                                                    Unsuspend
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="deleteUser(<?php echo $user['uid']; ?>)"
                                                class="px-3 py-2 bg-red-400 hover:bg-red-500 text-black rounded-md font-medium">
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
                <p class="text-center text-gray-500">No users found</p>
            <?php endif; ?>
        </div>

        <!-- Reviews tab -->
        <div id="abreviews" class="Acontent bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Recent Reviews</h2>

            <?php if (mysqli_num_rows($result5) > 0): ?>
                <div class="space-y-4">
                    <?php while ($review = mysqli_fetch_assoc($result5)): ?>
                        <div id="review-<?php echo $review['rid']; ?>" class="border rounded-lg p-4">
                            <div class="flex items-start gap-4">
                                <img src="./public/images/web/profile.png" class="w-12 h-12 rounded-full" alt="">
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold"><?php echo $review['name']; ?></p>
                                            <p class="text-sm text-gray-600">
                                                for <?php echo $review['sname']; ?>
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

        <!-- compains  tab  -->
        <div id="abcomplaints" class="Acontent bg-white rounded-b-lg shadow-md p-6 hidden">
            <h2 class="text-2xl font-bold mb-6">Complaints & Feedback</h2>

            <?php if (mysqli_num_rows($result6) > 0): ?>
                <div class="space-y-4" id="complaints-list">
                    <?php while ($complaint = mysqli_fetch_assoc($result6)): ?>
                        <div id="complaint-<?php echo $complaint['fid']; ?>"
                            class="border-2 <?php echo $complaint['status'] === 'pending' ? 'border-red-200 bg-red-50' : 'border-green-200 bg-green-50'; ?> rounded-lg p-6 hover:shadow-md transition-shadow">

                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $complaint['type'] === 'complaint' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'; ?>">
                                            <?php echo ucfirst($complaint['type']); ?>
                                        </span>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $complaint['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'; ?>">
                                            <?php echo ucfirst($complaint['status']); ?>
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                        <div>
                                            <p class="text-xs text-gray-600">Submitted By</p>
                                            <p class="font-semibold"><?php echo $complaint['name']; ?></p>
                                            <p class="text-sm text-gray-500"><?php echo $complaint['email']; ?></p>
                                        </div>

                                        <?php if ($complaint['sname']): ?>
                                            <div>
                                                <p class="text-xs text-gray-600">Related Shop</p>
                                                <p class="font-semibold"><?php echo $complaint['sname']; ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <p class="text-xs text-gray-600">Date Submitted</p>
                                            <p class="text-sm">
                                                <?php echo date("M d, Y | g:i A", strtotime($complaint['date_added'])); ?></p>
                                        </div>

                                        <?php if ($complaint['status'] === 'resolved'): ?>
                                            <div>
                                                <p class="text-xs text-gray-600">Resolved By</p>
                                                <p class="text-sm"><?php echo $admin_name ?? 'Admin'; ?></p>
                                                <p class="text-xs text-gray-500">
                                                    <?php echo date("M d, Y", strtotime($complaint['date_resolved'])); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="bg-white rounded-md p-3 mb-3">
                                        <p class="text-xs text-gray-600 mb-1">Message:</p>
                                        <p class="text-gray-700"><?php echo $complaint['msg']; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2 flex-wrap">
                                <?php if ($complaint['status'] === 'pending'): ?>
                                    <button onclick="updateCS(<?php echo $complaint['fid']; ?>, 'resolved')"
                                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md font-medium transition-colors">
                                        Mark as Resolved
                                    </button>
                                <?php else: ?>
                                    <button onclick="updateCS(<?php echo $complaint['fid']; ?>, 'pending')"
                                        class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md font-medium transition-colors">
                                        Mark as Pending
                                    </button>
                                <?php endif; ?>

                                <button onclick="dComplaint(<?php echo $complaint['fid']; ?>)"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md font-medium transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                    <p class="text-gray-500 text-lg">No complaints or feedback yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    </div>
</section>

<script>
    function updateCS(fid, newStatus) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "dashboard.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    setTimeout(() => location.reload(), 100);
                } else {
                    alert("Error: " + response.msg);
                }
            }
        };

        xhr.send("action=update_complaint&fid=" + fid + "&new_status=" + newStatus);
    }

    function dComplaint(fid) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "dashboard.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    const complaintDiv = document.getElementById("complaint-" + fid);
                    if (complaintDiv) {
                        setTimeout(() => {
                            complaintDiv.remove();
                            const list = document.getElementById("complaints-list");
                            if (list && list.children.length === 0) {
                                document.getElementById("abcomplaints").innerHTML = `
                <h2 class="text-2xl font-bold mb-6">Complaints & Feedback</h2>
                <div class="text-center py-16">
                  <img src="./public/images/web/empty.png" class="w-24 h-24 mx-auto mb-4 opacity-50" alt="">
                  <p class="text-gray-500 text-lg">No complaints or feedback yet</p>
                </div>`;
                            }
                        }, 300);
                    }
                } else {
                    alert("Error: " + response.msg);
                }
            }
        };

        xhr.send("action=delete_complaint&fid=" + fid);
    }
</script>


<?php
mysqli_close($conn);
include 'footer.php';
?>