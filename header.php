<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>Barber's Point</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="./public/style.css" rel="stylesheet">
</head>
<body class="overflow-x-hidden">

<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barber's Point</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for better appearance */
        .hero-section {
            background: 
                linear-gradient(
                    rgba(0, 0, 0, 0.4),
                    rgba(0, 0, 0, 0.6)
                ),
                url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .search-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .stats-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-input::-webkit-search-cancel-button {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background-color: #f59e0b;
            border-radius: 50%;
            cursor: pointer;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3e%3cpath fill='white' d='M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z'/%3e%3c/svg%3e");
            background-size: 12px 12px;
            background-repeat: no-repeat;
            background-position: center;
        }

        .search-input::-webkit-search-cancel-button:hover {
            background-color: #d97706;
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                    <span class="text-black font-bold text-sm">B</span>
                </div>
                <span class="text-xl font-bold text-gray-900">Barber's Point</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-gray-700 hover:text-gray-900">Home</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">About Us</a>
                <a href="#" class="text-gray-700 hover:text-gray-900">Contact</a>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="text-gray-700 hover:text-gray-900">Login</button>
                <button class="bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-gray-800">Register</button>
            </div>
        </div>
    </nav>

    <section class="hero-section min-h-[85vh] flex items-center">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="mb-8">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-2">
                    Find Your Perfect
                </h1>
                <h1 class="text-5xl md:text-7xl font-bold text-yellow-400 mb-6">
                    Barber Shop
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 font-light max-w-3xl mx-auto leading-relaxed">
                    Discover professional barber shops near you. Book appointments, check wait times, and read reviews from real customers.
                </p>
            </div>

            <div class="search-container max-w-2xl mx-auto rounded-full p-2 mb-12">
                <div class="flex items-center gap-3">
                    <div class="pl-4">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        placeholder="Search for barber shops, locations..." 
                        class="search-input flex-1 py-4 px-2 bg-transparent border-none outline-none text-gray-800 text-lg placeholder-gray-500"
                    >
                    <div class="flex items-center gap-2 pr-2">
                        <button class="p-3 hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                            </svg>
                        </button>
                        <button class="bg-gray-900 text-white px-6 py-3 rounded-full hover:bg-gray-800 transition-colors font-medium">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="stats-card rounded-xl p-8 text-center">
                    <div class="mb-4">
                        <span class="text-5xl font-bold text-yellow-400">50</span>
                        <span class="text-3xl font-bold text-yellow-400">+</span>
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="text-gray-300 font-medium">Barber Shops</span>
                    </div>
                </div>

                <div class="stats-card rounded-xl p-8 text-center">
                    <div class="mb-4">
                        <span class="text-5xl font-bold text-yellow-400">1000</span>
                        <span class="text-3xl font-bold text-yellow-400">+</span>
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-gray-300 font-medium">Happy Customers</span>
                    </div>
                </div>

                <div class="stats-card rounded-xl p-8 text-center">
                    <div class="mb-4 flex items-center justify-center gap-1">
                        <span class="text-5xl font-bold text-yellow-400">4.8</span>
                        <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="text-gray-300 font-medium">Average Rating</span>
                    </div>
                </div>
            </div>

            <div class="mt-12">
                <div class="flex items-center justify-center gap-2 text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Popular in your area: Downtown, City Center, Mall District</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Popular Barber Shops
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover the best barber shops in your area with real-time queue information and customer reviews.
            </p>
        </div>
    </section>
</body>
</html> -->