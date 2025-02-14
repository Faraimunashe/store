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

      <!-- Hero Section -->
      <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-24 text-center mt-16">
        <div class="container mx-auto px-8">
          <h2 class="text-5xl font-bold">Discover the Best Tech Deals</h2>
          <p class="mt-6 text-xl">Find the latest ICT gadgets & consumables at unbeatable prices</p>
        </div>
      </header>

      <!-- Filter & Categories -->
      <section class="container mx-auto py-10 px-8 flex flex-col md:flex-row gap-8">
        <!-- Categories List -->
        <aside class="w-full md:w-1/4 bg-white p-6 rounded-lg shadow-lg">
          <h3 class="text-2xl font-bold text-gray-800 mb-4">Categories</h3>
          <ul>
            <li v-for="category in categories" :key="category" class="mb-2">
              <button @click="filterByCategory(category)" class="w-full text-left text-blue-600 hover:text-blue-800 font-semibold">{{ category }}</button>
            </li>
          </ul>
        </aside>

        <!-- Products & Filter -->
        <div class="w-full md:w-3/4">
          <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h3 class="text-3xl font-bold text-gray-800">Available Products</h3>
            <input type="text" v-model="searchQuery" placeholder="Search products..." class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 w-full md:w-1/3" @input="filterBySearch">
            <select v-model="selectedCategory" @change="filterByCategory(selectedCategory)" class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
              <option value="">All Categories</option>
              <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
            </select>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <div v-for="product in filteredProducts" :key="product.id" class="bg-white p-6 rounded-lg shadow-lg text-center transform hover:scale-105 transition">
              <img :src="product.image" :alt="product.name" class="w-full h-40 object-cover rounded-md">
              <h4 class="mt-4 text-lg font-semibold text-gray-800">{{ product.name }}</h4>
              <p class="text-blue-600 font-bold text-xl mt-2">${{ product.price }}</p>
              <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-full shadow-md font-semibold hover:bg-blue-700 transition">
                Add to Cart
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';

  const products = ref([
    { id: 1, name: 'Wireless Mouse', price: 25.99, image: '/images/mouse.jpg', category: 'Accessories' },
    { id: 2, name: 'Mechanical Keyboard', price: 79.99, image: '/images/keyboard.jpg', category: 'Accessories' },
    { id: 3, name: 'USB-C Hub', price: 49.99, image: '/images/hub.jpg', category: 'Accessories' },
    { id: 4, name: 'Noise Cancelling Headphones', price: 99.99, image: '/images/headphones.jpg', category: 'Audio' },
    { id: 5, name: 'Webcam 1080p', price: 45.99, image: '/images/webcam.jpg', category: 'Cameras' },
    { id: 6, name: 'Portable SSD 1TB', price: 129.99, image: '/images/ssd.jpg', category: 'Storage' },
    { id: 7, name: 'Wireless Charger', price: 29.99, image: '/images/charger.jpg', category: 'Accessories' },
    { id: 8, name: 'Gaming Monitor', price: 199.99, image: '/images/monitor.jpg', category: 'Monitors' }
  ]);

  const categories = computed(() => {
    return [...new Set(products.value.map(product => product.category))];
  });

  const selectedCategory = ref('');
  const searchQuery = ref('');

  const filteredProducts = computed(() => {
    let filtered = products.value;
    if (selectedCategory.value) {
      filtered = filtered.filter(product => product.category === selectedCategory.value);
    }
    if (searchQuery.value) {
      filtered = filtered.filter(product => product.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
    }
    return filtered;
  });

  const filterByCategory = (category) => {
    selectedCategory.value = category;
  };

  const filterBySearch = () => {
    searchQuery.value = searchQuery.value.trim();
  };
  </script>
