<?php include 'header.php'; ?>


<?php


?>



<style>
    body {
        margin: 0;
        padding: 0;
    }

    section {
        background: linear-gradient(to right, rgba(255, 255, 255, 0.77), rgba(255, 255, 255, 0.77)),
            url('./public/images/loginbg.jpg') center/cover no-repeat;
        min-height: 100vh;
        width: 100%;
    }
</style>

<section class="border border-black flex flex-col justify-center items-center">

    <img src="./public/images/logo.png" alt="logo" class="w-[80px] h-[80px]">

    <h3 class="text-3xl font-bold mb-2">Welcome Back To Barber's Point</h3>

    <p class="text-gray-500 text-xl">Sign in to access your account</p>

    <div class="rounded-lg bg-[#f3f3f3] flex flex-col items-center mt-5 py-5 shadow-md w-[25vw]">

        <h3 class="text-2xl font-semibold">Sign In</h3>

        <p class="text-gray-500">Enter your credentials to access your account</p>

        <form action="" method="post" class="w-[90%] flex flex-col mt-3">

            <label for="type" class="font-medium">I am a</label>
            <select name="type" class="w-full mt-1.5 h-11 pl-2 pr-2 rounded-[9px] bg-white" id="">
                <option value="customer">customer</option>
                <option value="barber">Barber Shop</option>
                <option value="admin">Admin</option>
            </select>

            <label for="email" class="font-medium mt-5">Email Address</label>
            <input name="email" type="text" class="w-full mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white"
                placeholder="Enter your email">

            <div class="relative mt-5">
                <label for="password" class="font-medium">Password</label> <br>
                <input name="password" id="pass1" type="password"
                    class="w-full mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white" placeholder="Create a password">
                <img src="./public/images/visible.png" id="toggle1"
                    class="w-4 h-4 absolute top-11 right-[18px] cursor-pointer" alt="show password icon">
            </div>
            <button type="submit" name="create"
                class="flex justify-center mt-5 items-center border bg-yellow-400 rounded-xl hover:bg-yellow-300 w-full gap-3 py-3 text-xl font-medium">
                <img src="./public/images/enter.png" alt="create icon" class="w-5 h-5">
                <p>Sign In</p>
            </button>

            <div class="flex gap-2 justify-center m-3 border-none">
                <p class="text-gray-500">Don't have an account?</p>
                <a href="./register">
                    <span class="text-yellow-500 hover:text-yellow-600 hover:underline">Sign up here</span>
                </a>
            </div>


        </form>

    </div>


    <a href="/barber-s-point" class="flex gap-2 mt-4 items-center group cursor-pointer">
        <img src="./public/images/left-arrow.png" class="w-4 h-4 group-hover:hidden" alt="arrow to home">
        <img src="./public/images/left-arrow-yellow.png" class="w-4 h-6 hidden group-hover:block" alt="arrow to home">
        <p class="text-gray-500 group-hover:text-yellow-400">Back to Home</p>
    </a>

</section>



<?php include 'footer.php'; ?>