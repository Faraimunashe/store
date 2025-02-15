<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Edit Product" />

    <!-- Page Container -->
    <div class="flex flex-col items-center justify-center px-4 py-6 mt-16 bg-gray-100">
        <!-- Breadcrumb Navigation -->
        <nav class="w-full max-w-4xl text-gray-500 text-sm mb-4">
            <ol class="list-reset flex">
                <li>
                    <Link href="/" class="hover:text-blue-600">Home</Link>
                </li>
                <li><span class="mx-2">/</span></li>
                <li>
                    <Link href="/products" class="hover:text-blue-600">Products</Link>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-800 font-semibold">Edit</li>
            </ol>
        </nav>

        <!-- Form Container -->
        <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Product</h2>

            <form @submit.prevent="submit" class="grid gap-4">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700">Category <code class="text-red-500">*</code></label>
                    <select
                        v-model="form.category_id"
                        id="category"
                        :class="{'border-red-500': form.errors.category_id}"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="" disabled>Select a category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                    <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</div>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Product Name <code class="text-red-500">*</code></label>
                    <input
                        v-model="form.name"
                        type="text"
                        id="name"
                        :class="{'border-red-500': form.errors.name}"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter product name"
                    />
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700">Description <code class="text-red-500">*</code></label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        :class="{'border-red-500': form.errors.description}"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter product description"
                    ></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700">Price <code class="text-red-500">*</code></label>
                    <input
                        v-model="form.price"
                        type="number"
                        step="0.01"
                        id="price"
                        :class="{'border-red-500': form.errors.price}"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter product price"
                    />
                    <div v-if="form.errors.price" class="text-red-500 text-sm mt-1">{{ form.errors.price }}</div>
                </div>

                <!-- Images -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Product Images</label>
                    <input
                        type="file"
                        multiple
                        @change="handleImageUpload"
                        accept="image/jpg, image/jpeg, image/png"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                    />
                    <div v-if="form.errors.images" class="text-red-500 text-sm mt-1">{{ form.errors.images }}</div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <button
                        type="button"
                        @click="resetForm"
                        class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 transition duration-200"
                    >
                        Reset
                    </button>
                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition duration-200"
                    >
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useSnackbar } from 'vue3-snackbar';
import Layout from '../../Shared/Layout.vue';

export default {
    layout: Layout,
    props: {
        categories: Array,
        product: Object
    },
    setup(props) {
        const form = useForm({
            category_id: props.product.category_id,
            name: props.product.name,
            description: props.product.description,
            price: props.product.price,
            images: []
        });

        const snackbar = useSnackbar();

        const handleImageUpload = (event) => {
            form.images = Array.from(event.target.files);
        };

        const resetForm = () => {
            form.reset();
        };

        const submit = () => {
            form.put(`/products/${props.product.id}`, {
                onFinish: () => {
                    if (form.wasSuccessful) {
                        snackbar.add({
                            type: 'success',
                            text: 'Product updated successfully'
                        });
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
            handleImageUpload,
            resetForm,
            submit
        };
    }
};
</script>
