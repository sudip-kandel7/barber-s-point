<?php
include 'sessionCheck.php';
include 'header.php';

$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uid = $_SESSION['user']->uid;

$qry1 = "SELECT name, email, phone, address FROM users WHERE uid = '$uid'";
$result1 = mysqli_query($conn, $qry1);
$userData = mysqli_fetch_assoc($result1);

$qry2 = "SELECT sname, saddress, photo FROM shop WHERE uid = '$uid'";
$result2 = mysqli_query($conn, $qry2);
$shopData = mysqli_fetch_assoc($result2);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $bname = $_POST['bname'];
    $bemail = $_POST['bemail'];
    $bphone = $_POST['bphone'];
    $baddress = $_POST['baddress'];

    $qry3 = "UPDATE users SET name = '$bname', email = '$bemail', phone = '$bphone', address = '$baddress' WHERE uid = '$uid'";
    $result3 = mysqli_query($conn, $qry3);

    if ($result3) {
        $userData['name'] = $bname;
        $userData['email'] = $bemail;
        $userData['phone'] = $bphone;
        $userData['address'] = $baddress;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_shop'])) {
    $sname = mysqli_real_escape_string($conn, $_POST['sname']);
    $saddress = mysqli_real_escape_string($conn, $_POST['saddress']);

    $photoUpdate = "";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $uploadDir = 'public/images/barber/';

        $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
        $targetFile = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            if (!empty($shopData['photo']) && file_exists($shopData['photo'])) {
                unlink($shopData['photo']);
            }
            $photoUpdate = ", photo = '$targetFile'";
        }
    }

    $qry4 = "UPDATE shop SET sname = '$sname', saddress = '$saddress' $photoUpdate WHERE uid = '$uid'";
    $result4 = mysqli_query($conn, $qry4);

    if ($result4) {
        $qry2 = "SELECT sname, saddress, photo FROM shop WHERE uid = '$uid'";
        $result2 = mysqli_query($conn, $qry2);
        $shopData = mysqli_fetch_assoc($result2);
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
        <div id="servicesInfoD" class="infoD bg-white p-4 rounded-b-lg hidden">Services Info</div>
    </div>
</section>

<script>
    checkErrors();
    checkShopErrors();

    // this is for tab or info switch div 
    function switchInfo(wch) {
        document.querySelectorAll(".infoD").forEach((div) => {
            div.classList.add("hidden");
        });

        document.querySelectorAll(".info-btn").forEach((btn) => {
            btn.classList.remove("bg-yellow-400", "text-white");
            btn.classList.add("hover:bg-gray-100", "text-gray-700");

            const img = btn.querySelector("img");
            if (img) {
                img.src = `./public/images/web/${btn.id}B.png`;
            }
        });

        const activeDiv = document.getElementById(wch + "D");
        if (activeDiv) {
            activeDiv.classList.remove("hidden");
        }

        const activeBtn = document.getElementById(wch);
        activeBtn.classList.remove("hover:bg-gray-100", "text-gray-700");
        activeBtn.classList.add("bg-yellow-400", "text-white");

        const activeImg = activeBtn.querySelector("img");
        if (activeImg) {
            activeImg.src = `./public/images/web/${wch}W.png`;
        }
    }

    // this is for personal info 
    const form = document.getElementById("profileForm");
    const originalEmail = document.getElementById("bemail").dataset.original;

    form.addEventListener("input", (e) => {
        const input = e.target;
        const name = input.name;
        const value = input.value.trim();
        const p = document.getElementById(name + "Err");

        if (value === "") {
            p.innerText = "";
            checkErrors();
            return;
        }

        if (name === "bemail") {
            if (!/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
                p.innerText = "Please enter valid email!";
            } else {
                p.innerText = "";

                if (value !== originalEmail) {
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "emailCheck.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            if (xhr.responseText.trim() === "exists") {
                                p.innerText = "Email already exists!";
                            } else {
                                p.innerText = "";
                            }
                            checkErrors();
                        }
                    };

                    xhr.send("email=" + value);
                }
            }
        }

        if (name === "bname") {
            if (!/^(?=.{2,20}$)[A-Za-z]+(?:\s[A-Za-z]+)*$/.test(value)) {
                p.innerText = "Name must have only letters and (2,20) words.";
            } else {
                p.innerText = "";
            }
        }

        if (name === "bphone") {
            let e = value.slice(2);

            if (/\D/.test(value)) {
                p.innerText = "Phone number must contain only digits.";
            } else if (!value.startsWith("98") && !value.startsWith("97")) {
                p.innerText = "Phone number must start with 98 or 97.";
            } else if (value.length !== 10) {
                p.innerText = "Phone number must be exactly 10 digits.";
            } else if (/^(\d)\1*$/.test(e)) {
                p.innerText = "The remaining part has repeated digits.";
            } else {
                p.innerText = "";
            }
        }

        if (name === "baddress") {
            const pattern = /^[A-Za-z][A-Za-z0-9\-, ]*$/;
            if (!pattern.test(value)) {
                p.innerText = "Must start with letters or only - and , are allowed!";
            } else if (value.length > 25) {
                p.innerText = "Letters must be less than 25!";
            } else {
                p.innerText = "";
            }
        }

        checkErrors();
    });

    function checkErrors() {
        const btn = document.getElementById("shopPbtn");
        const errorMessages = document.querySelectorAll("#profileForm p.text-red-600");
        let hasError = false;

        errorMessages.forEach((p) => {
            if (p.innerText.trim() !== "") {
                hasError = true;
            }
        });

        if (btn) {
            btn.disabled = hasError;

            if (hasError) {
                btn.className =
                    "flex justify-center items-center gap-2 bg-gray-400 hover:bg-gray-500 p-3 text-black rounded-lg font-semibold transition-all cursor-not-allowed opacity-60";
            } else {
                btn.className =
                    "flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-lg font-semibold transition-all";
            }
        }
    }

    // this is for shop info
    const shopForm = document.getElementById("shopForm");

    shopForm.addEventListener("input", (e) => {
        const input = e.target;
        const name = input.name;
        const value = input.value.trim();
        const p = document.getElementById(name + "Err");

        if (value === "") {
            p.innerText = "";
            checkShopErrors();
            return;
        }

        if (name === "sname") {
            const pattern = /^[A-Za-z][A-Za-z ]*$/;
            if (!pattern.test(value)) {
                p.innerText = "Must start with and only contain letters!";
            } else if (value.length > 25) {
                p.innerText = "Letters must be less than 25!";
            } else {
                p.innerText = "";
            }
        }

        if (name === "saddress") {
            const pattern = /^[A-Za-z][A-Za-z0-9\-, ]*$/;
            if (!pattern.test(value)) {
                p.innerText = "Must start with letters or only - and , are allowed!";
            } else if (value.length > 25) {
                p.innerText = "Letters must be less than 25!";
            } else {
                p.innerText = "";
            }
        }

        checkShopErrors();
    });

    document.getElementById("photo").addEventListener("change", function() {
        const file = this.files[0];
        const maxSize = 5 * 1024 * 1024;
        const p = document.getElementById("photoErr");

        if (file && file.size > maxSize) {
            p.innerText = "File size must be less than 5MB!";
            this.value = "";
            checkShopErrors();
        } else {
            p.innerText = "";
            checkShopErrors();
        }
    });

    function checkShopErrors() {
        const btn = document.getElementById("shopUpdateBtn");
        const errorMessages = document.querySelectorAll("#shopForm p.text-red-600");
        let hasError = false;

        errorMessages.forEach((p) => {
            if (p.innerText.trim() !== "") {
                hasError = true;
            }
        });

        if (btn) {
            btn.disabled = hasError;

            if (hasError) {
                btn.className =
                    "flex justify-center items-center gap-2 bg-gray-400 hover:bg-gray-500 p-3 text-black rounded-lg font-semibold transition-all cursor-not-allowed opacity-60";
            } else {
                btn.className =
                    "flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white p-3 rounded-lg font-semibold transition-all";
            }
        }
    }
</script>

<?php include 'footer.php' ?>