<?php include 'header.php'; ?>


<?php

session_start();


if (isset($_POST['create'])) {
    $type = $_POST['pType'];
    $firstN = $_POST['firstN'];
    $lastN = $_POST['lastN'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $password = $_POST['password'];
    $cpassword = $_POST['cPassword'];

    if ($type == "barber") {
        $sName = $_POST['Sname'];
        $sAddress = $_POST['address'];
        $experiences = $_POST['exp'];
        $services = $_POST['services'];
        $image = $_FILES['photos'];
    }

    $_SESSION["name"] = $firstN;
    // echo "Session variables are set.";
}
?>



<style>
body {
    margin: 0;
    padding: 0;
}

section {
    background: linear-gradient(to right, rgba(255, 255, 255, 0.77), rgba(255, 255, 255, 0.77)),
        url('./public/images/bg.jpeg') center/cover no-repeat;
    min-height: 100vh;
    width: 100%;
}
</style>

<section class="flex justify-center items-center">
    <div class="flex flex-col items-center">
        <img src="./public/images/logo.png" alt="" class="w-[80px] h-[80px]">
        <p class="text-3xl font-bold mb-2">Join Barber's Point</p>
        <p class="text-gray-500 text-xl">Create your account and discover the best barber shops in your area</p>

        <div class="rounded-lg bg-[#f3f3f3] flex flex-col items-center mt-5 px-6 py-4 shadow-md">
            <h3 class="text-2xl font-semibold">Create Account</h3>
            <p>Fill in your information to get started</p>

            <form action="" id="form" method="post" class="mt-5 flex flex-col gap-5">
                <div>
                    <label for="pType" class="font-medium">I want to register as</label> <br>
                    <select id="select" name="pType" class="w-full mt-1.5 h-11 pl-2 pr-2 rounded-[9px] bg-white">
                        <option class="rounded-md hover:bg-yellow-200" value="customer">Customer</option>
                        <option value="barber">Barber Shop Owner</option>
                    </select>
                </div>

                <div class="flex gap-7">
                    <div>
                        <label for="firstN" class="font-medium">First Name</label> <br>
                        <input name="firstN" type="text" class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-80"
                            placeholder="Enter your first name">
                        <p class="firstN text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="lastN" class="font-medium">Last Name</label> <br>
                        <input name="lastN" type="text" class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-80"
                            placeholder="Enter your last name">
                        <p class="lastN text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                </div>
                <div class="flex gap-7">
                    <div>
                        <label for="email" class="font-medium">Email Address</label> <br>
                        <input name="email" type="text" class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-80"
                            placeholder="Enter your email">
                        <p class="email text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="number" class="font-medium">Phone Number</label> <br>
                        <input name="number" type="text" class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-80"
                            placeholder="Enter your phone number">
                        <p class="number text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                </div>
                <div class="flex gap-7">
                    <div class="relative">
                        <label for="password" class="font-medium">Password</label> <br>
                        <input name="password" id="pass1" type="password"
                            class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-80"
                            placeholder="Create a password">
                        <img src="./public/images/visible.png" id="toggle1"
                            class="w-4 h-4 absolute top-11 left-[291px] cursor-pointer" alt="show password icon">
                        <p class="password text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div class="relative">
                        <label for="cPassword" class="font-medium">Confirm Password</label> <br>
                        <input name="cPassword" id="pass2" type="password"
                            class="mt-1.5 pl-2 text-md h-11 rounded-[9px] bg-white w-80"
                            placeholder="Confirm your password">
                        <img src="./public/images/visible.png" id="toggle2"
                            class="w-4 h-4 absolute top-11 left-[291px] cursor-pointer" alt="show password icon">
                        <p class="cPassword text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                </div>

                <div id="barberinfo" class="py-2 px-5 rounded-md shadow-md bg-[#fef2f2] hidden">
                    <h2 class="mt-2 text-xl font-semibold">Shop Information</h2> <br>
                    <div class="flex flex-col gap-2">
                        <div>
                            <label for="sname" class="font-medium">Shop Name</label> <br>
                            <input type="text" name="sname" class="mt-1.5 mb-3 w-full rounded-md text-md pl-2 h-11"
                                id="" placeholder="Enter your shop name"> <br>
                        </div>
                        <div>
                            <label for="address" class="font-medium">Shop Address</label> <br>
                            <input type="field" name="address" class="mt-1.5 mb-3 w-full rounded-md text-md pl-2 h-11"
                                id="" placeholder="Enter your complete shop address"> <br>
                        </div>
                        <div>
                            <label for="exp" class="font-medium">Experience & Qualifications</label> <br>
                            <textarea rows="4" cols="50" name="exp"
                                class="mt-1.5 mb-3 w-full rounded-md text-md pl-2 pt-1.5 text-gray-500"
                                id="">Describe your experience, certifications, and qualifications</textarea> <br>
                        </div>
                        <div>
                            <label for="services" class="font-medium">Services Offered (Optional)</label> <br>
                            <textarea rows="4" cols="50" name="services"
                                class="mt-1.5 mb-3 w-full rounded-md text-md pl-2 pt-1.5 text-gray-500"
                                id="">List the services you offer  (e.g.,haircuts, beard trims)</textarea> <br>
                        </div>

                        <div>
                            <label for="photos" class="font-medium">Upload barber Shop Photos:</label> <br>
                            <input type="file" name="photos" class="mt-1.5 mb-3 w-full rounded-md text-md pl-2 h-11"
                                id="" accept="images/*" multiple> <br>
                        </div>
                    </div>
                </div>



                <div class="flex items-center gap-2">
                    <input type="checkbox" name="terms" class="accent-yellow-300 w-5 h-5">
                    <label for="terms">
                        I agree to the <span
                            class="text-yellow-500 hover:underline hover:cursor-pointer hover:text-yellow-600">Terms and
                            Conditions</span> and
                        <span class="text-yellow-500 hover:underline hover:cursor-pointer hover:text-yellow-600">Privacy
                            Policy</span>
                    </label>
                </div>

                <button type="submit" name="create"
                    class="flex justify-center items-center border bg-yellow-400 rounded-xl hover:bg-yellow-300 w-full gap-3 py-3 text-xl font-medium">
                    <img src="./public/images/create.png" alt="create icon" class="w-5 h-5">
                    <p>Create Account</p>
                </button>

                <div class="flex gap-2 justify-center m-3">
                    <p class="text-gray-500">Already have an account?</p>
                    <a href="./login">
                        <span class="text-yellow-500 hover:text-yellow-600 hover:underline">Sign in here</span>
                    </a>
                </div>


            </form>

        </div>

        <a href="/barber-s-point" class="flex gap-2 mt-4 items-center group cursor-pointer">
            <img src="./public/images/left-arrow.png" class="w-4 h-4 group-hover:hidden" alt="arrow to home">
            <img src="./public/images/left-arrow-yellow.png" class="w-4 h-6 hidden group-hover:block"
                alt="arrow to home">
            <p class="text-gray-500 group-hover:text-yellow-400">Back to Home</p>
        </a>

    </div>
</section>



<?php include 'footer.php'; ?>