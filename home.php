<section>
    <div style="   
  background:
      linear-gradient(to right, rgba(255,255,255,0.8), rgba(255,255,255,0.8)),
      url('./public/images/web/hero-barber.jpg') center/cover no-repeat;   
" class="flex justify-center items-center flex-col text-center min-h-[40vh] px-4 py-4">
        <div class="mb-6 sm:mb-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-6xl text-black font-semibold leading-tight">Find Your Perfect</h1>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold text-yellow-500 leading-tight">Barber Shop</h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-500 font-light mt-3 max-w-2xl mx-auto">Discover
                professional barber shops near you.</p>
            <p class="text-base sm:text-lg md:text-xl  text-gray-500 font-light max-w-2xl mx-auto">Check wait times, &
                read reviews from real customers (Reload frequently for real data).</p>
        </div>


        <form method="GET" accept="shops.php"
            class="flex flex-wrap bg-white mt-4 mb-4 sm:mb-8 h-10 items-center border rounded-xl pl-3 px-2 gap-2 max-[500px]:gap-1 w-full max-w-2xl">

            <label for="search" class="cursor-pointer flex items-center">
                <img src="./public/images/web/search-icon.png" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7"
                    alt="search icon">
            </label>

            <input type="search" id="search" name="search"
                class="h-full flex-1 min-w-0 focus:outline-none text-sm sm:text-base"
                placeholder="Search for shops, locations...">

            <div class="hidden" id="cross"></div>

            <div id="voiceBtn"
                class="w-10 sm:w-11 h-full flex items-center hover:bg-yellow-400 justify-center rounded-md border-gray-300 cursor-pointer">
                <img src="./public/images/web/voice.png" class="w-4 h-4 sm:w-5 sm:h-5" alt="voice search icon">
                <img src="./public/images/web/pause.png" class="hidden w-4 h-4 sm:w-5 sm:h-5" alt="voice pause icon">
                <img src="./public/images/web/play.png" class="hidden w-4 h-4 sm:w-5 sm:h-5" alt="voice resume icon">
            </div>

            <button type="submit"
                class="bg-black text-white text-xs sm:text-sm py-[8px] px-3 sm:px-[17px] rounded-md hover:bg-gray-800">
                Search
            </button>

        </form>


    </div>
</section>