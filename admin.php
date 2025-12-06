<?php

require_once 'User.php';

session_start();
include 'header.php';

if (isset($_POST['login'])) {
    $conn = new mysqli("localhost", "root", "", "trypoint");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt1 = "SELECT uid, passwrd FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $stmt1);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];
        $type = "admin";

        if ($password === $row['passwrd']) {
            $user = new User($email, $type, $uid);
            $_SESSION['user'] = $user;

            $cookieData = json_encode($user);
            setcookie("user", $cookieData, time() + 86400 * 30, "/");


            echo "<script>window.location.href = '/barber-s-point';</script>";
            exit();
        } else {
            echo "<script>
            window.onload = function() {
                document.getElementsByClassName('password')[0].innerText = 'Incorrect password!';
                document.getElementsByName('password')[0].style.border = '2px solid red';
            };
            </script>";
        }
    } else {
        echo "<script>
        window.onload = function() {
            document.getElementsByClassName('email')[0].innerText = 'Email not found!';
            document.getElementsByName('email')[0].style.border = '2px solid red';
        };
        </script>";
    }

    mysqli_close($conn);
}

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

<section class="flex flex-col justify-center items-center py-6 px-2">

    <img src="./public/images/logo.png" alt="logo" class="w-[80px] h-[80px]">

    <h3 class="text-3xl font-bold mb-2 text-center px-2">Welcome Back To Barber's Point</h3>

    <p class="text-gray-500 text-xl text-center px-4">Sign in to access dashboard</p>

    <div class="rounded-lg bg-[#f3f3f3] flex flex-col items-center mt-5 py-5 shadow-md w-full max-w-md px-4">

        <h3 class="text-2xl font-semibold">Sign In</h3>

        <p class="text-gray-500 text-center px-2">Enter given credentials</p>

        <form action="" id="loginform" method="post" class="w-full flex flex-col px-3">

            <label for="email" class="font-medium mt-5">Email Address</label>
            <input name="email" type="text" class="w-full mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white" required
                placeholder="Enter your email">
            <p class="email text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>

            <div class="relative mt-5">
                <label for="password" class="font-medium">Password</label> <br>
                <input name="password" type="password"
                    class="w-full mt-1.5 pl-2 pr-10 text-md h-11 rounded-[9px] bg-white" id="pass" required
                    placeholder="Create a password">
                <img src="./public/images/visible.png" class="w-4 h-4 absolute top-11 right-3 cursor-pointer"
                    id="toggle" alt="show password icon">
                <p class="password text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <button type="submit" name="login"
                class="flex justify-center mt-5 items-center border bg-yellow-400 rounded-xl hover:bg-yellow-300 w-full gap-3 py-3 text-xl font-medium">
                <img src="./public/images/enter.png" alt="create icon" class="w-5 h-5">
                <p>Sign In</p>
            </button>



        </form>

    </div>

    <a href="/barber-s-point" class="flex gap-2 mt-4 items-center group cursor-pointer">
        <img src="./public/images/left-arrow.png" class="w-4 h-4 group-hover:hidden" alt="arrow to home">
        <img src="./public/images/left-arrow-yellow.png" class="w-4 h-6 hidden group-hover:block" alt="arrow to home">
        <p class="text-gray-500 group-hover:text-yellow-400">Back to Home</p>
    </a>

</section>

<?php include 'footer.php'; ?>