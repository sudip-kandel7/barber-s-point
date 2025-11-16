<nav class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50  ">
  <div class="max-w-7xl mx-auto">
    <div class=" mr-6 ml-5 2xl:m-0 flex items-center justify-between h-12">

      <div class="flex items-center gap-1">
        <img src="./public/images/logo.png" class="w-11 h-11 rounded-full " alt="logo">
        <span class="text-[19px] font-semibold text-gray-800">Barber's Point</span>
      </div>

      <ul class="flex items-center max-[750px]:hidden max-[900px]:gap-10 gap-12 mt-1.5 font-light text-[14px]">

        <li
          class="flex flex-col items-center group cursor-pointer transition-colors duration-300 hover:text-yellow-400">

          Home
          <hr class="w-0 h-[2px] bg-yellow-400 rounded-md transition-all duration-300 group-hover:w-full">

        </li>
        <li
          class="flex flex-col items-center group cursor-pointer transition-colors duration-300 hover:text-yellow-400">
          About Us
          <hr class="w-0 h-[2px] bg-yellow-400 rounded-md transition-all duration-300 group-hover:w-full">

        </li>
        <li
          class="flex flex-col items-center group cursor-pointer transition-colors duration-300 hover:text-yellow-400">
          Contact
          <hr class="w-0 h-[2px] bg-yellow-400 rounded-md transition-all duration-300 group-hover:w-full">

        </li>
      </ul>

      <div class="flex items-center font-light text-sm gap-4 max-[750px]:hidden max-[900px]:gap-2">
        <a href="./login.php"
          class="flex items-center gap-2  h-9 px-3 rounded-md text-black  hover:shadow hover:bg-yellow-500 transition-all duration-300  ">
          <img src="./public/images/enter.png" class="w-3 h-3.w-3" alt="login icon">
          <span>Login</span>
        </a>

        <a href="./register.php"
          class="bg-black text-white h-9 py-2 px-3 flex items-center justify-center rounded-md text-[15px] shadow hover:bg-gray-800 hover:shadow-lg transition-all duration-300">
          Register
        </a>
      </div>


      <!-- Hamburger button -->
      <div class="min-[750px]:hidden flex flex-col p-2 rounded-md hover:bg-yellow-400 cursor-pointer transition-all duration-300"
        id="hamburger">
        <img src="./public/images/menu.png" class="w-4 h-4 hover:bg-yellow-400 img block " alt="">
        <img src="./public/images/close.png" class="w-4 h-4 hover:bg-yellow-400 img hidden" alt="">
      </div>


      <!-- Mobile menu (hidden by default) -->
      <div class="hidden min-[750px]:hidden text-center bg-[#fafafa] w-60 p-4 shadow-md absolute top-[67px] right-4 rounded-md z-50"
        id="mobileMenu">

        <ul class="flex flex-col gap-3">

          <li>
            <a href="#"
              class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:bg-yellow-400 hover:text-white hover:scale-105 transition-all duration-300">
              Home
            </a>
          </li>
          <li>
            <a href="#"
              class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:bg-yellow-400 hover:text-white hover:scale-105 transition-all duration-300">
              About Us
            </a>
          </li>
          <li>
            <a href="#"
              class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:bg-yellow-400 hover:text-white hover:scale-105 transition-all duration-300">
              Contact
            </a>
          </li>


          <hr class="h-1 bg-gray-400 rounded-full shadow-sm my-2">





          <li>
            <a href="./login.php"
              class="flex items-center justify-center gap-2 text-lg font-medium py-2 rounded-md shadow-md bg-gray-50 hover:bg-blue-50 hover:scale-105 transition-all duration-300">
              <img src="./public/images/enter.png"
                class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12"
                alt="login icon">
              <span>Login</span>
            </a>
          </li>

          <li>
            <a href="./register.php"
              class="block text-lg font-medium py-2 rounded-md shadow-md bg-black text-white hover:opacity-90 hover:scale-105 transition-all duration-300">
              Register
            </a>
          </li>
        </ul>

      </div>





    </div>
  </div>
</nav>