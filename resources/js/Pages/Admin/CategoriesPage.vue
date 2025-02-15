<template>
    <Head title="Categories" />
    <div class="container mx-auto p-8 mt-16">
        <!-- Breadcrumb -->
        <nav class="text-gray-600 mb-4" aria-label="breadcrumb">
            <ol class="list-reset flex text-gray-600">
                <li>
                    <a href="#" class="text-blue-600 hover:underline">Home</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Categories</li>
            </ol>
        </nav>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-700">Categories</h1>
            <Link href="/categories/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Add Category
            </Link>
        </div>

        <!-- Search Input -->
        <div class="relative mb-6">
            <input
                type="text"
                v-model="search"
                placeholder="Search categories..."
                class="w-full p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 pl-10"
            />
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>

        <div class="overflow-hidden bg-white shadow-md rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-blue-800">
                        <th class="px-6 py-4 text-left font-semibold">ID</th>
                        <th class="px-6 py-4 text-left font-semibold">Name</th>
                        <th class="px-6 py-4 text-left font-semibold">Created At</th>
                        <th class="px-6 py-4 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories.data" :key="category.id" class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">{{ category.id }}</td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ category.name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ category.created_at }}</td>
                        <td class="px-6 py-4 flex justify-center space-x-4">
                            <Link :href="'/categories/'+category.id+'/edit'" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-100 transition">
                                <i class="fas fa-edit"></i>
                            </Link>
                            <button @click="confirmDelete(category.id)" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-100 transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination :links="categories.links" class="mt-6" />

        <!-- Delete Confirmation Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Confirm Deletion</h2>
                <p class="text-gray-600">Are you sure you want to delete this category?</p>
                <div class="flex justify-end mt-4 space-x-4">
                    <button @click="showModal = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
                    <button @click="deleteCategory" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '../../Shared/Layout.vue';
import Pagination from '../../Shared/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

export default {
    layout: Layout,
    props: {
        categories: Object
    },
    components: {
        Pagination
    },
    setup() {
        const search = ref('');
        const showModal = ref(false);
        const categoryIdToDelete = ref(null);

        watch(search, (value) => {
            router.get(
                '/categories',
                { search: value },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                }
            );
        });

        const confirmDelete = (id) => {
            categoryIdToDelete.value = id;
            showModal.value = true;
        };

        const deleteCategory = () => {
            router.delete(`/categories/${categoryIdToDelete.value}`, {
                onFinish: () => {
                    showModal.value = false;
                    categoryIdToDelete.value = null;
                }
            });
        };

        return {
            search,
            showModal,
            categoryIdToDelete,
            confirmDelete,
            deleteCategory
        };
    },
};
</script>
