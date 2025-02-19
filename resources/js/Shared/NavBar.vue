<template>
    <nav class="bg-white shadow-lg py-4 fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto flex justify-between items-center px-8">
            <h1 class="text-3xl font-extrabold text-blue-700">TECHSIGHT SOLUTIONS</h1>
            <div class="space-x-8 font-medium flex items-center">
                <Link v-if="role !== 'admin'" href="/" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i> Home
                </Link>
                <Link v-if="role !== 'admin'" href="/shop" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-store mr-2"></i> Shop
                </Link>
                <Link v-if="role !== 'admin'" href="/orders" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-envelope mr-2"></i> Orders
                </Link>
                <Link v-if="username !== 'Guest' && role !== 'admin'" href="/cart" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-shopping-cart mr-2"></i> Cart ({{ cart_count }})
                </Link>
                <Link v-if="role === 'admin'" href="/categories" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i> Categories
                </Link>
                <Link v-if="role === 'admin'" href="/products" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i> Products
                </Link>
                <Link v-if="role === 'admin'" href="/orders" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i> Orders
                </Link>

                <div class="relative" @click="toggleDropdown">
                    <button class="flex items-center text-gray-700 hover:text-blue-600 transition focus:outline-none">
                        <i class="fas fa-user-circle mr-2"></i> {{ username }}
                    </button>
                    <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2">
                        <Link v-if="username !== 'Guest'" href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</Link>
                        <Link v-if="username !== 'Guest'" href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</Link>
                        <Link v-if="username !== 'Guest'" method="POST" href="/logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</Link>
                        <Link v-if="username === 'Guest'" href="/login" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: {
        username: String,
        cart_count: String,
        role: String
    },
    data() {
        return {
            dropdownOpen: false
        };
    },
    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        }
    }
};
</script>
