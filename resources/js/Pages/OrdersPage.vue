<template>
    <Head title="My Orders" />
    <div class="bg-gray-100 py-12 px-6 mt-16">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
                <i class="fa fa-list text-blue-600 mr-2"></i> My Orders
            </h2>

            <div>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-3 px-4 text-left border">
                                <i class="fa fa-hashtag mr-2"></i> Reference
                            </th>
                            <th class="py-3 px-4 text-left border">
                                <i class="fa fa-money-bill-wave text-green-500 mr-2"></i> Amount
                            </th>
                            <th class="py-3 px-4 text-left border">
                                <i class="fa fa-box text-yellow-500 mr-2"></i> Status
                            </th>
                            <th class="py-3 px-4 text-left border">
                                <i class="fa fa-calendar-alt text-gray-500 mr-2"></i> Date
                            </th>
                            <th class="py-3 px-4 text-left border">
                                <i class="fa fa-cogs text-gray-500 mr-2"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.data" :key="order.id" class="border-b">
                            <td class="py-3 px-4">{{ order.reference }}</td>
                            <td class="py-3 px-4">${{ order.amount }}</td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-3 py-1 rounded-full text-white text-xs flex items-center"
                                >
                                    {{ order.status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ order.created_at }}</td>
                            <td class="py-3 px-4">
                                <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition flex items-center"
                                >
                                    <i class="fa fa-eye mr-2"></i> View Details
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p v-if="orders.data.length === 0" class="text-center text-gray-600 mt-6">No orders found.</p>
            </div>
            <Pagination v-if="orders.data.length !== 0" :links="orders.links" />
        </div>
    </div>
    <Footer />
</template>

<script>
import Layout from "../Shared/Layout.vue";
import Footer from "../Shared/Footer.vue";
import Pagination from "../Shared/Pagination.vue";

export default {
    layout: Layout,
    props: {
        orders: Object
    },
    components: {
        Footer, Pagination
    }
};
</script>

