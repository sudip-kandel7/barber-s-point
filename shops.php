<?php

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$conn = new mysqli("localhost", "root", "", "trypoint");

$Aqry = "
    SELECT 
        shop.sid,
        shop.sname,
        shop.saddress,
        shop.photo,
        shop.status,
        queue.current_queue,
        queue.total_wait_time
    FROM shop
    LEFT JOIN queue ON shop.sid = queue.sid
";

$Aresult = mysqli_query($conn, $Aqry);
$Ashops = [];
$Sshops = [];

while ($row = mysqli_fetch_assoc($Aresult)) {
    $Ashops[] = $row;
}



if ($search) {
    foreach ($Ashops as $shop) {
        if (stripos($shop['sname'], $search) !== false || stripos($shop['saddress'], $search) !== false) {
            $Sshops[] = $shop;
        }
    }
}
?>
<section class="bg-[#f8f9fa] min-h-screen pb-8">
    <div class="pt-7 flex flex-col items-center max-w-[1400px] w-full text-center mx-auto px-4 sm:px-6 lg:px-8">

        <?php if ($search): ?>
        <div class="w-full">
            <div class="mb-6 text-start">
                <p class="text-2xl sm:text-3xl lg:text-4xl font-semibold">Search Results</p>
                <p class="text-sm sm:text-base md:text-lg text-gray-500 font-semilight mt-2">
                    Found <?php echo count($Sshops); ?> shop<?php echo count($Sshops) !== 1 ? 's' : ''; ?>
                    matching "<?php echo $search; ?>"
                </p>
            </div>

            <?php if (count($Sshops) > 0): ?>

            <div class="w-full mt-3 sm:mt-4 p-2 sm:p-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                <?php foreach ($Sshops as $rows):
                            $status = strtolower(trim($rows['status']));
                            $statusColor = ($status === "open") ? "green" : "red";
                        ?>
                <div
                    class="w-full max-w-[450px] mx-auto relative bg-white shadow-md rounded-lg hover:-translate-y-1 hover:shadow-xl transition-all group">

                    <img src="<?php echo $rows['photo']; ?>" alt="<?php echo $rows['sname']; ?>"
                        class="w-full h-48 sm:h-56 object-cover rounded-t-lg">

                    <p
                        class="bg-opacity-70 px-2 sm:px-2.5 font-semibold absolute top-2 sm:top-3 right-2 sm:right-3 rounded-full 
                     inline-flex items-center py-0.5 text-[10px] sm:text-xs cursor-pointer bg-yellow-400 group-hover:bg-<?php echo $statusColor; ?>-500">
                        <?php echo ucfirst($rows['status']); ?>
                    </p>

                    <div class="px-3 sm:px-4 py-3">

                        <p
                            class="text-base sm:text-lg font-semibold text-start pl-2 sm:pl-3 group-hover:text-yellow-400 truncate">
                            <?php echo $rows['sname']; ?>
                        </p>

                        <div class="flex items-center gap-1 mt-1">
                            <img src="./public/images/web/shop-location.png" class="w-4 h-4 flex-shrink-0" alt="">
                            <p class="text-xs sm:text-sm text-gray-500 truncate">
                                <?php echo $rows['saddress']; ?>
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between gap-2 sm:gap-0 mt-3">

                            <div class="flex gap-1.5 sm:gap-2 items-center">
                                <img src="./public/images/web/user.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0"
                                    alt="">
                                <p class="text-xs sm:text-sm text-gray-500">
                                    Queue:
                                    <span class="text-yellow-400 font-semibold">
                                        <?php echo $rows['current_queue']; ?> People
                                    </span>
                                </p>
                            </div>

                            <div class="flex gap-1.5 sm:gap-2 items-center">
                                <img src="./public/images/web/time.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0"
                                    alt="">
                                <p class="text-xs sm:text-sm text-gray-500">
                                    Est. wait:
                                    <span class="text-yellow-400 font-semibold">
                                        <?php echo $wait_minutes; ?> min
                                    </span>
                                </p>
                            </div>

                        </div>
                    </div>

                    <button class="w-[96%] text-xs sm:text-sm font-semibold rounded-md bg-[#f8f9fa] border py-2 
       group-hover:bg-yellow-400 group-hover:shadow-md mt-3 mb-5 transition-all">
                        View Details
                    </button>


                </div>

                <?php endforeach ?>
            </div>
            <?php elseif (count($Sshops) == 0): ?>
            <div class="bg-white rounded-lg p-4 text-center border border-gray-200 w-full">
                <p class="text-gray-600 text-xl">No shops found matching your search.</p>
            </div>
            <?php endif; ?>

            <a href="/barber-s-point/"
                class="inline-block mt-4 font-semibold text-sm bg-gray-200 px-4 py-2 rounded-md shadow-md hover:bg-gray-300">
                ← Back to all shops
            </a>

        </div>
        <?php endif; ?>

        <!-- all shops  -->
        <div class="w-full <?php echo $search ? 'mt-4' : 'mt-2'; ?>">
            <div class="mb-6">
                <p class="text-2xl sm:text-3xl lg:text-4xl font-semibold">Popular Barber Shops</p>
                <p class="text-sm sm:text-base md:text-lg text-gray-500 font-semilight mt-2">
                    Discover the best barber shops in your area with real-time queue information </p>
                <p class="text-sm sm:text-base md:text-lg text-gray-500 font-semilight">and customer reviews.</p>
            </div>

            <div class="mt-6 sm:mt-8 lg:mt-11 w-full flex flex-row justify-between items-center 
     gap-2 sm:gap-4 p-3 relative z-[69]">


                <div class="flex items-center gap-2 sm:gap-4 md:gap-6 flex-shrink-0">

                    <div class="flex items-center gap-1.5 sm:gap-2 relative flex-shrink-0">
                        <img src="./public/images/web/filter.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0"
                            alt="">
                        <span
                            class="font-semibold text-[10px] sm:text-xs md:text-sm text-gray-700 whitespace-nowrap">Filter:</span>

                        <div
                            class="filter flex items-center gap-1.5 sm:gap-2 border-gray-300 rounded-md px-2 sm:px-3 py-1 sm:py-1.5 cursor-pointer border-2 hover:border-yellow-400 transition">
                            <p class="text-[10px] sm:text-xs md:text-sm text-gray-700 whitespace-nowrap">All Shops</p>
                            <img src="./public/images/down.png" class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" alt="">
                        </div>

                        <div
                            class="list1 absolute top-10 sm:top-11 left-5 w-36 sm:w-44 bg-white border border-gray-300 rounded-md shadow-lg py-2 px-2 hidden z-100">
                            <div
                                class="fOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">All Shops</p>
                            </div>
                            <div
                                class="fOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">Open Now</p>
                            </div>
                            <div
                                class="fOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">No Wait</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 sm:gap-2 relative flex-shrink-0">
                        <img src="./public/images/sort.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" alt="">
                        <span
                            class="font-semibold text-[10px] sm:text-xs md:text-sm text-gray-700 whitespace-nowrap">Sort:</span>

                        <div
                            class="sort flex items-center gap-1.5 sm:gap-2 border-gray-300 rounded-md px-2 sm:px-3 py-1 sm:py-1.5 cursor-pointer border-2 hover:border-yellow-400 transition">
                            <p class="text-[10px] sm:text-xs md:text-sm text-gray-700 whitespace-nowrap">Queue</p>
                            <img src="./public/images/down.png" class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" alt="">
                        </div>

                        <div
                            class="list2 absolute top-10 sm:top-11 left-0 w-36 sm:w-44 bg-white border border-gray-300 rounded-md shadow-lg py-2 px-2 hidden z-100">
                            <div
                                class="sOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">Queue</p>
                            </div>
                            <div
                                class="sOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">Wait Time</p>
                            </div>
                            <div
                                class="sOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">Rating</p>
                            </div>
                            <div
                                class="sOption flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-1.5 sm:py-2 text-[10px] sm:text-xs md:text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                                <img src="./public/images/web/check.png"
                                    class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-0 check flex-shrink-0">
                                <p class="whitespace-nowrap">Distance</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex-shrink-0 ml-auto">
                    <p class="text-[10px] sm:text-xs md:text-sm text-gray-500 whitespace-nowrap">Showing 7 of 7 shops
                    </p>
                </div>
            </div>


            <div class="w-full mt-3 sm:mt-4 p-2 sm:p-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">



                <?php foreach ($Ashops as $rows):
                    $status = strtolower(trim($rows['status']));
                    $statusColor = ($status === "open") ? "green" : "red";
                ?>
                <div
                    class="w-full max-w-[450px] mx-auto relative bg-white shadow-md rounded-lg hover:-translate-y-1 hover:shadow-xl transition-all group">

                    <img src="<?php echo $rows['photo']; ?>" alt="<?php echo $rows['sname']; ?>"
                        class="w-full h-48 sm:h-56 object-cover rounded-t-lg">

                    <p
                        class="bg-opacity-70 px-2 sm:px-2.5 font-semibold absolute top-2 sm:top-3 right-2 sm:right-3 rounded-full 
                     inline-flex items-center py-0.5 text-[10px] sm:text-xs cursor-pointer bg-yellow-400 group-hover:bg-<?php echo $statusColor; ?>-500">
                        <?php echo ucfirst($rows['status']); ?>
                    </p>

                    <div class="px-3 sm:px-4 py-3">

                        <p
                            class="text-base sm:text-lg font-semibold text-start pl-2 sm:pl-3 group-hover:text-yellow-400 truncate">
                            <?php echo $rows['sname']; ?>
                        </p>

                        <div class="flex items-center gap-1 mt-1">
                            <img src="./public/images/web/shop-location.png" class="w-4 h-4 flex-shrink-0" alt="">
                            <p class="text-xs sm:text-sm text-gray-500 truncate">
                                <?php echo $rows['saddress']; ?>
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between gap-2 sm:gap-0 mt-3">

                            <div class="flex gap-1.5 sm:gap-2 items-center">
                                <img src="./public/images/web/user.png" class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0"
                                    alt="">
                                <p class="text-xs sm:text-sm text-gray-500">
                                    Queue:
                                    <span class="text-yellow-400 font-semibold">
                                        <?php echo $rows['current_queue']; ?> People
                                    </span>
                                </p>
                            </div>

                            <div class="flex gap-1.5 sm:gap-2 items-center">
                                <img src="./public/images/web/time.png" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0"
                                    alt="">
                                <p class="text-xs sm:text-sm text-gray-500">
                                    Est. wait:
                                    <span class="text-yellow-400 font-semibold">
                                        <?php echo $rows['total_wait_time']; ?> min
                                    </span>
                                </p>
                            </div>

                        </div>
                    </div>

                    <button class="w-[96%] text-xs sm:text-sm font-semibold rounded-md bg-[#f8f9fa] border py-2 
       group-hover:bg-yellow-400 group-hover:shadow-md mt-3 mb-5 transition-all">
                        View Details
                    </button>


                </div>

                <?php endforeach ?>

            </div>

        </div>
    </div>
</section>