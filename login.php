<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'User.php';


session_start();
include 'header.php';

if (isset($_POST['login'])) {
    $conn = new mysqli("localhost", "root", "", "barber_point");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $type = $_POST['type'];
    $email = $_POST['lemail'];
    $password = $_POST['lpassword'];
    $secure = md5($password);

    $stmt1 = "SELECT uid, passwrd FROM users WHERE email = '$email' AND type = '$type'";
    $result = mysqli_query($conn, $stmt1);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];

        if ($secure === $row['passwrd']) {

            $sidResult = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sid FROM shop WHERE uid = '$uid'"));
            $sid = $sidResult['sid'];

            if ($type === "customer") {
                $user = new User($email, $type, $uid);
                $_SESSION['user'] = $user;

                $cookieData = json_encode($user);
                setcookie("user", $cookieData, time() + 86400 * 30, "/");
            } else if ($type === "barber") {
                $user = new User($email, $type, $uid, $sid);
                $_SESSION['user'] = $user;

                $cookieData = json_encode($user);
                setcookie("user", $cookieData, time() + 86400 * 30, "/");
            }

            echo "<script>window.location.href = '/barber-s-point';</script>";
            exit();
        } else {
            echo "<script>
            window.onload = function() {
                document.getElementsByClassName('lpassword')[0].innerText = 'Incorrect password!';
                document.getElementsByName('lpassword')[0].style.border = '2px solid red';
            };
            </script>";
        }
    } else {
        echo "<script>
        window.onload = function() {
            document.getElementsByClassName('lemail')[0].innerText = 'Email not found!';
            document.getElementsByName('lemail')[0].style.border = '2px solid red';
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
        url('./public/images/web/loginbg.jpg') center/cover no-repeat;
    min-height: 100vh;
    width: 100%;
}
</style>

<section class="flex flex-col justify-center items-center py-6 px-2">

    <img src="./public/images/web/logo.png" alt="logo" class="w-[80px] h-[80px]">

    <h3 class="text-3xl font-bold mb-2 text-center px-2">Welcome Back To Barber's Point</h3>

    <p class="text-gray-500 text-xl text-center px-4">Sign in to access your account</p>

    <div class="rounded-lg bg-[#f3f3f3] flex flex-col items-center mt-5 py-5 shadow-md w-full max-w-md px-4">

        <h3 class="text-2xl font-semibold">Sign In</h3>

        <p class="text-gray-500 text-center px-2">Enter your credentials to access your account</p>

        <form action="" id="loginform" method="post" class="w-full flex flex-col mt-3 px-3">

            <label for="type" class="font-medium">I am a</label>
            <select name="type" id="as" class="w-full mt-1.5 h-11 pl-2 pr-2 rounded-[9px] bg-white">
                <option value="customer">customer</option>
                <option value="barber">Barber Shop</option>
            </select>

            <label for="lemail" class="font-medium mt-5">Email Address</label>
            <input name="lemail" autocomplete="off" type="text"
                class="w-full mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white" required placeholder="Enter your email">
            <p class="lemail text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>

            <div class="relative mt-5">
                <label for="lpassword" class="font-medium">Password</label> <br>
                <input name="lpassword" type="password"
                    class="w-full mt-1.5 pl-2 pr-10 text-md h-11 rounded-[9px] bg-white" id="pass" required
                    placeholder="Create a password">
                <img src="./public/images/web/visible.png" class="w-4 h-4 absolute top-11 right-3 cursor-pointer"
                    id="toggle" alt="show password icon">
                <p class="lpassword text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <button type="submit" name="login"
                class="flex justify-center mt-5 items-center border bg-yellow-400 rounded-xl hover:bg-yellow-300 w-full gap-3 py-3 text-xl font-medium">
                <img src="./public/images/web/enter.png" alt="create icon" class="w-5 h-5">
                <p>Sign In</p>
            </button>

            <div class="flex flex-wrap gap-2 justify-center m-3">
                <p class="text-gray-500">Don't have an account?</p>
                <a href="./register.php">
                    <span class="text-yellow-500 hover:text-yellow-600 hover:underline">Sign up here</span>
                </a>
            </div>

        </form>

    </div>

    <a href="/barber-s-point" class="flex gap-2 mt-4 items-center group cursor-pointer">
        <img src="./public/images/web/left-arrow.png" class="w-4 h-4 group-hover:hidden" alt="arrow to home">
        <img src="./public/images/web/left-arrow-yellow.png" class="w-4 h-6 hidden group-hover:block"
            alt="arrow to home">
        <p class="text-gray-500 group-hover:text-yellow-400">Back to Home</p>
    </a>

</section>

<?php include 'footer.php'; ?>