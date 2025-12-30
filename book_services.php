<?php
session_start();

include 'header.php';
include 'sessionCheck.php';
// include 'sessionCheck.php';


$conn = new mysqli("localhost", "root", "", "barber_point");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['sid'])) {
    exit;
}

$sid = (int) $_GET['sid'];
$uid = $_SESSION['user']->uid;

$result = mysqli_query($conn, "SELECT 
    services.services_id,
    services.services_name,
    shop_services.price,
    shop_services.duration
FROM shop_services
LEFT JOIN services 
    ON services.services_id = shop_services.services_id
WHERE shop_services.sid = '$sid';
");

?>

<div id="bookOverlay" class="fixed inset-0 bg-black/60 z-[9998] flex items-center justify-center">

    <div id="bookModal" class="bg-white rounded-lg shadow-xl
              max-w-2xl w-full mx-4 
              max-h-[80vh] overflow-y-auto
              relative
             0">

        <div class="p-3 flex items-center justify-between">
            <h2 class="font-semibold text-2xl">Book Appointment</h2>
            <img id="close" class="w-4 h-4 transition-hover duration-75 hover:w-[1.1rem] hover:h-[1.1rem]"
                src="./public/images/web/crossG.png" alt="">
        </div>

        <hr class="w-full h-2 ">

        <div class="m-4">
            <p class="text-lg font-semibold mb-4">Selected services</p>
            <div class="servicesDetails max-h-[40vh] overflow-y-auto">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div
                        class="border rounded-md w-full border-gray-300 flex items-center justify-between px-3 py-3 mb-3 hover:bg-yellow-50 transition-all duration-75">
                        <div class="flex items-center gap-3">
                            <input type="checkbox"
                                onclick="booking(<?php echo $sid ?>, <?php echo $row['price'] ?>, <?php echo $row['duration'] ?>)"
                                class="checkboxes w-5 h-5" data-service-id="<?php echo $row['services_id'] ?>"
                                data-service-name="<?php echo $row['services_name'] ?>"
                                data-price="<?php echo $row['price'] ?>" data-duration="<?php echo $row['duration'] ?>">
                            <div class="">
                                <p class="font-medium"><?php echo $row['services_name'] ?></p>
                                <p class="text-sm text-gray-400"><?php echo $row['duration'] ?> mins</p>
                            </div>
                        </div>
                        <p class="font-semibold text-yellow-400">Rs. <?php echo $row['price'] ?> </p>
                    </div>
                <?php } ?>
            </div>



            <div class=" bg-gray-50 border border-gray-300 rounded-md p-3 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <p class="text-gray-600">Total Duration: </p>
                    <p class="text-base font-semibold"><span id="duration">0</span> mins</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-gray-600">Total Price: </p>
                    <p class="text-base font-semibold text-yellow-400">Rs. <span id="price">0</span></p>
                </div>
            </div>

            <button id="bookbtn" onclick="adding(<?php echo $sid ?>)" disabled
                class="rounded-md bg-gray-200 w-full hover:cursor-not-allowed mt-4 py-2.5 text-md text-gray-500 font-semibold">Select
                at
                least
                one
                service</button>
        </div>
    </div>
</div>

<script>
    // const closebtn = document.getElementById("close");
    // const bookOverlay = document.getElementById("bookOverlay");

    // if (closebtn && bookOverlay) {
    //     closebtn.addEventListener("click", function() {
    //         bookOverlay.remove();
    //     });
    // }
</script>

<?php include 'footer.php' ?>