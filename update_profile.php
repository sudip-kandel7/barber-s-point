<?php
// include 'sessionCheck.php';

// $conn = new mysqli("localhost", "root", "", "trypoint");


// if (!isset($_GET['sid'])) {
//     exit;
// }


// $sid = (int) $_GET['sid'];
// $uid = $_SESSION['user']->uid;


// $shopQry = "
//         SELECT 
//             shop.sname,
//             shop.saddress,
//             shop.status,
//             shop.photo,
//             queue.current_queue,
//             queue.total_wait_time,
//             COUNT(review.rid) AS total_reviews
//         FROM shop
//         JOIN users ON shop.uid = users.uid
//         LEFT JOIN queue ON shop.sid = queue.sid
//         LEFT JOIN review ON shop.sid = review.sid
//         WHERE shop.sid = $sid
//         GROUP BY 
//             shop.sname,
//             shop.saddress,
//             shop.status,
//             shop.photo,
//             queue.current_queue,
//             queue.total_wait_time
//     ";

// $shopResult = mysqli_query($conn, $shopQry);
// $shopData  = mysqli_fetch_assoc($shopResult);


// $servicesQry = "
//         SELECT 
//             services.services_name,
//             shop_services.price,
//             shop_services.duration
//         FROM shop_services
//         JOIN services ON shop_services.services_id = services.services_id
//         WHERE shop_services.sid = $sid
//     ";

// $servicesResult = mysqli_query($conn, $servicesQry);




// $reviewsQry = "
//         SELECT 
//             users.firstN,
//             review.review,
//             review.date_added
//         FROM review
//         JOIN users ON review.uid = users.uid
//         WHERE review.sid = $sid
//         ORDER BY review.date_added DESC
//     ";

// $reviewsResult = mysqli_query($conn, $reviewsQry);

// mysqli_close($conn);




?>

<div id="overlayp" class="fixed flex items-center justify-center inset-0 bg-black/60 z-50">

    <div id="profileModal" class="bg-white w-full max-w-md rounded-xl shadow-xl p-6
           ">



        <h2 class="text-xl font-semibold text-gray-900">Edit Profile</h2>
        <p class="text-sm text-gray-500 mb-6">Update your profile information</p>

        <div class="space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>
                <input type="text" value="John Doe"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" value="john.doe@example.com" disabled
                    class="w-full rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-gray-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Phone
                </label>
                <input type="text" value="+1 (555) 123-4567"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Address
                </label>
                <input type="text" value="123 Main Street"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" />
            </div>


        </div>

        <div class="flex justify-end gap-3 mt-6">
            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                Cancel
            </button>
            <button class="px-4 py-2 rounded-lg bg-yellow-500 text-white font-semibold hover:bg-yellow-600">
                Save Changes
            </button>
        </div>

    </div>
</div>