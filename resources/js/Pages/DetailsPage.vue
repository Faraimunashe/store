<template>
    <Head title="Details" />
    <div class="min-h-screen bg-gray-100 font-sans">
        <!-- Product Details Section -->
        <section class="container mx-auto py-16 px-6 md:px-12 lg:px-24 mt-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="relative bg-white p-4 rounded-lg shadow-lg">
                        <img
                            :src="`/storage/${selectedImage.file}`"
                            :alt="product.name"
                            class="w-full h-96 object-cover rounded-lg"
                        >
                    </div>
                    <div class="mt-6 flex space-x-4 overflow-x-auto">
                        <img
                            v-for="(image, index) in product.images"
                            :key="index"
                            :src="`/storage/${image.file}`"
                            :alt="`Image ${index + 1}`"
                            class="w-24 h-24 object-cover rounded-lg shadow-md cursor-pointer border-2 border-transparent hover:border-blue-600 transition"
                            @click="selectedImage = image"
                        >
                    </div>
                </div>

                <!-- Product Details -->
                <div class="flex flex-col justify-center">
                    <h1 class="text-4xl font-extrabold text-gray-900">{{ product.name }}</h1>
                    <p class="mt-4 text-gray-700 text-lg leading-relaxed">{{ product.description }}</p>
                    <p class="mt-6 text-blue-600 font-bold text-3xl">${{ product.price }}</p>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex space-x-4">
                        <button
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-700 transition"
                        >
                            Add to Cart
                        </button>
                        <Link href="/shop"
                            class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-gray-300 transition"
                        >
                            Find More
                        </Link>
                    </div>
                </div>
            </div>
        </section>

      <Footer />
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Layout from "../Shared/Layout.vue";
import { ref } from "vue";
import Footer from "../Shared/Footer.vue";

export default {
    layout: Layout,
    props: {
        product: Object
    },
    components: {
        Footer
    },
    setup(props) {
        const selectedImage = ref(props.product.images.length ? props.product.images[0] : "/default-image.jpg");

        return {
            selectedImage
        };
    }
};
</script>
