<?php

require_once 'User.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_POST['create'])) {
    $conn = new mysqli("localhost", "root", "", "barber_point");
    $type = $_POST['pType'];
    $name = $_POST['firstN'];
    $add = $_POST['add'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $password = $_POST['password'];
    $secure = md5($password);

    if ($type === "barber") {
        $sName = $_POST['sname'];
        $sAddress = $_POST['saddress'];
        $selectedServices = [];
        $customServices = [];

        if (!empty($_POST['defaultServices'])) {

            foreach ($_POST['defaultServices'] as $serviceN) {
                $price = $_POST['price'][$serviceN];
                $duration = $_POST['duration'][$serviceN];

                $selectedServices[] = [
                    "name" => $serviceN,
                    "price" => $price,
                    "duration" => $duration
                ];
            }
        }

        if (!empty($_POST['customSNames'])) {
            $names = $_POST['customSNames'];
            $prices = $_POST['customSPrices'];
            $durations = $_POST['customSDurations'];



            for ($i = 0; $i < count($names); $i++) {
                if (!empty($names[$i])) {
                    $customServices[] = [
                        "name" => $names[$i],
                        "price" => $prices[$i],
                        "duration" => $durations[$i]
                    ];
                }
            }
        }


        $image = $_FILES['photos'];
        $imageN = $image['name'];
        $tmpImage = $image['tmp_name'];
        $ext = pathinfo($imageN, PATHINFO_EXTENSION);

        $targetDir = "public/images/barber/";

        $uImageName = uniqid() . '_' . $sName . '.' . $ext;

        $fullPath = $targetDir . $uImageName;

        if (move_uploaded_file($tmpImage, $fullPath)) {
            $stmt1 = "INSERT INTO users (type, name, address, email, phone, passwrd)
VALUES ('$type', '$name', '$add', '$email', '$phone', '$secure')";

            if (mysqli_query($conn, $stmt1)) {
                $uid = mysqli_insert_id($conn);


                $stmt2 = "INSERT INTO shop (sname, saddress, photo, uid)
                VALUES ('$sName', '$sAddress', '$fullPath', '$uid')";

                if (mysqli_query($conn, $stmt2)) {
                    $sid = mysqli_insert_id($conn);


                    foreach ($selectedServices as $value) {

                        $serviceName  = $value['name'];
                        $price        = $value['price'];
                        $duration     = $value['duration'];

                        $q1 = "SELECT services_id FROM services WHERE services_name = '$serviceName'";
                        $r1 = mysqli_query($conn, $q1);

                        if (mysqli_num_rows($r1) > 0) {
                            $row = mysqli_fetch_assoc($r1);
                            $serviceId = $row['services_id'];
                        } else {
                            $q2 = "INSERT INTO services (services_name) VALUES ('$serviceName')";
                            mysqli_query($conn, $q2);
                            $serviceId = mysqli_insert_id($conn);
                        }

                        $q3 = "INSERT INTO shop_services (sid, services_id, price, duration)
           VALUES ('$sid', '$serviceId', '$price', '$duration')";
                        mysqli_query($conn, $q3);
                    }


                    foreach ($customServices as $value) {

                        $serviceName = $value['name'];
                        $price       = $value['price'];
                        $duration    = $value['duration'];

                        $q1 = "SELECT services_id FROM services WHERE services_name = '$serviceName'";
                        $r1 = mysqli_query($conn, $q1);

                        if (mysqli_num_rows($r1) > 0) {

                            $row = mysqli_fetch_assoc($r1);
                            $serviceId = $row['services_id'];
                        } else {

                            $q2 = "
            INSERT INTO services (services_name)
            VALUES ('$serviceName')
        ";
                            mysqli_query($conn, $q2);

                            $serviceId = mysqli_insert_id($conn);
                        }

                        $q3 = "
        INSERT INTO shop_services
        (sid, services_id, price, duration)
        VALUES ('$sid', '$serviceId', '$price', '$duration')
    ";
                        mysqli_query($conn, $q3);
                    }



                    $user = new User($email, $type, $uid, $sid);
                    $_SESSION['user'] = $user;

                    $cookieData = json_encode($user);
                    setcookie("user", $cookieData, time() + 86400 * 30, "/");


                    echo "<script>
    window.location.href = '/barber-s-point'
    </script>";
                    // header("Location: index.php");
                    // exit();
                } else {
                    echo "Error inserting shop: " . mysqli_error($conn);
                }
            } else {
                echo "Error inserting user: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        $stmt = "INSERT INTO users (type, name, address, email, phone, passwrd)
    VALUES ('$type', '$name', '$add', '$email', '$phone', '$secure')";

        if (mysqli_query($conn, $stmt)) {

            $uid = mysqli_insert_id($conn);
            $user = new User($email, $type, $uid);
            $_SESSION['user'] = $user;

            $cookieData = json_encode($user);
            setcookie("user", $cookieData, time() + 86400 * 30, "/");

            echo "<script>
    window.location.href = '/barber-s-point'
    </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}


include 'header.php';
?>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    section {
        background: linear-gradient(to right, rgba(255, 255, 255, 0.77), rgba(255, 255, 255, 0.77)),
            url('./public/images/web/bg.jpeg') center/cover no-repeat;
        min-height: 100vh;
        width: 100%;
    }
</style>

<section class="flex justify-center items-center py-6 px-2">
    <div class="flex flex-col items-center w-full max-w-[800px]">
        <img src="./public/images/web/logo.png" alt="" class="w-[80px] h-[80px]">
        <p class="text-3xl font-bold mb-2 text-center px-2">Join Barber's Point</p>
        <p class="text-gray-500 text-xl text-center px-4">Create your account and discover the best barber shops in
            your
            area</p>

        <div class="rounded-lg bg-[#f3f3f3] flex flex-col items-center mt-5 px-3 md:px-6 py-4 shadow-md w-full">
            <h3 class="text-2xl font-semibold">Create Account</h3>
            <p>Fill in your information to get started</p>

            <form action="" id="form" method="post" class="mt-5 flex flex-col gap-5 w-full"
                enctype="multipart/form-data">

                <div class="px-3">
                    <label for="pType" class="font-medium">I want to register as</label> <br>
                    <select id="select" name="pType" class="w-full mt-1.5 h-11 pl-2 pr-2 rounded-[9px] bg-white"
                        required>
                        <option value="customer">Customer</option>
                        <option value="barber">Barber Shop Owner</option>
                    </select>
                </div>


                <div class="flex flex-col min-[701px]:flex-row gap-5 md:gap-9 lg:gap-24 px-3">
                    <div class="w-full min-[701px]:w-80">
                        <label for="firstN" class="font-medium">Full Name</label> <br>
                        <input name="firstN" type="text" inputmode="text"
                            class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-full" required
                            placeholder="Enter your first name">
                        <p class="firstN text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div class="w-full min-[701px]:w-80">
                        <label for="add" class="font-medium">Address</label> <br>
                        <input name="add" type="text" required
                            class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-full"
                            placeholder="Enter your address">
                        <p class="add text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                </div>


                <div class="flex flex-col min-[701px]:flex-row gap-5 md:gap-9 lg:gap-24 px-3">
                    <div class="w-full min-[701px]:w-80">
                        <label for="email" class="font-medium">Email Address</label> <br>
                        <input name="email" type="text" inputmode="text" inputmode="email"
                            class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-full" required
                            placeholder="Enter your email">
                        <p class="email text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div class="w-full min-[701px]:w-80">
                        <label for="number" class="font-medium">Phone Number</label> <br>
                        <input name="number" type="number" inputmode="numeric"
                            class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-full"
                            placeholder="Enter your phone number">
                        <p class="number text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>

                </div>


                <div class="flex flex-col min-[701px]:flex-row gap-5 md:gap-9 lg:gap-24 px-3 mb-1.5">
                    <div class="relative w-full min-[701px]:w-80">
                        <label for="password" class="font-medium">Password</label> <br>
                        <input name="password" id="pass1" type="password"
                            class="mt-1.5 pl-2 pr-10 text-md h-11 rounded-[9px] bg-white w-full" required
                            placeholder="Create a password">
                        <img src="./public/images/web/visible.png" id="toggle1"
                            class="w-4 h-4 absolute top-11 right-3 cursor-pointer" alt="show password icon">
                        <p class="password text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div class="relative w-full min-[701px]:w-80">
                        <label for="cPassword" class="font-medium">Confirm Password</label> <br>
                        <input name="cPassword" id="pass2" type="password"
                            class="mt-1.5 pl-2 pr-10 text-md h-11 rounded-[9px] bg-white w-full" required
                            placeholder="Confirm your password">
                        <img src="./public/images/web/visible.png" id="toggle2"
                            class="w-4 h-4 absolute top-11 right-3 cursor-pointer" alt="show password icon">
                        <p class="cPassword text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                </div>


                <div id="barberinfo" class="py-2 px-3 md:px-5 rounded-md shadow-md bg-[#fef2f2] hidden">
                    <h2 class="mt-2 text-xl font-semibold">Shop Information</h2> <br>
                    <div class="flex flex-col gap-2">
                        <div>
                            <label for="sname" class="font-medium">Shop Name</label> <br>
                            <input type="text" inputmode="text" name="sname"
                                class="mt-1.5 w-full rounded-md text-md pl-2 h-11" placeholder="Enter your shop name">
                            <p class="sname text-red-600 text-sm pl-2 mt-0.5"></p>
                        </div>
                        <div>
                            <label for="address" class="font-medium">Shop Address</label> <br>
                            <input type="text" inputmode="text" name="saddress"
                                class="mt-1.5 w-full rounded-md text-md pl-2 h-11"
                                placeholder="Enter your complete shop address"> <br>
                            <p class="saddress text-red-600 text-sm pl-2 mt-0.5"></p>
                        </div>

                        <div>
                            <p class="font-medium mb-2">Services Offered <span class="text-red-600">*</span></p>
                            <p id="serviceErr" class="text-sm text-red-600 font-bold mb-3 pl-2 mt-0.5">
                            </p>

                            <p class="font-medium mb-1.5">Default Services</p>

                            <div class="bg-white flex flex-col gap-2 p-3 rounded-md shadow-md">
                                <?php
                                $conn = new mysqli("localhost", "root", "", "barber_point");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                $sql = "SELECT * FROM services";
                                $result = $conn->query($sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $serviceName = $row['services_name'];
                                        $serviceValue = strtolower(str_replace(' ', '', $serviceName));
                                ?>


                                        <div class="default-service flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5">
                                            <div class="flex gap-3 items-center">
                                                <input type="checkbox" name="defaultServices[]"
                                                    value="<?php echo $serviceValue; ?>" class="flex-shrink-0">
                                                <label for="<?php echo $serviceValue; ?>"
                                                    class="w-24 flex-shrink-0"><?php echo $serviceName; ?></label>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <input type="number" placeholder="Price (Rs.)"
                                                    name="price[<?php echo $serviceValue; ?>]"
                                                    class="<?php echo $serviceValue; ?>p bg-gray-100 border-2 border-gray-400 rounded-md w-full text-md py-1 px-3">
                                                <p class="<?php echo $serviceValue; ?>p text-red-600 text-sm pl-2 mt-0.5"></p>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <input type="number" placeholder="Duration (min)"
                                                    name="duration[<?php echo $serviceValue; ?>]"
                                                    class="<?php echo $serviceValue; ?>d bg-gray-100 border-2 border-gray-400 rounded-md w-full text-md py-1 px-3">
                                                <p class="<?php echo $serviceValue; ?>d text-red-600 text-sm pl-2 mt-0.5"></p>
                                            </div>
                                        </div>

                                <?php
                                    }
                                }
                                $conn->close();
                                ?>
                            </div>
                        </div>

                        <p class="font-medium mt-2 mb-1.5">Custom Services</p>

                        <div class="bg-white p-3 rounded-md shadow-md">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <input type="text" inputmode="text"
                                    class="bg-gray-100 border-2 border-gray-400 rounded-md mb-1.5 text-md py-1 px-3"
                                    id="customName" placeholder="Service Name">

                                <input type="number" inputmode="numeric"
                                    class=" bg-gray-100 border-2 border-gray-400 rounded-md mb-1.5 text-md py-1 px-3"
                                    id="customPrice" placeholder="Price (Rs.)">

                                <input type="number" inputmode="tel"
                                    class="bg-gray-100 border-2 border-gray-400 rounded-md mb-1.5 text-md py-1 px-3"
                                    id="customDuration" placeholder="Duration (min)">

                            </div>
                            <p class="customErr text-center text-red-600
                                    text-sm pl-2 mt-0.5">
                            </p>
                            <button type="button" onclick="addCustomService()"
                                class="mt-3 mb-2 flex justify-center border-none items-center border bg-yellow-500 rounded-xl hover:bg-yellow-400 w-full gap-3 py-2 text-xl font-medium">
                                <img src="./public/images/web/black-cross.png" alt="create icon" class="w-5 h-5">
                                <p>Add Custom Service</p>
                            </button>
                        </div>

                        <div id="customList"></div>
                    </div>

                    <div>
                        <label for="photos" class="font-medium">Upload barber Shop Photo:</label> <br>
                        <input type="file" name="photos" class="mt-1.5 w-full rounded-md text-md pl-2 h-11" id="photos"
                            accept=".jpg,.jpeg,.png">
                        <p class="photoErr -mt-2 text-red-600 text-sm pl-2"></p>
                    </div>
                </div>

                <div class="flex items-start gap-2 px-3">
                    <input type="checkbox" name="terms" class="accent-yellow-300 w-5 h-5 mt-0.5 flex-shrink-0">
                    <label for="terms">
                        I agree to the <span
                            class="text-yellow-500 hover:underline hover:cursor-pointer hover:text-yellow-600">Terms
                            and Conditions</span> and
                        <span class="text-yellow-500 hover:underline hover:cursor-pointer hover:text-yellow-600">Privacy
                            Policy</span>
                    </label>
                </div>


                <button type="submit" name="create" id="create"
                    class="flex justify-center items-center border bg-yellow-400 rounded-xl hover:bg-yellow-500 w-full gap-3 py-3 text-xl font-medium">
                    <img src="./public/images/web/create.png" alt="create icon" class="w-5 h-5">
                    <p>Create Account</p>
                </button>


                <div class="flex flex-wrap gap-2 justify-center m-1">
                    <p class="text-gray-500">Already have an account?</p>
                    <a href="./login">
                        <span class="text-yellow-500 hover:text-yellow-600 hover:underline">Sign in here</span>
                    </a>
                </div>
            </form>
        </div>


        <a href="/barber-s-point" class="flex gap-2 mt-4 items-center group cursor-pointer">
            <img src="./public/images/web/left-arrow.png" class="w-4 h-4 group-hover:hidden" alt="arrow to home">
            <img src="./public/images/web/left-arrow-yellow.png" class="w-4 h-6 hidden group-hover:block"
                alt="arrow to home" id="photos">
            <p class="text-gray-500 group-hover:text-yellow-400">Back to Home</p>
        </a>
    </div>
</section>

<?php include 'footer.php'; ?>