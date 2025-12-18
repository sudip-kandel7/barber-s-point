<?php include 'header.php';
include 'navbar.php'; ?>


<section class="bg-[#f8f9fa] min-h-screen">

    <div class="flex flex-col items-center justify-center text-center p-24">
        <p class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-black font-semibold leading-tight mb-5">About
            <span class="text-yellow-500">Barber's Point</span>
        </p>
        <p class="text-base sm:text-lg md:text-xl text-gray-500 mt-3 mx-auto max-w-2xl px-4">A BCA 4th Semester Project
            by Sudip Kandel & Kushal Pandit Connecting customers with the finest barber shops.</p>
    </div>

    <div class="bg-blue-50 p-7 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="hover:-translate-y-1">
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h3>
                        <div class="space-y-4 text-gray-600 break-all">
                            <p>
                                Barber's Point is a BCA 4th semester academic project created by Sudip Kandel and Kushal
                                Pandit.
                                We have seen problem of finding a great barber and
                                checking
                                wait times which should not be complicated.
                            </p>
                            <p>
                                This platform shows our understanding of full-stack development, database design,
                                and UI/UX knowledge. We built Barber's Point to solve a problem.
                            </p>
                            <p>
                                With support from our team and supervisor, we've created a functional platform that
                                connects
                                customers with barber shops, providing real-time queue information and reviews. This
                                project
                                represents our commitment to practical, problem-solving software development.
                            </p>
                        </div>
                    </div>
                    <img src="./public/images/web/ab.jpg" alt=""
                        class="h-[340px] w-96 hover:-translate-y-1 shadow-md hover:shadow-lg transition-all rounded-lg">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-11 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-3xl font-bold text-gray-900 mb-12 text-center">Meet Our Team</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 ">
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl group hover:-translate-y-1  transition-all">
                <div class="p-8 text-center">
                    <img src="./private/images/sudip.jpeg"
                        class="w-20 h-20 mx-auto mb-6 group-hover:-translate-y-2  transition-all rounded-full border-4 border-green-400"
                        alt="Sudip Kandel">
                    <h4 class="text-xl font-semibold text-gray-900 mb-1">Sudip Kandel</h4>
                    <p class="text-yellow-600 font-medium mb-3">Developer</p>
                    <p class="text-gray-600 text-sm mb-5">
                        BCA 4th Semester | Want to be Full-stack developer.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="https://github.com/sudip-kandel7" target="_blank"
                            class="text-gray-400 hover:text-gray-900 transition-colors">
                            <i class="fab fa-github text-2xl"></i>
                        </a>
                        <a href="https://facebook.com/sudip7.k" target="_blank"
                            class="text-gray-400 hover:text-blue-600 transition-colors">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="https://instagram.com/paade_7" target="_blank"
                            class="text-gray-400 hover:text-pink-500 transition-colors">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank"
                            class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1  transition-all">
                <div class="p-8 text-center">
                    <img src="./private/images/kushal.jpg"
                        class="w-20 h-20 mx-auto mb-6 group-hover:-translate-y-2 translate-all rounded-full border-4 border-green-400"
                        alt="Kushal Pandit">
                    <h4 class="text-xl font-semibold text-gray-900 mb-1">Kushal Pandit</h4>
                    <p class="text-yellow-600 font-medium mb-3">Developer</p>
                    <p class="text-gray-600 text-sm mb-5">
                        BCA 4th Semester | Cricket specialist.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="https://github.com/sumit-poudel" target="_blank"
                            class="text-gray-400 hover:text-gray-900 transition-colors">
                            <i class="fab fa-github text-2xl"></i>
                        </a>
                        <a href="https://facebook.com" target="_blank"
                            class="text-gray-400 hover:text-blue-600 transition-colors">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank"
                            class="text-gray-400 hover:text-pink-500 transition-colors">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank"
                            class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div
        class="bg-blue-50 hover:-translate-y-1 rounded-xl shadow-lg hover:shadow-xl flex flex-col justify-center p-16 mx-16 mt-16 mb-7">
        <h3 class="text-3xl font-bold text-gray-900 mb-6 text-center">Project Overview</h3>
        <div class="grid grid-cols-1  md:grid-cols-2 gap-8">
            <div>
                <h4 class="text-xl font-semibold text-yellow-600 mb-3">Course Details</h4>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> BCA 4th Semester
                    </li>
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> Full-Stack Web
                        Application</li>
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> Team Project</li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-semibold text-yellow-600 mb-3">Technology Stack</h4>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> HTML</li>
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> Tailwind CSS</li>
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> JavaScript</li>
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> PHP</li>
                    <li class="flex items-center"><span class="text-yellow-500 mr-3">•</span> MySQL Database
                    </li>
                </ul>
            </div>
        </div>
    </div>

</section>

<?php include 'footer.php'; ?>