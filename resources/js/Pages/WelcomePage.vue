<template>
    <div class="min-h-screen bg-gray-50 font-sans">
        <nav class="bg-white shadow-lg py-4 fixed top-0 left-0 w-full z-50">
            <div class="container mx-auto flex justify-between items-center px-8">
                <h1 class="text-3xl font-extrabold text-blue-700">TECHSIGHT SOLUTIONS</h1>
                <div class="space-x-8 font-medium flex items-center">
                    <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                    <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-store mr-2"></i> Shop
                    </a>
                    <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-envelope mr-2"></i> Contact
                    </a>
                    <a href="#" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-shopping-cart mr-2"></i> Cart (0)
                    </a>
                </div>
            </div>
        </nav>

      <!-- Hero Section -->
      <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-24 text-center mt-16">
        <div class="container mx-auto px-8">
          <h2 class="text-5xl font-bold">Your One-Stop Shop for ICT Gadgets & Consumables</h2>
          <p class="mt-6 text-xl">Explore our latest collection of top-notch tech products</p>
          <a href="#" class="mt-8 inline-block bg-white text-blue-600 px-8 py-4 rounded-full shadow-lg font-semibold text-lg hover:bg-gray-200 transition">Shop Now</a>
        </div>
      </header>

      <!-- Featured Categories -->
      <section class="container mx-auto py-16 px-8">
        <h3 class="text-3xl font-extrabold text-gray-800 text-center mb-12">Featured Categories</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-xl shadow-lg text-center transform hover:scale-105 transition">
            <img src="../../assets/images/laptop_586.png" alt="Laptops" class="w-full rounded-lg">
            <h4 class="mt-6 text-2xl font-semibold text-gray-800">Laptops</h4>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-lg text-center transform hover:scale-105 transition">
            <img src="../../assets/images/cables.png" alt="Accessories" class="w-full rounded-lg">
            <h4 class="mt-6 text-2xl font-semibold text-gray-800">Accessories</h4>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-lg text-center transform hover:scale-105 transition">
            <img src="../../assets/images/printer.png" alt="Printers & Ink" class="w-full rounded-lg">
            <h4 class="mt-6 text-2xl font-semibold text-gray-800">Printers & Ink</h4>
          </div>
        </div>
      </section>

      <!-- Call to Action -->
      <section class="bg-gray-900 text-white py-16 text-center">
        <h3 class="text-4xl font-bold">Stay Updated with Our Latest Deals!</h3>
        <p class="mt-4 text-lg">Subscribe to our newsletter for exclusive discounts.</p>
        <div class="mt-6 flex justify-center">
          <input type="email" placeholder="Enter your email" class="p-4 rounded-l-lg text-gray-900 w-1/3 focus:outline-none">
          <button class="bg-blue-600 px-6 py-4 rounded-r-lg shadow-lg font-semibold hover:bg-blue-700 transition">Subscribe</button>
        </div>
      </section>
    </div>
  </template>

