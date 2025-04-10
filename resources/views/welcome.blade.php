@extends('layouts.footer')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .hero-bg {
         
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <!-- <nav class="bg-white shadow-lg py-4 px-6 flex justify-between items-center">
        <div class="text-2xl font-bold text-gray-800">HassanRJ</div>
        <div class="flex space-x-6">
            <a href="#" class="text-gray-600 hover:text-gray-900">Home</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Books</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">About</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Admin</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">→</a>
        </div>
    </nav> -->

    <main>
    <section class="flex flex-col md:flex-row items-center justify-between bg-white text-black min-h-screen px-8 md:px-20 py-20">
    <!-- Left Text Content -->
    <div class="md:w-1/2 space-y-6 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
            Unleash the <br />
            Power <br />
            Of Knowledge
        </h1>
        <p class="text-lg md:text-xl text-gray-700">
            Explore a world of books that will take you on a journey
            of discovery and imagination.
        </p>
        <div class="flex justify-center md:justify-start space-x-4">
            <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                Log In
            </a>
            <a href="/register" class="bg-gray-200 text-blue-600 hover:bg-gray-300 px-6 py-3 rounded-lg font-semibold transition">
                Sign Up
            </a>
        </div>
    </div>

    <!-- Right Image -->
    <div class="md:w-1/2 mt-10 md:mt-0">
        <img src="/storage/images/home.png" alt="Books Image" class="w-full max-w-md mx-auto rounded-lg">
    </div>
</section>

</main>ّ


   
</body>
</html>