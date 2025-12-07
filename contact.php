<?php include 'header.php';
include 'navbar.php';
?>
<section class=" pt-12 bg-[#f8f9fa] h-[100vh] text-center">
    <div class="">
        <p class="text-3xl sm:text-4xl md:text-6xl text-black font-semibold leading-tight mb-5">Get In
            <span class="text-yellow-500">Touch</span>
        </p>
        <p class="text-xl text-gray-500 mt-3 mx-auto">Ready for your next
            great cut? Contact us to book an appointment or ask any questions.</p>
        <p class="text-xl text-gray-500 mx-auto">We're here to help
            you look and feel your best.</p>
    </div>

    <div class="grid grid-cols-2 max-w-[1400px] justify-center mx-auto mt-12 gap-16 lg2:grid-cols-1">

        <div class="flex flex-col w-full p-4 gap-8 text-start">
            <p class="text-3xl font-bold mt-5">Visit Us</p>
            <div
                class="flex bg-white shadow-md gap-5 px-4 py-3 justify-start items-center hover:-translate-y-1 hover:shadow-lg transition-all  rounded-lg">
                <img src="./public/images/map.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Address</p>
                    <P>Birendra Multiple campus</P>
                    <p>Bharatpur,Nepal</p>
                </div>
            </div>
            <div
                class="flex bg-white shadow-md gap-5 px-4 py-3 justify-start items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/phone.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Phone</p>
                    <P>98000000</P>
                    <p>97000000</p>
                </div>
            </div>
            <div
                class="flex bg-white shadow-md gap-5 px-4 py-3 justify-start items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/email.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Email</p>
                    <P>kushal@gmail.com</P>
                    <p>sudip@gmail.com</p>
                </div>
            </div>
            <div
                class="flex bg-white shadow-md gap-5 px-4 py-3 justify-start items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/clock.png" class="w-9 h-9" alt="map icon">
                <div>
                    <p>Hours</p>
                    <P>Monday - Saturday: 9:00 AM - 7:00 PM</P>
                    <p>Sunday: 10:00 AM - 3:00 PM</p>
                </div>
            </div>
        </div>


        <div
            class="border-2 w-full p-4 shadow-md rounded-2xl bg-white hover:-translate-y-1 hover:shadow-lg transition-all ">
            <p class="text-start mb-7 text-2xl font-bold ">Send us a Message</p>
            <div class="h-full flex gap-6 flex-col">

                <div class="flex w-full items-start flex-col">
                    <label class="text-sm mb-1 font-semibold" for="name">Name</label>
                    <input
                        class="px-3 pl-2 text-md w-full py-1 hover:bg-[#f5f5f5] bg-[#f8f9fa] outline-none border rounded-md border-[#E4E4E7] "
                        type="text" name="name" placeholder="Your full name" id="">
                </div>
                <div class="flex w-full items-start flex-col">
                    <label for="email">Email</label>
                    <input
                        class="px-3 pl-2 text-md py-1 w-full bg-[#f5f5f5] border outline-none rounded-md border-[#E4E4E7] "
                        type="email" name="email" placeholder="your.email@gmail.com">
                </div>
                <div class="flex w-full items-start flex-col">
                    <label for="phone">Phone (Optional)</label>
                    <input
                        class="px-3 pl-2 text-md w-full py-1 bg-[#f5f5f5] border outline-none rounded-md border-[#E4E4E7] "
                        type="text" name="phone" placeholder="(977) 9800000000" id="">
                </div>
                <div class="flex w-full items-start flex-col">
                    <label for="message">Message</label>
                    <textarea rows="5" cols="20"
                        class="px-3 pl-2 text-md w-full py-1 bg-[#f5f5f5] border outline-none rounded-md border-[#E4E4E7] "
                        name="message" placeholder="Tell us how we can help you..." id=""></textarea>
                </div>
                <button
                    class="bg-black text-white m-3 py-2 rounded-md text-lg hover:bg-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all">Send
                    Message</button>
            </div>
        </div>
    </div>

    <div>

    </div>

</section>
<?php include 'footer.php'; ?>