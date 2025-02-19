<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Checkout" />
    <div class="bg-gray-100 py-12 px-6 mt-16">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Billing Details -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Billing Details</h2>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-2">Full Name</label>
                            <input v-model="form.fullname" type="text" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Email Address</label>
                            <input v-model="form.email" type="email" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-600 mb-2">Address</label>
                        <input v-model="form.address" type="text" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label class="block text-gray-600 mb-2">City</label>
                            <input v-model="form.city" type="text" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">State</label>
                            <input v-model="form.state" type="text" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">ZIP Code</label>
                            <input v-model="form.zip" type="text" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <img src="../../assets/images/ecocash.png" alt="ecocash" height="20">

                        <label class="block text-gray-600 mb-2">Enter Ecocash Number</label>
                        <input v-model="form.ecocash" type="tel" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition">
                        Place Order
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Order Summary</h2>
                <div v-for="item in cart" :key="item.id" class="flex justify-between items-center border-b py-4">
                    <div class="flex items-center">
                        <img :src="`/storage/${item.product.images[0].file}`" class="w-16 h-16 object-cover rounded mr-4">
                        <span class="text-gray-800">{{ item.product.name }}</span>
                    </div>
                    <span class="text-gray-700">${{ (item.product.price * item.qty).toFixed(2) }}</span>
                </div>

                <div class="flex justify-between font-bold text-xl mt-6">
                    <span>Total:</span>
                    <span>${{ cartTotal }}</span>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Layout from "../Shared/Layout.vue";
import Footer from "../Shared/Footer.vue";
import { useSnackbar } from 'vue3-snackbar';

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
    setup() {
        const form = useForm({
            fullname: '',
            email: '',
            address: '',
            city: '',
            state: '',
            zip: '',
            ecocash: ''
        });

        const snackbar = useSnackbar();

        const resetForm = () => {
            form.reset();
        };

        const submit = () => {
            form.post('/payments', {
                onFinish: () => {
                    if (form.wasSuccessful) {
                        snackbar.add({
                            type: 'success',
                            text: 'Your order successfully'
                        });
                        resetForm();
                    }
                }
            });
        };

        watch(() => form.errors.error, (error) => {
            if (error) {
                snackbar.add({
                    type: 'error',
                    text: error
                });
            }
        });

        return {
            form,
            resetForm,
            submit
        };
    },
};
</script>
