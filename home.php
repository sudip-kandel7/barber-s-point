<section style="
  background-image: url('./public/bg.jpeg');
  background-size: cover;      
  background-repeat: no-repeat;
  background-position: center;
" class="h-[82vh] w-full border border-yellow-400">



   <div class="flex justify-center items-center flex-col text-center h-full px-4">
    <div>
      <h1 class="text-4xl md:text-6xl text-black font-bold">Find Your Perfect</h1>
      <h1 class="text-4xl md:text-6xl font-bold text-yellow-500">Barber Shop</h1>
      <p class="text-lg md:text-xl text-gray-300 font-light mt-3">Discover professional barber shops near you. Book appointments,</p>
      <p class="text-lg md:text-xl text-gray-300 font-light">check wait times, and read reviews from real customers.</p>
    </div>
    
   <div class="flex flex-wrap bg-white mt-9 mb-11 h-10 items-center border rounded-xl pl-3 px-2 gap-2 max-[500px]:gap-0">
        
  <label for="search" class="cursor-pointer flex items-center">
        <img src="./public/search-icon.png" class="w-6 h-6 md:w-7 md:h-7" alt="search icon">
      </label>
        <input type="search" id="search" class="h-full flex-1 min-w-0 w-[499px] max-[630px]:w-[200px] max-[500px]:w-[132px] max-[800px]:w-[300px] focus:outline-none" placeholder="Search for shops, locations...">
        <div class="w-12 max-[500px]:w-10 h-full flex items-center hover:bg-yellow-400 justify-center rounded-md border-gray-300 cursor-pointer">
            <img src="./public/voice.png" class="w-6 h-6 max-[500px]:w-4 max-[500px]:h-4" alt="voice search icon">
        </div>
        <button class="bg-black text-white text-sm py-[8px] px-[17px] rounded-md hover:bg-gray-800" >Search</button>
        

    </div>


    <div class="flex gap-8 md:gap-16 text-center text-gray-400">
    <div class="  p-6    min-w-[180px]">
        <div class="flex items-center justify-center gap-1 mb-3">
            <p class="text-4xl font-bold text-yellow-400">50</p>
            <img src="./public/cross.png" alt="" class="w-4 h-4">
        </div>
        <div class="flex items-center justify-center gap-2">
            <img src="./public/shop.png" alt="" class="w-6 h-6">
            <p class="text-gray-300 text-md">Barber Shops</p>
        </div>
    </div>

    <div class=" p-6  min-w-[180px]">
        <div class="flex items-center justify-center gap-1 mb-3">
            <p class="text-4xl font-bold text-yellow-400">1000</p>
            <span class="text-2xl text-yellow-400 font-bold">+</span>
        </div>
        <div class="flex items-center justify-center gap-2">
            <img src="./public/heart.png" alt="" class="w-6 h-6">
            <p class="text-gray-300 text-md">Happy Customers</p>
        </div>
    </div>

    <div class="p-6 min-w-[180px]">
        <div class="flex items-center justify-center gap-1 mb-3">
            <p class="text-4xl font-bold text-yellow-400">4.8</p>
            <img src="./public/star.png" alt="" class="w-5 h-5">
        </div>
        <div class="flex items-center justify-center gap-2">
            <img src="./public/upward.png" alt="" class="w-6 h-6">
            <p class="text-gray-300 text-md">Average Rating</p>
        </div>
    </div>
</div>

</div>

</section>



<!-- 
    
    <div class="flex w-full max-w-[600px] bg-white mt-9 mb-11 h-10 items-center border rounded-xl pl-3 px-2 gap-3">
      <label for="search" class="cursor-pointer">
        <img src="./public/search-icon.png" class="w-6 h-6 md:w-7 md:h-7" alt="search icon">
      </label>
      <input type="search" id="search" 
        class="h-full flex-1 min-w-0 focus:outline-none text-sm md:text-base" 
        placeholder="Search for shops, locations...">
      <div class="w-10 h-full flex items-center hover:bg-yellow-400 justify-center rounded-md border-gray-300 cursor-pointer">
        <img src="./public/voice.png" class="w-5 h-5 md:w-6 md:h-6" alt="voice search icon">
      </div>
      <button class="bg-black text-white text-sm md:text-base py-[6px] px-[16px] rounded-md hover:bg-gray-800">Search</button>
    </div>

    <div class="flex flex-wrap justify-center gap-6 md:gap-16 text-center text-gray-400">
      <div class="p-4 md:p-6 w-[140px] md:min-w-[180px]">
        <div class="flex items-center justify-center gap-1 mb-3">
          <p class="text-3xl md:text-4xl font-bold text-yellow-400">50</p>
          <img src="./public/cross.png" alt="" class="w-3 h-3 md:w-4 md:h-4">
        </div>
        <div class="flex items-center justify-center gap-2">
          <img src="./public/shop.png" alt="" class="w-5 h-5 md:w-6 md:h-6">
          <p class="text-gray-300 text-sm md:text-md">Barber Shops</p>
        </div>
      </div>

      <div class="p-4 md:p-6 w-[140px] md:min-w-[180px]">
        <div class="flex items-center justify-center gap-1 mb-3">
          <p class="text-3xl md:text-4xl font-bold text-yellow-400">1000</p>
          <span class="text-xl md:text-2xl text-yellow-400 font-bold">+</span>
        </div>
        <div class="flex items-center justify-center gap-2">
          <img src="./public/heart.png" alt="" class="w-5 h-5 md:w-6 md:h-6">
          <p class="text-gray-300 text-sm md:text-md">Happy Customers</p>
        </div>
      </div>

      <div class="p-4 md:p-6 w-[140px] md:min-w-[180px]">
        <div class="flex items-center justify-center gap-1 mb-3">
          <p class="text-3xl md:text-4xl font-bold text-yellow-400">4.8</p>
          <img src="./public/star.png" alt="" class="w-4 h-4 md:w-5 md:h-5">
        </div>
        <div class="flex items-center justify-center gap-2">
          <img src="./public/upward.png" alt="" class="w-5 h-5 md:w-6 md:h-6">
          <p class="text-gray-300 text-sm md:text-md">Average Rating</p>
        </div>
      </div>
    </div>
  </div>
</section> -->

1