<div id="shopOverlay" class="fixed inset-0 bg-black/60 z-[9998] flex items-center justify-center">

    <div id="shopModal" class="bg-white rounded-lg shadow-xl
              max-w-4xl w-full mx-4
              max-h-[80vh] overflow-y-auto
              relative
             0">

        <div id="shopBg" class="relative flex flex-col items-start justify-end
         p-5 pb-2 sm:p-4 min-h-[300px]
         bg-cover bg-center bg-no-repeat" style="   
  background: url('<?php $shopData ?>') center/cover no-repeat;   
">

            <div class="absolute top-3 right-3 sm:top-4 sm:right-4">
                <span id="status"
                    class="bg-opacity-70 px-2 sm:px-3 font-semibold rounded-full inline-flex items-center py-1 text-[10px] sm:text-xs cursor-pointer bg-yellow-400 text-yellow-900 hover:bg-yellow-500 transition-colors">
                    <?php echo $shopData["status"] ?>
                </span>
            </div>

            <h1 id="sname" class="text-3xl sm:text-4xl md:text-5xl font-semibold leading-tight text-black mb-3">
                <?php echo $shopData['sname']; ?>
            </h1>
            <div class="flex items-center justify-start gap-2 mt-2">
                <img class="h-5 w-5" src="./public/images/web/shop-location.png" alt="">
                <p id="saddress" class="text-base sm:text-lg md:text-xl text-gray-600 font-light">
                    <?php echo $shopData['saddress']; ?>
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-between w-full gap-7 mt-3 text-sm sm:text-md text-gray-700">
                <div class="flex gap-1.5 sm:gap-2 items-center">
                    <img src="./public/images/web/user.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" alt="">
                    <p class="text-sm sm:text-md text-gray-500">
                        Queue:
                        <span id="queue" class="ml-1 text-yellow-400 font-semibold">
                            <?php $queue = $shopData['current_queue'] ?? 0;
                            echo $queue . ' ' . ($queue == 1 ? 'Person' : 'People'); ?>
                            People</span>
                    </p>
                </div>

                <div class="flex gap-1.5 sm:gap-2 items-center">
                    <img src="./public/images/web/time.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" alt="">
                    <p class="text-sm sm:text-md text-gray-500">
                        Est. wait:
                        <span class="ml-1 font-semibold">
                            <?php $mins = $shopData['total_wait_time'] ?? 0;
                            echo $mins . ' ' . ($mins == 1 ? 'Minute' : 'Minutes'); ?>
                        </span>

                    </p>
                </div>

                <div class="flex gap-1.5 sm:gap-2 items-center">
                    <img src="./public/images/web/review.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" alt="">
                    <p class="text-sm sm:text-md text-gray-500">
                        <span class="ml-1 text-yellow-400 font-semibold">
                            <?php $reviews = $shopData['total_reviews'] ?? 0;
                            echo $reviews . ' ' . ($reviews == 1 ? 'Review' : 'Reviews'); ?>
                        </span>

                    </p>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-6 border-t border-gray-200 flex gap-2 flex-wrap">
            <?php if ($_SESSION['user']->type === "customer"): ?>
                <button id="fav" onclick="addfav(<?php echo $sid ?>)"
                    class="px-4 flex items-center gap-2 text-white py-2 hover:-translate-y-1 bg-yellow-400  hover:bg-yellow-500 font-medium rounded-lg transition-colors text-sm">
                    <img id="favimg" src="./public/images/web/save.png" class="w-3 h-3" alt="">
                    <span class="fav">Favorite</span>
                </button>
            <?php endif ?>
            <button
                class="px-4 py-2 hover:-translate-y-1 bg-[#22c55e] text-white  font-medium rounded-lg transition-colors text-sm">
                Book
            </button>
            <button
                class="px-4 flex items-center gap-1 py-2 text-white bg-red-400 hover:bg-red-500 hover:-translate-y-1 bg-red-5000 font-medium rounded-lg transition-colors text-sm">
                <img src="./public/images/web/report.png" class="w-4 h-4" alt="">
                Report
            </button>
        </div>

        <hr class="mx-3 h-11 border-gray-300">
        <?php if (isset($_SESSION['user']) && $_SESSION['user']->type === "customer"): ?>

            <div class="flex items-center gap-3 justify-between border-2 border-gray-300 rounded-md shadow-sm -mt-3 mx-auto mb-4
    w-[96%]  text-sm sm:text-base">
                <input class="reviewtxt text-base text-gray-400 h-full w-full py-3 px-2 outline-none"
                    placeholder="Comment....." />
                <p onclick="review()"
                    class="reviewpost cursor-pointer bg-yellow-400 hover:bg-yellow-500 hover:shadow-md py-1.5 px-5 my-1 mx-2 rounded-md">
                    Post
                </p>
            </div>
        <?php endif ?>

        <div class="mx-auto mb-5 py-1 rounded-md shadow-sm bg-[#F1F4F9]
w-[96%] flex gap-2 sm:gap-6 justify-around text-sm sm:text-base">

            <button class="services text-center px-5 md:px-24 py-1 bg-white text-black" onclick="toggleTab('services')">
                Services
            </button>
            <button class="reviews text-center px-5 md:px-24 py-1" onclick="toggleTab('reviews')">
                Reviews
            </button>
        </div>

        <div class="servicesDetails hidden px-4 max-h-[40vh] overflow-y-auto">

            <?php if (mysqli_num_rows($servicesResult) > 0):
                while ($rows = mysqli_fetch_assoc($servicesResult)) {

            ?>
                    <div
                        class="border rounded-md w-full border-gray-500 flex flex-col sm:flex-row sm:justify-between sm:items-center px-3 py-3 mb-3 gap-2">
                        <div>
                            <p class="font-medium"><?php echo  $rows['services_name'] ?></p>
                            <p class="text-sm text-gray-400"><?php echo $rows['duration'] ?> mins</p>
                        </div>
                        <p class="font-semibold text-yellow-400">Rs. <?php echo $rows['price'] ?> ?? 0 </p>
                    </div>
                <?php }
            else:
                ?>
                <p class='text-center mb-2 text-2xl text-gray-400'>No services available.</p>
            <?php endif ?>
        </div>
        <div class="reviewsDetails hidden px-4 max-h-[40vh] overflow-y-auto">
            <?php if (mysqli_num_rows($reviewsResult) > 0): ?>
                <?php while ($rows = mysqli_fetch_assoc($reviewsResult)): ?>
                    <div class="border rounded-md w-full border-gray-500 flex flex-col px-3 py-3 mb-3 gap-1">
                        <div class="flex items-center gap-3">
                            <img src="./public/images/web/profile.png" class="w-10 h-10 rounded-full" />
                            <div>
                                <p class="font-medium"><?php echo $rows['firstN']; ?></p>
                                <p class="text-sm text-gray-400 mb-2"><?php echo $rows['date_added']; ?></p>
                            </div>
                        </div>
                        <p><?php echo $rows['review']; ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center mb-2 text-2xl text-gray-400">No reviews available.</p>
            <?php endif; ?>

        </div>

    </div>
</div>
</div>