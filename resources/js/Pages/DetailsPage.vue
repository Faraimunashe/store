<template>
    <div class="min-h-screen bg-gray-100 font-sans">
      <!-- Navigation -->
      <nav class="bg-white shadow-lg py-4 fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto flex justify-between items-center px-8">
          <h1 class="text-3xl font-extrabold text-blue-700">TechSight Solutions</h1>
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

      <!-- Product Details Section -->
      <section class="container mx-auto py-24 px-8 mt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
          <!-- Product Images -->
          <div>
            <div class="relative">
              <img :src="selectedImage" class="w-full rounded-lg shadow-md">
            </div>
            <div class="mt-4 flex space-x-4 overflow-x-auto">
              <img v-for="(image, index) in product.images" :key="index" :src="image"
                   class="w-24 h-24 object-cover rounded-lg shadow-md cursor-pointer border-2 border-transparent hover:border-blue-600"
                   @click="selectedImage = image">
            </div>
          </div>

          <!-- Product Details -->
          <div>
            <h2 class="text-4xl font-bold text-gray-800">{{ product.name }}</h2>
            <p class="mt-4 text-gray-600 text-lg">{{ product.description }}</p>
            <p class="mt-4 text-blue-600 font-bold text-2xl">${{ product.price }}</p>
            <button class="mt-6 bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition">
              Add to Cart
            </button>
          </div>
        </div>
      </section>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const product = ref({
    name: 'Wireless Mouse',
    price: 25.99,
    description: 'High precision wireless mouse with ergonomic design.',
    images: ['/images/mouse1.jpg', '/images/mouse2.jpg', '/images/mouse3.jpg']
  });

  const selectedImage = ref(product.value.images[0]);
  </script>
