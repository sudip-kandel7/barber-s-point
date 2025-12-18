<?php

session_start();
include 'header.php';
include 'navbar.php';
?>

<section class="bg-[#F1F4F9]">

    <div class="flex justify-center items-center flex-col text-center min-h-[40vh] px-4 py-4">
        <div class="mb-6 sm:mb-8 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-6xl text-black font-semibold leading-tight">Your Profile</h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-500 font-light mt-3 max-w-2xl mx-auto">Manage your
                personal information and preferences.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mb-10">
        <h2 class="text-2xl font-semibold mb-4">Profile Information</h2>
        <form action="update_profile.php" method="POST" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    required>
            </div>
            <div>
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['phone']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <button type="submit"
                    class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition duration-300">Update
                    Profile</button>
            </div>
        </form>
    </div>
</section>



<?php
include 'footer.php';
?>