<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Edit Category" />
    <div class="container mx-auto px-4 py-6 mt-16">
        <div class="mb-6">
            <nav class="text-gray-500 text-sm mt-2">
                <ol class="list-reset flex">
                    <li>
                        <Link href="/" class="hover:text-blue-600">Home</Link>
                    </li>
                    <li><span class="mx-2">/</span></li>
                    <li>
                        <Link href="/categories" class="hover:text-blue-600">Categories</Link>
                    </li>
                    <li><span class="mx-2">/</span></li>
                    <li>Edit</li>
                </ol>
            </nav>
        </div>

        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Category Name <code class="text-red-500">*</code></label>
                    <input
                        v-model="form.name"
                        :disabled="form.processing"
                        type="text"
                        id="name"
                        :class="{'border-red-500': form.errors.name}"
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter category name"
                    />
                    <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition duration-200"
                    >
                        <span v-if="form.processing">Updating Category ...</span>
                        <span v-else>Update Category</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '../../Shared/Layout.vue';
export default {
    layout: Layout
}
</script>

<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useSnackbar } from "vue3-snackbar";
import { onMounted } from 'vue';

const props = defineProps({
    category: Object
});

const form = useForm({
    name: props.category.name,
});

const snackbar = useSnackbar();

watch(() => form.wasSuccessful, (wasSuccessful) => {
    if (wasSuccessful) {
        snackbar.add({
            type: 'success',
            text: 'Category updated successfully'
        });
    }
});

watch(() => form.errors.error, (error) => {
    if (error) {
        snackbar.add({
            type: 'error',
            text: error
        });
    }
});

const submit = () => {
    form.put(`/categories/${props.category.id}`, {
        onFinish: () => form.reset(),
    });
};
</script>
