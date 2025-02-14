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
            <a href="#" class="flex items-center text-blue-600 font-bold">
              <i class="fas fa-shopping-cart mr-2"></i> Cart ({{ cart.length }})
            </a>
          </div>
        </div>
      </nav>

      <!-- Cart Page -->
      <section class="container mx-auto py-24 px-8 mt-16">
        <h2 class="text-4xl font-bold text-gray-800 mb-6">Your Shopping Cart</h2>

        <div v-if="cart.length > 0" class="bg-white p-6 rounded-lg shadow-md">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-blue-600 text-white text-left">
                <th class="p-4">Product</th>
                <th class="p-4">Price</th>
                <th class="p-4">Quantity</th>
                <th class="p-4">Total</th>
                <th class="p-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in cart" :key="index" class="border-b">
                <td class="p-4 flex items-center">
                  <img :src="item.image" class="w-16 h-16 object-cover rounded mr-4">
                  <span class="text-gray-800">{{ item.name }}</span>
                </td>
                <td class="p-4 text-gray-800">${{ item.price }}</td>
                <td class="p-4">
                  <input type="number" v-model="item.quantity" min="1" class="border rounded-lg p-2 w-16 text-center">
                </td>
                <td class="p-4 text-gray-800 font-bold">${{ (item.price * item.quantity).toFixed(2) }}</td>
                <td class="p-4">
                  <button @click="removeFromCart(index)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="flex justify-between items-center mt-6">
            <h3 class="text-2xl font-bold text-gray-800">Total: ${{ cartTotal }}</h3>
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition">
              Checkout
            </button>
          </div>
        </div>

        <div v-else class="text-center text-gray-600 py-20">
          <p class="text-xl">Your cart is empty.</p>
          <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition">
            Continue Shopping
          </a>
        </div>
      </section>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';

  const cart = ref([
    { name: 'Wireless Mouse', price: 25.99, quantity: 1, image: '/images/mouse1.jpg' },
    { name: 'Mechanical Keyboard', price: 79.99, quantity: 1, image: '/images/keyboard1.jpg' },
    { name: 'USB-C Hub', price: 49.99, quantity: 1, image: '/images/hub1.jpg' }
  ]);

  const cartTotal = computed(() => {
    return cart.value.reduce((total, item) => total + item.price * item.quantity, 0).toFixed(2);
  });

  const removeFromCart = (index) => {
    cart.value.splice(index, 1);
  };
  </script>
