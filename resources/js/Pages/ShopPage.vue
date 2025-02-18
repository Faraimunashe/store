<template>
    <Head title="Shop" />
    <div class="min-h-screen bg-gray-100 font-sans">
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
            <li v-for="category in categories" :key="category.id" class="mb-2">
              <button class="w-full text-left text-blue-600 hover:text-blue-800 font-semibold">{{ category.name }}</button>
            </li>
          </ul>
        </aside>

        <!-- Products & Filter -->
        <div class="w-full md:w-3/4">
          <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h3 class="text-3xl font-bold text-gray-800">Available Products</h3>
            <input
              type="text"
              v-model="search"
              placeholder="Search products..."
              class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 w-full md:w-1/3"
              @input="filterBySearch"
            >
            <select v-model="selected_category" class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 md:w-1/3">
              <option value="">All Categories</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <div v-for="product in products.data" :key="product.id" class="bg-white p-6 rounded-lg shadow-lg text-center transform hover:scale-105 transition">
                <img
                    :src="product.images.length ? `/storage/${product.images[0].file}` : '/default-image.jpg'"
                    :alt="product.name"
                    class="w-full h-40 object-cover rounded-md"
                >
              <Link :href="`/shop/${product.id}`">
                <h4 class="mt-4 text-lg font-semibold text-gray-800 hover:text-blue-600 transition">{{ product.name }}</h4>
              </Link>
              <p class="text-blue-600 font-bold text-xl mt-2">${{ product.price }}</p>
              <button
                class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-full shadow-md font-semibold hover:bg-blue-700 transition"
                @click="addToCart(product.id)"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Success Message -->
          <div v-if="cartMessage" class="mt-6 text-green-600 text-lg font-semibold text-center">
            {{ cartMessage }}
          </div>
        </div>
      </section>
      <Footer />
    </div>
</template>

<script>
import Layout from "../Shared/Layout.vue";
import Pagination from "../Shared/Pagination.vue";
import Footer from "../Shared/Footer.vue";
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';

export default {
    layout: Layout,
    props: {
        products: Object,
        categories: Array
    },
    components: {
        Pagination, Footer
    },
    setup() {
        const search = ref('');
        const cartMessage = ref('');

        watch(search, (value) => {
            router.get(
                '/shop',
                { search: value },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                }
            );
        });

        // Function to add product to cart using Inertia.js
        const addToCart = (productId) => {
            router.post('/cart', {
                product_id: productId,
                qty: 1
            }, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    cartMessage.value = "Added to cart successfully!";
                    setTimeout(() => cartMessage.value = "", 2000);
                },
                onError: () => {
                    cartMessage.value = "Failed to add to cart. Try again.";
                }
            });
        };

        return {
            search,
            addToCart,
            cartMessage
        };
    },
}
</script>
