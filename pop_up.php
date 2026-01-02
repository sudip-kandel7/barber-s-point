<?php include 'header.php';

$txt = $_GET['txt'] ?? '';

if ($txt === "already") {
    $msg = "Already exists!";
} else if ($txt === "booked") {
    $msg = "Booked!";
} else if ($txt === "error") {
    $msg = "Failed booking!";
} else if ($txt === "login") {
    $msg = "Login!";
} else if ($txt === "updated") {
    $msg = "Info Updated";
} else if ($txt === "notupdated") {
    $msg = "Not Updated";
}
?>

<div id="popUpOverlay" class="fixed inset-0 z-[9999] flex items-end pb-9 justify-center bg-transparent">

    <div id="popUpModal"
        class="px-4 py-3 rounded-xl bg-white/40 shadow-2xl text-gray-800 text-sm font-light animate-fadeIn">
        <?php echo $msg; ?>
    </div>
</div>