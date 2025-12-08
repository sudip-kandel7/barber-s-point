<section class="bg-[#f8f9fa] border-2 border-red-500 min-h-[30vh]">
    <div class="pt-7 flex flex-col items-center w-[1400px]  text-center mx-auto">
        <div class="w-full">
            <p class="text-3xl font-semibold">Popular Barber Shops</p>
            <p class="text-base sm:text-lg md:text-xl text-gray-500 font-semilight">
                Discover the best barber shops in your area with real-time queue information </p>
            <p class="text-base sm:text-lg md:text-xl text-gray-500 font-semilight">and customer reviews.</p>
        </div>

        <div class="mt-11 w-full flex justify-between items-center p-3">

            <div class="flex items-center gap-6">

                <!-- filter of shops -->
                <div class="flex items-center gap-3 relative">

                    <img src="./public/images/filter.png" class="w-4 h-4" alt="">
                    <span class="font-medium text-sm text-gray-700">Filter:</span>

                    <div
                        class="flex items-center gap-3 border border-gray-300 rounded-md px-4 py-2 cursor-pointer hover:border-yellow-400 transition">
                        <p class="text-sm text-gray-700">All Shops</p>
                        <img src="./public/images/down.png" class="w-4 h-4" alt="">
                    </div>

                    <div
                        class="list absolute top-12 left-[58px] w-44 bg-white border border-gray-300 rounded-md shadow-lg py-2 px-2 hidden">

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>All Shops</p>
                        </div>

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>Open Now</p>
                        </div>

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>No Wait</p>
                        </div>

                    </div>
                </div>

                <!-- sort of shops  -->

                <div class="flex items-center gap-3 relative">

                    <img src="./public/images/sort.png" class="w-4 h-4" alt="">
                    <span class="font-medium text-sm text-gray-700">Sort:</span>

                    <div
                        class="flex items-center gap-3 border border-gray-300 rounded-md px-4 py-2 cursor-pointer hover:border-yellow-400 transition">
                        <p class="text-sm text-gray-700">Queue</p>
                        <img src="./public/images/down.png" class="w-4 h-4" alt="">
                    </div>

                    <div
                        class="list absolute top-12 left-[58px] w-44 bg-white border border-gray-300 rounded-md shadow-lg py-2 px-2 hidden">

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>Queue</p>
                        </div>

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>Wait Time</p>
                        </div>

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>Rating</p>
                        </div>

                        <div
                            class="option flex items-center gap-3 px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-yellow-300 cursor-pointer">
                            <img src="./public/images/check.png" class="w-4 h-4 opacity-0 check">
                            <p>Distance</p>
                        </div>

                    </div>
                </div>

            </div>

            <div>
                <p class="text-sm">Showing 7 of 7</p>
            </div>

        </div>


        <div>
            <!-- shops  -->
        </div>

    </div>
</section>