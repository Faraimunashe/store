<template>
    <Head title="Track Order" />
    <div class="bg-gray-50 py-12 px-6 mt-16 mb-20">
        <div class="max-w-8xl mx-auto bg-white p-8 rounded-lg shadow-lg border border-gray-200">
            <!-- Title -->
            <div class="flex items-center mb-6 border-b pb-4">
                <i class="fa fa-shipping-fast text-blue-600 text-3xl mr-3"></i>
                <h2 class="text-3xl font-bold text-gray-800">Track Your Order</h2>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order Details -->
                <div class="p-5 bg-gray-100 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3">Order Details</h3>
                    <p><strong>Order Ref:</strong> #{{ order.reference }}</p>
                    <p><strong>Status:</strong> <span class="text-green-600">{{ order.status }}</span></p>
                    <p><strong>Placed on:</strong> {{ formatDate(order.created_at) }}</p>
                </div>
                <!-- Shipping Address -->
                <div class="p-5 bg-gray-100 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3">Shipping Address</h3>
                    <p>{{ order.address.fullname }}</p>
                    <p>{{ order.address.address }}</p>
                    <p>{{ order.address.city }}, {{ order.address.state }} {{ order.address.zip }}</p>
                    <p><strong>Phone:</strong> {{ order.address.ecocash }}</p>
                    <p><strong>Email:</strong> {{ order.address.email }}</p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Items -->
                <div class="p-5 bg-gray-100 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3">Items</h3>
                    <ul>
                        <li v-for="item in order.order_items" :key="item.id" class="flex justify-between border-b py-3">
                            <span class="font-medium">{{ item.product.name }}</span>
                            <span>x{{ item.qty }}</span>
                            <span class="text-green-700">${{ item.total_price }}</span>
                        </li>
                    </ul>
                    <p class="mt-4 font-semibold text-xl text-gray-800">Total: <span class="text-blue-600">${{ order.amount }}</span></p>
                </div>

                <div class="p-5 bg-gray-100 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3">Payment Information</h3>
                    <p><strong>Reference:</strong> {{ order.payment.reference }}</p>
                    <p><strong>Method:</strong> {{ order.payment.method }}</p>
                    <p><strong>Status:</strong> <span class="text-green-600">{{ order.payment.status }}</span></p>
                </div>
            </div>

            <!-- Tracking Info -->
            <div class="mt-6 p-5 bg-gray-100 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold mb-3">Tracking Information</h3>
                <div v-if="order.tracking">
                    <p><strong>Carrier:</strong> {{ order.tracking.carrier }}</p>
                    <p><strong>Contact:</strong> {{ order.tracking.contact }}</p>
                    <p><strong>Estimated Delivery:</strong> {{ formatDate(order.tracking.expected_delivery_date) }}</p>
                    <p><strong>Time:</strong> {{ order.tracking.expected_delivery_time }}</p>
                    <p><strong>Remarks:</strong> {{ order.tracking.remarks }}</p>
                </div>
                <div v-else class="text-center bg-yellow-500 text-white py-2 font-bold rounded-lg">Your order is still in store.</div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "../Shared/Layout.vue";
import { ref } from 'vue';

export default {
    layout: Layout,
    props: {
        order: Object
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    }
};
</script>
