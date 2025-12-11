<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include 'sessionCheck.php';
?>

<nav class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 shadow-md z-[70]">
    <div class="max-w-7xl mx-auto">
        <div class=" mr-6 ml-5 2xl:m-0 flex items-center justify-between h-12">

            <div class="flex items-center gap-2">
                <img src="./public/images/logo.png" class="w-11 h-11 rounded-full " alt="logo">
                <span class="text-[22px] font-semibold text-gray-800">Barber's Point</span>
            </div>

            <ul class="flex items-center max-[750px]:hidden max-[900px]:gap-10 gap-20 mt-1.5 font-light text-[16px]">

                <li
                    class="flex flex-col items-center group cursor-pointer transition-colors duration-300 hover:text-yellow-400">

                    <a href="/barber-s-point">Home</a>
                    <hr class="w-0 h-[2px] bg-yellow-400 rounded-md transition-all duration-300 group-hover:w-full">

                </li>
                <li
                    class="flex flex-col items-center group cursor-pointer transition-colors duration-300 hover:text-yellow-400">
                    <a href="about.php">About Us</a>
                    <hr class="w-0 h-[2px] bg-yellow-400 rounded-md transition-all duration-300 group-hover:w-full">

                </li>
                <li
                    class="flex flex-col items-center group cursor-pointer transition-colors duration-300 hover:text-yellow-400">
                    <a href="contact.php">Contact</a>
                    <hr class="w-0 h-[2px] bg-yellow-400 rounded-md transition-all duration-300 group-hover:w-full">

                </li>
            </ul>

            <?php if (!isset($_SESSION['user']->email)): ?>

                <div class="flex items-center font-light text-sm gap-4 max-[750px]:hidden max-[900px]:gap-2">
                    <a href="login.php"
                        class="flex items-center gap-2  h-9 px-3 rounded-md text-black shadow-sm border border-gray hover:scale-105 hover:shadow hover:bg-yellow-400 transition-all duration-300  ">
                        <img src="./public/images/enter.png" class="w-3 h-3.w-3" alt="login icon">
                        <span>Login</span>
                    </a>

                    <a href="./register.php"
                        class="bg-black text-white h-9 py-2 px-3 flex items-center justify-center rounded-md text-[15px] hover:scale-105 shadow hover:bg-gray-800 hover:shadow-lg transition-all duration-300">
                        Register
                    </a>
                </div>

            <?php else: ?>

                <div class="flex items-center font-medium text-md gap-11 max-[750px]:hidden max-[900px]:gap-2">
                    <?php if ($_SESSION['user']->type === "admin"): ?>
                        <a href="./dashboard.php"
                            class="bg-black text-white h-9 py-2 px-3 flex items-center justify-center rounded-md shadow hover:bg-gray-700 hover:shadow-lg transition-all duration-300">
                            Dashboard
                        </a>
                    <?php endif; ?>

                    <div class="relative inline-block">
                        <img src="./public/images/profile.png" onclick="toggleMenu()"
                            class="w-8 h-8 rounded-full cursor-pointer hover:scale-110 transition" alt="profile icon">

                        <div class="hidden text-center bg-[#fafafa] w-60 p-4 shadow-md absolute top-11 -right-[87px] rounded-md z-50"
                            id="menu">

                            <ul class="flex flex-col gap-3">

                                <li>
                                    <a
                                        class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:text-white hover:bg-yellow-400 hover:scale-105 transition-all duration-300">
                                        <?php
                                        $conn = new mysqli("localhost", "root", "", "trypoint");

                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }

                                        $email = $_SESSION['user']->email;

                                        $stmt = "SELECT * FROM users WHERE email = '$email'";
                                        $result = mysqli_query($conn, $stmt);
                                        $row = mysqli_fetch_assoc($result);

                                        $firstN = ucfirst(strtolower($row['firstN']));
                                        $lastN = ucfirst(strtolower($row['lastN']));
                                        $type = ucfirst(strtolower($row['type']));
                                        ?>
                                        <p><?php echo $firstN . " " . $lastN; ?></p>
                                        <p class="text-gray-500 font-light"><?php echo $type; ?></p>

                                    </a>
                                </li>
                                <li>
                                    <a onclick="profile()"
                                        class="block text-lg font-medium py-2 px-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:text-white hover:bg-yellow-400  hover:scale-105 transition-all duration-300">
                                        Profile
                                    </a>

                                </li>


                                <hr class="h-1 bg-gray-400 rounded-full shadow-sm my-2">

                                <li>
                                    <a onclick="logout()"
                                        class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:text-white hover:bg-red-600 hover:scale-105 transition-all duration-300">
                                        Logout
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>



                </div>

            <?php endif; ?>

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
                        <a href="/barber-s-point"
                            class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:bg-yellow-400 hover:text-white hover:scale-105 transition-all duration-300">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="about.php"
                            class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:bg-yellow-400 hover:text-white hover:scale-105 transition-all duration-300">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="contact.php"
                            class="block text-lg font-medium py-2 bg-white text-gray-800 rounded-md shadow-md hover:shadow-lg hover:bg-yellow-400 hover:text-white hover:scale-105 transition-all duration-300">
                            Contact
                        </a>
                    </li>


                    <hr class="h-1 bg-gray-400 rounded-full shadow-sm my-2">

                    <?php if (!isset($_SESSION['user']->email)): ?>

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

                    <?php else: ?>

                        <?php if ($_SESSION['user']->type === "admin"): ?>

                            <li>
                                <a href="./dashboard.php"
                                    class="flex items-center justify-center gap-2 text-lg font-medium py-2 rounded-md shadow-md bg-gray-50 hover:bg-blue-50 hover:scale-105 transition-all duration-300">
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a href="./profile.php"
                                class="flex items-center justify-center gap-2 text-lg font-medium py-2 rounded-md shadow-md bg-gray-50 hover:bg-blue-200 hover:scale-105 transition-all duration-300">
                                <span>Profile</span>
                            </a>
                        </li>

                        <li>
                            <a onclick="logout()"
                                class="flex items-center justify-center gap-2 text-lg font-medium py-2 rounded-md shadow-md bg-gray-50 hover:bg-red-600 hover:text-black hover:scale-105 transition-all duration-300">
                                <img src="./public/images/log-out.png" class="w-4 h-4 transition-transform duration-300"
                                    alt="">
                                <span>Logout</span>
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>
        </div>
    </div>
    <script>
        const hamburger = document.getElementById("hamburger");
        const mobileMenu = document.getElementById("mobileMenu");
        const imgs = hamburger.getElementsByClassName("img");

        hamburger.addEventListener("click", (e) => {
            e.stopPropagation();
            imgs[0].classList.toggle("hidden");
            imgs[1].classList.toggle("hidden");
            mobileMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", (e) => {
            if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add("hidden");
                imgs[0].classList.remove("hidden");
                imgs[1].classList.add("hidden");
            }
        });

        function toggleMenu() {
            document.getElementById("menu").classList.toggle("hidden");
        }

        function logout() {
            window.location.href = "logout.php";
        }

        document.addEventListener("click", function(e) {
            const menu = document.getElementById("menu");
            const profileImg = document.querySelector("img[onclick='toggleMenu()']");

            if (!menu.contains(e.target) && !profileImg.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });
    </script>
</nav>