<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include 'sessionCheck.php';

$conn = mysqli_connect("localhost", "root", "", "barber_point");

$uid = $_SESSION['user']->uid;

$qry = "SELECT name, email, phone, address FROM users WHERE users.uid = $uid";
$result = mysqli_query($conn, $qry);
$userData = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<div id="overlayp" class="fixed flex items-center justify-center inset-0 bg-black/60 z-50">

    <div id="profileModal" class="bg-white w-full max-w-md rounded-xl shadow-xl px-6 py-4">
        <h2 class="text-xl font-semibold text-gray-900">Edit Profile</h2>
        <p class="text-sm text-gray-500 mb-6">Update your profile information</p>

        <form id="updateform" class="space-y-4" method="POST">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>
                <input onkeyup="validate('name',this)" name="name" type="text" value="<?php echo $userData['name'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:outline-none focus:border-yellow-400">
                <p class="name text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input oninput="validate('email',this)" name="email" type="email"
                    value="<?php echo $userData['email'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:border-yellow-400">
                <p class="email text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Phone
                </label>
                <input onkeyup="validate('phone',this)" name="phone" type="text"
                    value="<?php echo $userData['phone'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:outline-none focus:border-yellow-400">
                <p class="phone text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                    Address
                </label>
                <input onkeyup="validate('address',this)" name="address" type="text"
                    value="<?php echo $userData['address'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:outline-none  focus:border-yellow-400">
                <p class="address text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div class="flex justify-end gap-3 mt-10">
                <button id="cancel" type="button"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </button>
                <button name="save" type="submit"
                    class="px-4 py-2 rounded-lg bg-yellow-400 text-white font-semibold hover:bg-yellow-500 flex items-center justify-center gap-2">
                    <img src="./public/images/web/update.png" class="w-5 h-5" alt="">
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</div>