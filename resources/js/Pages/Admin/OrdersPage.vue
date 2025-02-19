<template>
    <Head title="All Orders" />
    <div class="bg-gray-100 py-12 px-6 mt-16 mb-20">
        <div class="max-w-8xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
                <i class="fa fa-list text-blue-600 mr-2"></i> All Orders
            </h2>

            <!-- Search Field -->
            <div class="mb-6 flex justify-end">
                <div class="relative w-1/3">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search orders..."
                        class="w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <i class="fa fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

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
                                <i class="fa fa-box text-yellow-500 mr-2"></i> Customer
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
                            <td class="py-3 px-4">{{ order.status }}</td>
                            <td class="py-3 px-4">{{ order.user.name }}</td>
                            <td class="py-3 px-4">{{ new Date(order.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</td>
                            <td class="py-3 px-4">
                                <Link :href="`/adminorders/${order.id}`"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition flex items-center"
                                >
                                    <i class="fa fa-eye mr-2"></i> Show Order
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p v-if="orders.data.length === 0" class="text-center text-gray-600 mt-6">No orders found.</p>
            </div>
        </div>
        <Pagination v-if="orders.data.length !== 0" :links="orders.links" />
    </div>
</template>

<script>
import Layout from "../../Shared/Layout.vue";
import Pagination from "../../Shared/Pagination.vue";
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

export default {
    layout: Layout,
    props: {
        orders: Object
    },
    components: {
        Pagination
    },
    setup() {
        const search = ref('');

        watch(search, (value) => {
            router.get(
                '/adminorders',
                { search: value },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                }
            );
        });

        return {
            search
        };
    },
};
</script>
