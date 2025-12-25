<?php
include 'sessionCheck.php';
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


$qry = "
SELECT 
    users.firstN,
    users.email,
    users.phone,
    users.address,
    users.added_date,
    COUNT(review.rid) AS total_reviews
FROM users 
LEFT JOIN review ON review.uid = users.uid
WHERE users.email = '{$user->email}'
GROUP BY users.uid
";



$result = mysqli_query($conn, $qry);

$rows = mysqli_fetch_assoc($result);

$qry2 = "SELECT 
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




?>


<section class="">
    <div class="bg-[#F1F4F9] min-h-screen w-full pt-12 px-5 flex flex-col items-center ">

        <div
            class="w-full bg-white rounded-lg shadow-md max-w-6xl p-4 md:p-8 flex items-center justify-between mt-6 mb-4">
            <div class="flex gap-4 items-center">
                <img src="./public/images/web/profile.png" class="w-24 h-24" alt="">
                <div>
                    <div>
                        <h2 class="text-3xl font-bold"><?php echo $rows['firstN']; ?></h2>
                        <div class="flex gap-2 mt-2 items-center">
                            <img src="./public/images/web/calendar.png" class=" w-4 h-4" alt="">
                            <span class="text-gray-500 text-md">Member since <?php
                                                                                echo date("F j, Y", strtotime($row['added_date']));

                                                                                ?>
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
                class="flex items-center justify-center  whitespace-nowrap border hover:cursor-pointer hover:border-none hover:translate-x-0.5 hover:-translate-y-0.5 hover:bg-yellow-300 text-sm bprder-gray-200 rounded-md font-medium  h-10 px-4 py-2 gap-2">
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

    <div class="bg-[#c7d8f3] w-full rounded-t-lg py-0.5 shadow-md max-w-6xl flex items-center justify-evenly">
        <button onclick="toggleDiv('review')" id="myreview" class="flex items-center justify-center text-black bg-[#f1f5f9] rounded-md whitespace-nowrap px-36 py-1 text-sm
            font-medium gap-2 hover:cursor-pointer">
            <img id="imgr" src=" ./public/images/web/timeB.png" class="w-6 h-6" alt="">
            <span>My Reviews</span>
        </button>
        <button onclick="toggleDiv('fav')" id="myfav" class="flex items-center justify-center text-gray-500 whitespace-nowrap rounded-md px-36 py-1 text-sm
            font-semibold gap-2 hover:cursor-pointer">
            <img id="imgf" src=" ./public/images/web/favoriteG.png" class="w-6 h-6" alt="">
            <span>Favorite Shops</span>
        </button>
    </div>
    <div id="reviewD" class=" w-full max-w-6xl mt-1 p-4 md:p-8 bg-white rounded-lg shadow-md">
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
                <p class="text-gray-400 text-sm mt-2">Visit a shop and share your experience!</p>
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

                            <button onclick="viewf('<?php echo $rows3['sid']; ?>')" class="w-[96%] text-xs sm:text-sm font-semibold rounded-md bg-[#f8f9fa] border py-2 
   group-hover:bg-yellow-400 group-hover:text-white group-hover:shadow-md mx-2 mt-3  transition-all">
                                View Details
                            </button>

                            <button onclick="removefav('<?php echo $rows3['sid']; ?>')" class="w-[96%] text-xs sm:text-sm font-semibold rounded-md bg-[#f8f9fa] border py-2 
hover:bg-red-500 hover:text-white hover:shadow-md mx-2 mt-3 mb-5 transition-all">
                                Remove Favorite
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
                <p class="text-gray-400 text-sm mt-2">Visit a shop and add to your favorite!</p>
            </div>
        <?php endif ?>

    </div>


    </div>
</section>




<?php include 'footer.php' ?>