<template>
    <Head title="Cart" />
    <div class="min-h-screen bg-gray-100 font-sans">
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
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in cart" :key="item.id" class="border-b hover:bg-gray-50 transition">
                            <td class="p-4 flex items-center">
                                <Link :href="`/shop/${item.product.id}`" class="flex items-center">
                                    <img :src="`/storage/${item.product.images[0].file}`" class="w-16 h-16 object-cover rounded mr-4">
                                    <span class="text-gray-800">{{ item.product.name }}</span>
                                </Link>
                            </td>
                            <td class="p-4 text-gray-800">${{ item.product.price }}</td>
                            <td class="p-4">
                                <input type="number" v-model="item.qty" min="1" class="border rounded-lg p-2 w-16 text-center">
                            </td>
                            <td class="p-4 text-gray-800 font-bold">${{ (item.product.price * item.qty).toFixed(2) }}</td>
                            <td class="p-4 text-center">
                                <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-100 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between items-center mt-6">
                    <h3 class="text-2xl font-bold text-gray-800">Total: ${{ cartTotal }}</h3>
                    <Link href="/payments/create" class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition">
                        Checkout
                    </Link>
                </div>
            </div>

            <div v-else class="text-center text-gray-600 py-20">
                <p class="text-xl">Your cart is empty.</p>
                <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition">
                    Continue Shopping
                </a>
            </div>
        </section>
        <Footer />
    </div>
</template>


<script>
import Layout from '../Shared/Layout.vue';
import Footer from "../Shared/Footer.vue";
import { router } from '@inertiajs/vue3';

export default {
    layout: Layout,
    props: {
        cart: Array
    },
    components: {
        Footer
    },
    computed: {
        cartTotal() {
            return this.cart.reduce((total, item) => {
                return total + (item.product.price * item.qty);
            }, 0).toFixed(2);
        }
    },
    methods: {
        removeFromCart(itemId) {
            router.delete(`/cart/${itemId}`, {
                preserveScroll: true,
            });
        }
    }
}
</script>
