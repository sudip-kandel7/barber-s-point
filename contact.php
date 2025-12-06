<?php include 'header.php';
include 'navbar.php';
?>
<section class="flex flex-col items-center border-2 border-red-500 justify-center h-[100vh] text-center">
    <div>
        <p class="text-3xl sm:text-4xl md:text-6xl text-black font-semibold leading-tight mb-5">Get In
            <span class="text-yellow-500">Touch</span>
        </p>
        <p class="text-xl text-gray-500 mt-3 mx-auto">Ready for your next
            great cut? Contact us to book an appointment or ask any questions.</p>
        <p class="text-xl text-gray-500 mx-auto">We're here to help
            you look and feel your best.</p>
    </div>

    <div class="grid grid-cols-2 mt-5 lg2:grid-cols-1 border-2 border-red-600">

        <div class="flex flex-col gap-2 text-start border-2 border-red-500">
            <p class="text-center text-3xl font-bold">Visit Us</p>
            <div class="flex gap-5 px-4 py-5 justify-start items-center border-2 border-gray-400">
                <img src="./public/images/map.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Address</p>
                    <P>Birendra Multiple campus</P>
                    <p>Bharatpur,Nepal</p>
                </div>
            </div>
            <div class="flex gap-5 px-4 py-5 justify-start items-center border-2 border-gray-400">
                <img src="./public/images/phone.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Phone</p>
                    <P>98000000</P>
                    <p>97000000</p>
                </div>
            </div>
            <div class="flex gap-5 px-4 py-5 justify-start items-center border-2 border-gray-400">
                <img src="./public/images/email.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Email</p>
                    <P>kushal@gmail.com</P>
                    <p>sudip@gmail.com</p>
                </div>
            </div>
            <div class="flex gap-5 px-4 py-5 justify-start items-center border-2 border-gray-400">
                <img src="./public/images/clock.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Hours</p>
                    <P>Monday - Saturday: 9:00 AM - 7:00 PM</P>
                    <p>Sunday: 10:00 AM - 3:00 PM</p>
                </div>
            </div>
        </div>


        <div>
            <p>Send us a Message</p>

            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Your full name" id="">

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="your.email@gmail.com">

            <label for="phone">Phone (Optional)</label>
            <input type="text" name="phone" placeholder="(977) 9800000000" id="">

            <label for="message">Message</label>
            <textarea name="message" placeholder="Tell us how we can help you..." id=""></textarea>
            <!--  message -->
        </div>
    </div>

    <div>

    </div>

</section>
<?php include 'footer.php'; ?>