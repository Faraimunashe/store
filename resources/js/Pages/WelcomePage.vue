<template>
    <Head title="Welcome"/>
    <div class="min-h-screen bg-gray-50 font-sans">
      <!-- Hero Section -->
      <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-24 text-center mt-16">
        <div class="container mx-auto px-8">
            <h2 class="text-5xl font-bold">Your One-Stop Shop for ICT Gadgets & Consumables</h2>
            <p class="mt-6 text-xl">Explore our latest collection of top-notch tech products</p>
            <a href="/shop" class="mt-8 inline-block bg-white text-blue-600 px-8 py-4 rounded-full shadow-lg font-semibold text-lg hover:bg-gray-200 transition">
                Shop Now
            </a>
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

    </div>
</template>

<script>
import Layout from '../Shared/Layout.vue';
import Footer from '../Shared/Footer.vue';

export default {
    layout: Layout,
    components: {
        Footer
    }
}
</script>

