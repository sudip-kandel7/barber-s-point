<?php include 'header.php'; ?>


<?php ?>


<style>
body {
    margin: 0;
    padding: 0;
}

section {
    background: linear-gradient(to right, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)),
        url('./public/images/bg.jpeg') center/cover no-repeat;
    height: 100vh;
    width: 100%;
}
</style>

<section class="flex justify-center items-center">
    <div class="border border-black flex flex-col items-center ">
        <img src="./public/images/logo.png" alt="" class="w-[80px] h-[80px">
        <p>Join Barber's Point</p>
        <p>Create your account and discover the best barber shops in your area</p>

        <div class="border border-pink-500 flex flex-col  items-center">
            <h3>Create Account</h3>
            <p>Fill in your information to get started</p>

            <form action="">
                <p>I want to register as</p>
                <select id="">
                    <option value="customer">Customer</option>
                    <option value="barber">Barber Shop</option>
                </select>
                <p>First Name</p>
                <input type="text" placeholder="Enter your first name">
                <p>Last Name</p>
                <input type="text" placeholder="Enter your last name">
                <p>Email Address</p>
                <input type="text" placeholder="Enter your email">
                <p>Phone Number</p>
                <input type="number" placeholder="Enter your phone number">
                <p>Password</p>
                <input type="password" placeholder="Create a password">
                <p>Confirm Password</p>
                <input type="password" placeholder="Confirm your password"><br>
                <input type="checkbox" name="terms" value="">
                <label for="terms">I agree to the <span>Terms and Conditions</span> and <span>Privacy
                        Policy</span></label><br>
                <button type="submit" class="flex"><img src="./public/images/create.png" alt="create icon"
                        class="w-5 h-5" <p>Create
                    Account</p>
                </button>

        </div>

    </div>
</section>