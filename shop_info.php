<?php
include 'sessionCheck.php';
include 'header.php';

$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uid = $_SESSION['user']->uid;
$sid = $_SESSION['user']->sid;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $bname = $_POST['bname'];
    $bemail = $_POST['bemail'];
    $bphone = $_POST['bphone'];
    $baddress = $_POST['baddress'];

    $qry5 = "UPDATE users SET name = '$bname', email = '$bemail', phone = '$bphone', address = '$baddress' WHERE uid = '$uid'";
    $result5 = mysqli_query($conn, $qry5);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_shop'])) {
    $sname = $_POST['sname'];
    $saddress = $_POST['saddress'];


    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $uploadDir = 'public/images/barber/';

        $qryOldPhoto = "SELECT photo FROM shop WHERE uid = '$uid'";
        $resultOldPhoto = mysqli_query($conn, $qryOldPhoto);
        $oldPhotoData = mysqli_fetch_assoc($resultOldPhoto);

        $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
        $targetFile = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            if (!empty($oldPhotoData['photo']) && file_exists($oldPhotoData['photo'])) {
                unlink($oldPhotoData['photo']);
            }
        }
    }

    $qry6 = "UPDATE shop SET sname = '$sname', saddress = '$saddress', photo = '$targetFile' WHERE uid = '$uid'";
    $result6 = mysqli_query($conn, $qry6);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $services_id = $_POST['service_select'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    if ($services_id === 'new') {
        $new_service_name = mysqli_real_escape_string($conn, trim($_POST['new_service_name']));
        $qry7 = "INSERT INTO services (services_name) VALUES ('$new_service_name')";
        $result7 = mysqli_query($conn, $qry7);
        if ($result7) {
            $services_id = mysqli_insert_id($conn);
        }
    }

    if ($services_id && $sid) {
        $qry8 = "INSERT INTO shop_services (sid, services_id, price, duration) VALUES ('$sid', '$services_id', '$price', '$duration')";
        $result8 = mysqli_query($conn, $qry8);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_service'])) {
    $services_id = $_POST['services_id'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $qry9 = "UPDATE shop_services SET price = '$price', duration = '$duration' WHERE sid = '$sid' AND services_id = '$services_id'";
    $result9 = mysqli_query($conn, $qry9);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_service'])) {
    $services_id = $_POST['services_id'];

    $qry10 = "DELETE FROM shop_services WHERE sid = '$sid' AND services_id = '$services_id'";
    $result10 = mysqli_query($conn, $qry10);
}

$qry1 = "SELECT name, email, phone, address FROM users WHERE uid = '$uid'";
$result1 = mysqli_query($conn, $qry1);
$userData = mysqli_fetch_assoc($result1);

$qry2 = "SELECT sname, saddress, photo FROM shop WHERE uid = '$uid'";
$result2 = mysqli_query($conn, $qry2);
$shopData = mysqli_fetch_assoc($result2);

$qry3 = "SELECT services_id, services_name FROM services ORDER BY services_name";
$result3 = mysqli_query($conn, $qry3);
$allServices = [];
while ($row = mysqli_fetch_assoc($result3)) {
    $allServices[] = $row;
}

$shopServices = [];
if ($sid) {
    $qry4 = "SELECT shop_services.services_id, services.services_name, shop_services.price, shop_services.duration 
             FROM shop_services
             JOIN services ON shop_services.services_id = services.services_id 
             WHERE shop_services.sid = '$sid' ORDER BY services.services_name";
    $result4 = mysqli_query($conn, $qry4);
    while ($row = mysqli_fetch_assoc($result4)) {
        $shopServices[] = $row;
    }
}

$conn->close();
?>

<section class="bg-[#F4F4F9] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-grey-900">Shop Info Update</h1>
            <p class="text-gray-600 mt-1">Manage your profile, shop details and services</p>
        </div>


        <div class="bg-white rounded-t-lg shadow-sm p-2 flex flex-col md:flex-row justify-center items gap-3 mb-0.5">
            <button id="personInfo" onclick="switchInfo('personInfo')"
                class="info-btn bg-yellow-400 flex w-full gap-3 px-2 py-1 items-center rounded-lg text-white font-semibold">
                <img src="./public/images/web/personInfoW.png" class="w-10 h-10" alt="">
                <p>Personal Info</p>
            </button>
            <button id="shopInfo" onclick="switchInfo('shopInfo')"
                class="info-btn hover:bg-gray-100 flex w-full gap-3 px-2 py-1 items-center rounded-lg text-gray-700 font-semibold">
                <img src="./public/images/web/shopInfoB.png" class="w-7 h-7" alt="">
                <p>Shop Details</p>
            </button>
            <button id="servicesInfo" onclick="switchInfo('servicesInfo')"
                class="info-btn hover:bg-gray-100 flex w-full gap-3 px-2 py-1 items-center rounded-lg text-gray-700 font-semibold">
                <img src="./public/images/web/servicesInfoB.png" class="w-7 h-7" alt="">
                <p>Services & Pricing</p>
            </button>
        </div>

        <!-- Personal info showing div -->
        <div id="personInfoD" class="infoD bg-white p-4 rounded-b-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Personal Information</h2>
            <form id="profileForm" method="POST" class="mt-3">
                <input type="hidden" name="update_profile" value="1">
                <div class="grid grid-cols-1 gap-6 mb-7">
                    <div>
                        <label for="bname" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" required id="bname" name="bname"
                            value="<?php echo $userData['name'] ?? ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="bnameErr" class="text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="bemail" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" required id="bemail" name="bemail"
                            value="<?php echo $userData['email'] ?? ''; ?>"
                            data-original="<?php echo $userData['email'] ?? ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="bemailErr" class="text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="bphone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" required id="bphone" name="bphone"
                            value="<?php echo $userData['phone'] ?? ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="bphoneErr" class="text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="baddress" class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <input type="text" required id="baddress" name="baddress"
                            value="<?php echo $userData['address'] ?? ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="baddressErr" class="text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-5">
                    <button type="submit" id="shopPbtn"
                        class="flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-lg font-semibold transition-all">
                        <img src="./public/images/web/update.png" class="w-4 h-4" alt="">
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Shop info showing div -->
        <div id="shopInfoD" class="infoD bg-white p-4 rounded-b-lg hidden">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Shop Information</h2>
            <form id="shopForm" method="POST" enctype="multipart/form-data" class="mt-3">
                <input type="hidden" name="update_shop" value="1">
                <div class="grid grid-cols-1 gap-6 mb-7">
                    <div>
                        <label for="sname" class="block text-sm font-semibold text-gray-700 mb-2">Shop Name</label>
                        <input type="text" required id="sname" name="sname"
                            value="<?php echo $shopData['sname'] ?? ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="snameErr" class="text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="saddress" class="block text-sm font-semibold text-gray-700 mb-2">Shop
                            Address</label>
                        <input type="text" required id="saddress" name="saddress"
                            value="<?php echo $shopData['saddress'] ?? ''; ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="saddressErr" class="text-red-600 text-sm -mb-2 pl-2 mt-0.5"></p>
                    </div>
                    <div>
                        <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">Shop Photo</label>
                        <?php if (!empty($shopData['photo'])): ?>
                        <div class="mb-3">
                            <img src="<?php echo $shopData['photo']; ?>" alt="Current shop photo"
                                class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                        <?php endif; ?>
                        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                        <p id="photoErr" class="text-red-600 text-sm pl-2 mt-2"></p>
                        <p class="text-gray-500 text-xs mt-1.5 pl-3">Maximum file size: 5MB</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-5">
                    <button type="submit" id="shopUpdateBtn"
                        class="flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-lg font-semibold transition-all">
                        <img src="./public/images/web/update.png" class="w-4 h-4" alt="">
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Services info showing div -->
        <div id="servicesInfoD" class="infoD bg-white p-4 rounded-b-lg hidden">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Services & Pricing</h2>

            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Add New Service</h3>
                <form id="addServiceForm" method="POST" class="space-y-4">
                    <input type="hidden" name="add_service" value="1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="service_select" class="block text-sm font-semibold text-gray-700 mb-2">Select
                                Service</label>
                            <select id="service_select" name="service_select" required
                                class="w-full px-4 py-3 border-2 border-gray-200 bg-white rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                                <option value="">Select Service</option>
                                <?php foreach ($allServices as $service): ?>
                                <option value="<?php echo $service['services_id']; ?>">
                                    <?php echo $service['services_name']; ?>
                                </option>
                                <?php endforeach; ?>
                                <option value="new">+ Add New Service</option>
                            </select>
                        </div>
                        <div id="newServiceDiv" class="hidden">
                            <label for="new_service_name" class="block text-sm font-semibold text-gray-700 mb-2">New
                                Service Name</label>
                            <input type="text" id="new_service_name" name="new_service_name"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                            <p id="newServiceErr" class="text-red-600 text-sm pl-2 mt-0.5"></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price
                                (Rs.)</label>
                            <input type="number" required id="price" name="price" min="1"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                            <p id="priceErr" class="text-red-600 text-sm pl-2 mt-0.5"></p>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">Duration
                                (minutes)</label>
                            <input type="number" required id="duration" name="duration" min="1"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none transition-colors">
                            <p id="durationErr" class="text-red-600 text-sm pl-2 mt-0.5"></p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" id="addServiceBtn"
                            class="flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold transition-all">
                            <span>+ Add Service</span>
                        </button>
                    </div>
                </form>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-3">Current Services</h3>
            <?php if (empty($shopServices)): ?>
            <p class="text-gray-500 text-center py-8">No services added yet. Add your first service above!</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($shopServices as $service): ?>
                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-yellow-400 transition-colors">
                    <form method="POST" class="service-form">
                        <input type="hidden" name="services_id" value="<?php echo $service['services_id']; ?>">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Service Name</label>
                                <input type="text" readonly value="<?php echo $service['services_name']; ?>"
                                    class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Price (Rs.)</label>
                                <input type="number" name="price" required min="1"
                                    value="<?php echo $service['price']; ?>"
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Duration (min)</label>
                                <input type="number" name="duration" required min="1"
                                    value="<?php echo $service['duration']; ?>"
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-yellow-400 focus:outline-none">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" name="update_service" value="1"
                                    class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold transition-all">
                                    Update
                                </button>
                                <button type="submit" name="delete_service" value="1"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold transition-all">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="flex justify-center mb-6">
        <a href="/barber-s-point/myshop.php"
            class="flex gap-2 items-center group cursor-pointer h-3 mx-auto px-4 sm:px-6 lg:px-8 py-6"">
        <img src=" ./public/images/web/left-arrow.png" class="w-4 h-4 group-hover:hidden" alt="arrow to home">
            <img src="./public/images/web/left-arrow-yellow.png" class="w-4 h-6 hidden group-hover:block"
                alt="arrow to home" id="photos">
            <p class="text-gray-500 group-hover:text-yellow-400">Back to Home</p>
        </a>
    </div>

</section>



<?php include 'footer.php' ?>