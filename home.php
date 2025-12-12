<section style="   
  background:
      linear-gradient(to right, rgba(255,255,255,0.8), rgba(255,255,255,0.8)),
      url('./public/images/hero-barber.jpg') center/cover no-repeat;   
" class="min-h-[77vh] sm:h-[60vh] w-full hero-section">

    <div class="flex justify-center items-start sm:items-center flex-col text-center min-h-[80vh] px-4 py-8">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-3xl sm:text-4xl md:text-6xl text-black font-semibold leading-tight">Find Your Perfect</h1>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold text-yellow-500 leading-tight">Barber Shop</h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-500 font-light mt-3 max-w-2xl mx-auto">Discover
                professional barber shops near you.</p>
            <p class="text-base sm:text-lg md:text-xl  text-gray-500 font-light max-w-2xl mx-auto">Check wait times, &
                read reviews from real customers.</p>
        </div>


        <form method="GET"
            class="flex flex-wrap bg-white mt-4 mb-4 sm:mb-8 h-10 items-center border rounded-xl pl-3 px-2 gap-2 max-[500px]:gap-1 w-full max-w-2xl">

            <label for="search" class="cursor-pointer flex items-center">
                <img src="./public/images/search-icon.png" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7"
                    alt="search icon">
            </label>

            <input type="search" id="search" name="barber"
                class="h-full flex-1 min-w-0 focus:outline-none text-sm sm:text-base"
                placeholder="Search for shops, locations...">

            <div class="hidden" id="cross"></div>

            <div id="voiceBtn"
                class="w-10 sm:w-11 h-full flex items-center hover:bg-yellow-400 justify-center rounded-md border-gray-300 cursor-pointer">
                <img src="./public/images/voice.png" class="w-4 h-4 sm:w-5 sm:h-5" alt="voice search icon">
                <img src="./public/images/pause.png" class="hidden w-4 h-4 sm:w-5 sm:h-5" alt="voice pause icon">
                <img src="./public/images/play.png" class="hidden w-4 h-4 sm:w-5 sm:h-5" alt="voice resume icon">
            </div>

            <button type="submit"
                class="bg-black text-white text-xs sm:text-sm py-[8px] px-3 sm:px-[17px] rounded-md hover:bg-gray-800">
                Search
            </button>

        </form>

        <?php
        if (isset($_POST['barber'])) {
            $searchTerm = $_POST['barber'];
        }
        ?>


        <div class="w-full max-w-4xl">
            <div class="flex flex-col gap-4 sm:hidden text-center">
                <div class="p-3 flex flex-col">
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <p class="text-2xl font-bold text-yellow-500">50</p>
                        <img src="./public/images/cross.png" alt="" class="w-4 h-4">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <img src="./public/images/shop.png" alt="" class="w-5 h-5">
                        <p class="text-gray-500 text-sm">Barber Shops</p>
                    </div>
                </div>

                <div class="p-3 flex flex-col">
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <p class="text-2xl font-bold text-yellow-500">1000</p>
                        <img src="./public/images/cross.png" alt="" class="w-4 h-4">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <img src="./public/images/heart.png" alt="" class="w-5 h-5">
                        <p class="text-gray-500 text-sm">Happy Customers</p>
                    </div>
                </div>

                <div class="p-3 flex flex-col">
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <p class="text-2xl font-bold text-yellow-500">4.8</p>
                        <img src="./public/images/star.png" alt="" class="w-4 h-4">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <img src="./public/images/upward.png" alt="" class="w-5 h-5">
                        <p class="text-gray-500 text-sm">Average Rating</p>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex gap-4 md:gap-11 text-center justify-center">
                <div class="p-4 md:p-6 flex flex-col flex-1 min-w-0 max-w-[200px]">
                    <div class="flex items-center justify-center gap-1 mb-3">
                        <p class="text-2xl  font-bold text-yellow-400">50</p>
                        <img src="./public/images/cross.png" alt="" class="w-3 h-3">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <img src="./public/images/shop.png" alt="" class="w-4 h-4 md:w-5 md:h-5">
                        <p class="text-white text-sm md:text-base whitespace-nowrap">Barber Shops</p>
                    </div>
                </div>

                <div class="p-4 md:p-6 flex flex-col flex-1 min-w-0 max-w-[200px]">
                    <div class="flex items-center justify-center gap-1 mb-3">
                        <p class="text-2xl  font-bold text-yellow-400">1000</p>
                        <img src="./public/images/cross.png" alt="" class="w-3 h-3">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <img src="./public/images/heart.png" alt="" class="w-4 h-4 md:w-5 md:h-5">
                        <p class="text-white text-sm md:text-base whitespace-nowrap">Happy Customers</p>
                    </div>
                </div>

                <div class="p-4 md:p-6 flex flex-col flex-1 min-w-0 max-w-[200px]">
                    <div class="flex items-center justify-center gap-1 mb-3">
                        <p class="text-2xl  font-bold text-yellow-400">4.8</p>
                        <img src="./public/images/star.png" alt="" class="w-3 h-3 md:w-5 md:h-5">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <img src="./public/images/upward.png" alt="" class="w-5 h-5 md:w-6 md:h-6">
                        <p class="text-white text-sm md:text-base whitespace-nowrap">Average Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>