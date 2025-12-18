<?php
include 'sessionCheck.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include 'header.php';
include 'navbar.php';


$user = $_SESSION['user'];

$conn = new mysqli("localhost", "root", "", "trypoint");

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
    review.review,
    review.date_added,
    shop.sname,
    shop.saddress,
    shop.photo
FROM review 
LEFT JOIN shop ON review.sid = shop.sid
WHERE review.uid = (SELECT uid FROM users WHERE email = '{$user->email}')";


$result2 = mysqli_query($conn, $qry2);
$rows2 = mysqli_fetch_assoc($result2);

$qry3 = "SELECT 
    shop.sname,
    shop.saddress,
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

$rows3 = mysqli_fetch_assoc($result3);

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
            <div
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
            <div>
                <h2 class="text-2xl font-bold mb-6">My Reviews</h2>

                <div
                    class="border rounded-lg border-gray-300 w-full mb-4 overflow-y-auto transition-all duration-300 hover:shadow-md">

                    <div class="bg-gray-50 px-4 py-3 flex items-center gap-3 border-b">
                        <img src="<?php echo $rows2['photo'] ?>" alt="shop" class="w-12 h-12 rounded-lg object-cover" />
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900"><?php echo $rows2['sname'] ?></p>
                            <p class="text-sm text-gray-500"><?php echo $rows2['saddress'] ?></p>
                        </div>
                        <span class="text-xs text-gray-500"><?php
                                                            $datetime = $rows2['date_added'];
                                                            echo date("M d, Y | g:i A", strtotime($datetime));
                                                            ?>
                        </span>
                    </div>

                    <div class="px-4 py-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <textarea id="review1" disabled
                                    class="w-full p-3 border border-gray-300 rounded-md resize-none text-gray-700 bg-gray-50 disabled:bg-gray-50  focus:bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all"
                                    rows="3"><?php echo $rows2['review'] ?></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button onclick="changer('edit')"
                                class="edit flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-all text-sm font-medium">
                                <img id="imge" src="./public/images/web/edit.png" class="w-4 h-4 invert" alt="edit">
                                <span id="editer">Edit</span>
                            </button>
                            <button onclick="changer('delete')"
                                class="delete flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-all text-sm font-medium">
                                <img id="imgd" src="./public/images/web/remove.png" class="w-4 h-4 invert" alt="delete">
                                <span id="deleter">Delete</span>
                            </button>
                        </div>
                    </div>
                </div>


            </div>

        <?php else: ?>

            <!-- Empty State (show when no reviews) -->
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


                    <div
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

                        <button onclick="view(this)" class="w-[96%] text-xs sm:text-sm font-semibold rounded-md bg-[#f8f9fa] border py-2 
           group-hover:bg-yellow-400 group-hover:shadow-md mt-3 mb-5 transition-all"
                            data-sid="<?php echo $rows3['sid']; ?>"
                            data-name="<?php echo htmlspecialchars($rows3['sname']); ?>"
                            data-address="<?php echo htmlspecialchars($rows3['saddress']); ?>"
                            data-photo="<?php echo $rows3['photo']; ?>" data-status="<?php echo $rows3['status']; ?>">
                            View Details
                        </button>
                    </div>


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



<div class="showD hidden bg-white rounded-lg shadow-lg border-2 border-yellow-300 fixed z-[9999]
top-[50%] left-1/2 -translate-x-1/2 -translate-y-1/2
w-[95vw] sm:w-[90vw] md:w-[70vw] lg:w-[50vw]
max-h-[70vh] overflow-y-auto
transition-all duration-500 ease-out opacity-0 scale-x-0">

    <div id="shopBg" class="relative flex flex-col items-start justify-end p-5 pb-2 sm:p-4 min-h-[300px] bg-white">

        <div class="absolute top-3 right-3 sm:top-4 sm:right-4">
            <span id="status"
                class="bg-opacity-70 px-2 sm:px-3 font-semibold rounded-full inline-flex items-center py-1 text-[10px] sm:text-xs cursor-pointer bg-yellow-400 text-yellow-900 hover:bg-yellow-500 transition-colors">

            </span>
        </div>

        <h1 id="sname" class="text-3xl sm:text-4xl md:text-5xl font-semibold leading-tight text-black mb-3">
        </h1>
        <div class="flex items-center justify-start gap-2 mt-2">
            <img class="h-5 w-5" src="./public/images/web/shop-location.png" alt="">
            <p id="saddress" class="text-base sm:text-lg md:text-xl text-gray-600 font-light">

            </p>
        </div>

        <div class="flex flex-wrap items-center justify-between w-full gap-7 mt-3 text-sm sm:text-md text-gray-700">
            <div class="flex gap-1.5 sm:gap-2 items-center">
                <img src="./public/images/web/user.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" alt="">
                <p class="text-sm sm:text-md text-gray-500">
                    Queue:
                    <span id="queue" class="ml-1 text-black font-semibold"></span>
                </p>
            </div>

            <div class="flex gap-1.5 sm:gap-2 items-center">
                <img src="./public/images/web/time.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" alt="">
                <p class="text-sm sm:text-md text-gray-500">
                    Est. wait:
                    <span id="wait" class=" ml-1 text-black font-semibold"></span>
                </p>
            </div>

            <div class="flex gap-1.5 sm:gap-2 items-center">
                <img src="./public/images/web/review.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" alt="">
                <p class="text-sm sm:text-md text-gray-500">

                    <span id="review" class=" ml-1 text-black font-semibold"></span>
                </p>
            </div>
        </div>
    </div>

    <div class="p-4 sm:p-6 border-t border-gray-200 flex gap-2 flex-wrap">
        <button
            class="px-4 flex items-center gap-2 py-2 hover:-translate-y-1 bg-yellow-400  hover:bg-yellow-500 text-gray-700 font-medium rounded-lg transition-colors text-sm">
            <img src="./public/images/web/save.png" class="w-3 h-3" alt="">
            Favorite
        </button>
        <button
            class="px-4 py-2 border-2 border-gray-300 hover:-translate-y-1 hover:border-yellow-500 text-gray-700 font-medium rounded-lg transition-colors text-sm">
            Share
        </button>
        <button
            class="px-4 flex items-center gap-1 py-2 border-2 hover:-translate-y-1 border-gray-300 hover:border-yellow-500 text-gray-700 font-medium rounded-lg transition-colors text-sm">
            <img src="./public/images/web/report.png" class="w-4 h-4" alt="">
            Report
        </button>
    </div>

    <hr class="mx-3 h-11 border-gray-300">

    <div class="mx-auto mb-5 py-1 rounded-md shadow-sm bg-[#F1F4F9]
w-[96%] flex gap-2 sm:gap-6 justify-around text-sm sm:text-base">

        <button class="services text-center px-5 md:px-24 py-1 bg-white text-black" onclick="toggleTab('services')">
            Services
        </button>
        <button class="reviews text-center px-5 md:px-24 py-1" onclick="toggleTab('reviews')">
            Reviews
        </button>
    </div>

    <div class="servicesDetails hidden px-4 max-h-[40vh] overflow-y-auto"></div>
    <div class="reviewsDetails hidden px-4 max-h-[40vh] overflow-y-auto"></div>



</div>
</div>


<?php
include 'footer.php';
?>