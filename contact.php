<?php include 'header.php';
include 'navbar.php';
?>
<section class="pt-12 pb-16 bg-[#f8f9fa] min-h-screen text-center">
    <div class="px-4 sm:px-6 lg:px-8">
        <p class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-black font-semibold leading-tight mb-5">Get In
            <span class="text-yellow-500">Touch</span>
        </p>
        <p class="text-base sm:text-lg md:text-xl text-gray-500 mt-3 mx-auto max-w-2xl px-4">Contact us to book an
            appointment or ask any questions.</p>
        <p class="text-base sm:text-lg md:text-xl text-gray-500 mx-auto max-w-2xl px-4">We're here to help
            you look and feel your best.</p>
    </div>

    <div
        class="grid md:grid-cols-2 max-w-[1400px] justify-center mx-auto mt-8 sm:mt-12 gap-6 lg:gap-16 grid-cols-1 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col w-full gap-6 sm:gap-8 text-start">
            <p class="text-2xl sm:text-3xl font-bold mt-3 sm:mt-5">Visit Us</p>
            <div
                class="flex bg-white shadow-md gap-4 sm:gap-5 px-3 sm:px-4 py-3 sm:py-4 justify-start items-start sm:items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/map.png" class="w-8 h-8 sm:w-9 sm:h-9 flex-shrink-0 mt-1 sm:mt-0"
                    alt="map icon">
                <div class="text-sm sm:text-base">
                    <p class="font-semibold mb-1">Address</p>
                    <p class="break-all text-gray-500 font-semilight">Birendra Multiple campus</p>
                    <p class="break-all text-gray-500 font-semilight">Bharatpur, Nepal</p>
                </div>
            </div>
            <div
                class="flex bg-white shadow-md gap-4 sm:gap-5 px-3 sm:px-4 py-3 sm:py-4 justify-start items-start sm:items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/phone.png" class="w-8 h-8 sm:w-9 sm:h-9 flex-shrink-0 mt-1 sm:mt-0"
                    alt="phone icon">
                <div class="text-sm sm:text-base">
                    <p class="font-semibold mb-1">Phone</p>
                    <p class="break-all text-gray-500 font-semilight">98000000</p>
                    <p class="break-all text-gray-500 font-semilight">97000000</p>
                </div>
            </div>
            <div
                class="flex bg-white shadow-md gap-4 sm:gap-5 px-3 sm:px-4 py-3 sm:py-4 justify-start items-start sm:items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/email.png" class="w-8 h-8 sm:w-9 sm:h-9 flex-shrink-0 mt-1 sm:mt-0"
                    alt="email icon">
                <div class="text-sm sm:text-base break-words">
                    <p class="font-semibold mb-1">Email</p>
                    <p class="break-all text-gray-500 font-semilight">kushal@gmail.com</p>
                    <p class="break-all text-gray-500 font-semilight">sudip@gmail.com</p>
                </div>
            </div>
            <div
                class="flex bg-white shadow-md gap-4 sm:gap-5 px-3 sm:px-4 py-3 sm:py-4 justify-start items-start sm:items-center hover:-translate-y-1 hover:shadow-lg transition-all rounded-lg">
                <img src="./public/images/clock.png" class="w-8 h-8 sm:w-9 sm:h-9 flex-shrink-0 mt-1 sm:mt-0"
                    alt="clock icon">
                <div class="text-sm sm:text-base">
                    <p class="font-semibold mb-1">Hours</p>
                    <p class="break-all text-gray-500 font-semilight">Monday - Saturday: 9:00 AM - 7:00 PM</p>
                    <p class="break-all text-gray-500 font-semilight">Sunday: 10:00 AM - 3:00 PM</p>
                </div>
            </div>
        </div>


        <div
            class="border-2 w-full p-4 sm:p-6 shadow-md rounded-2xl bg-white hover:-translate-y-1 hover:shadow-lg transition-all">
            <p class="text-start mb-5 sm:mb-7 text-xl sm:text-2xl font-bold">Send us a Message</p>
            <div class="h-full flex gap-4 sm:gap-6 flex-col">

                <div class="flex w-full items-start flex-col">
                    <label class="text-sm mb-1 sm:mb-2 font-semibold" for="name">Name</label>
                    <input
                        class="px-3 pl-2 text-sm sm:text-md w-full py-2 hover:bg-[#f5f5f5] bg-[#f8f9fa] outline-none border rounded-md border-[#E4E4E7] focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-colors"
                        type="text" name="name" placeholder="Your full name" id="name">
                </div>
                <div class="flex w-full items-start flex-col">
                    <label class="text-sm mb-1 sm:mb-2 font-semibold" for="email">Email</label>
                    <input
                        class="px-3 pl-2 text-sm sm:text-md py-2 w-full hover:bg-[#f5f5f5] bg-[#f8f9fa] border outline-none rounded-md border-[#E4E4E7] focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-colors"
                        type="email" name="email" placeholder="your.email@gmail.com" id="email">
                </div>
                <div class="flex w-full items-start flex-col">
                    <label class="text-sm mb-1 sm:mb-2 font-semibold" for="phone">Phone (Optional)</label>
                    <input
                        class="px-3 pl-2 text-sm sm:text-md w-full py-2 hover:bg-[#f5f5f5] bg-[#f8f9fa] border outline-none rounded-md border-[#E4E4E7] focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-colors"
                        type="text" name="phone" placeholder="(977) 9800000000" id="phone">
                </div>
                <div class="flex w-full items-start flex-col">
                    <label class="text-sm mb-1 sm:mb-2 font-semibold" for="message">Message</label>
                    <textarea rows="4"
                        class="px-3 pl-2 text-sm sm:text-md w-full py-2 hover:bg-[#f5f5f5] bg-[#f8f9fa] border outline-none rounded-md border-[#E4E4E7] focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-colors resize-none"
                        name="message" placeholder="Tell us how we can help you..." id="message"></textarea>
                </div>
                <button
                    class="bg-black text-white py-2.5 sm:py-3 rounded-md text-base sm:text-lg font-medium hover:bg-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all active:scale-95">Send
                    Message</button>
            </div>
        </div>
    </div>

</section>
<?php include 'footer.php'; ?>