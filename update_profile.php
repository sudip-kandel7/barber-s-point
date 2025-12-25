<?php
session_start();

include 'sessionCheck.php';

$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uid = $_SESSION['user']->uid;

// $result = mysqli_query($conn, "SELECT * FROM favorites WHERE uid = '$uid' AND sid = '$sid'");



$qry = "SELECT firstN, email, phone, address FROM users WHERE users.uid = $uid";
$result = mysqli_query($conn, $qry);
$userData = mysqli_fetch_assoc($result);



mysqli_close($conn);
?>

<div id="overlayp" class="fixed flex items-center justify-center inset-0 bg-black/60 z-50">

    <div id="profileModal" class="bg-white w-full max-w-md rounded-xl shadow-xl p-6
           ">



        <h2 class="text-xl font-semibold text-gray-900">Edit Profile</h2>
        <p class="text-sm text-gray-500 mb-6">Update your profile information</p>

        <form class="updateform space-y-4">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>
                <input name="name" type="text" value="<?php echo $userData['firstN'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:outline-none focus:border-yellow-400" />
                <p class="name text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input name="email" type="email" value="<?php echo $userData['email'] ?>" disabled
                    class="w-full rounded-lg border-2 border-gray-300 bg-gray-100 px-3 py-2 text-gray-500 focus:border-yellow-400" />
                <p class="email text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Phone
                </label>
                <input name="phone" type="text" value="<?php echo $userData['phone'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:outline-none focus:border-yellow-400" />
                <p class="phone text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                    Address
                </label>
                <input name="address" type="text" value="<?php echo $userData['address'] ?>"
                    class="w-full rounded-lg border-2 border-gray-300 px-3 py-2 focus:outline-none  focus:border-yellow-400" />
                <p class="address text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
            </div>


        </form>

        <div class="flex justify-end gap-3 mt-6">
            <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                Cancel
            </button>
            <button
                class="px-4 py-2 rounded-lg bg-yellow-400 text-white font-semibold hover:bg-yellow-500 flex items-center justify-center gap-2">
                <img src="./public/images/web/update.png" class="w-5 h-5" alt="">
                Save Changes
            </button>
        </div>

    </div>
</div>