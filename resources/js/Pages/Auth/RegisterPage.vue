<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700">
      <!-- Register Card -->
      <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8 animate-fadeIn transform transition duration-500 ease-in-out">
        <div class="text-center mb-6">
          <h1 class="text-2xl font-bold text-blue-700 mb-1">TechSight Solutions</h1>
        </div>

        <div class="text-center mb-6">
          <h3 class="text-3xl font-semibold text-gray-800 animate-slideDown">Create an Account</h3>
          <p class="text-gray-600">Join us today and start shopping</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="mt-6 animate-fadeIn delay-200">
          <!-- Name Field -->
          <div class="mb-4 relative">
            <label for="name" class="text-gray-600 font-medium">Full Name</label>
            <input
              type="text"
              v-model="form.name"
              id="name"
              placeholder="Enter your full name"
              :class="{'border-red-500': form.errors.name}"
              class="w-full px-12 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <span class="absolute top-10 left-3 text-gray-400">
              <i class="fas fa-user"></i>
            </span>
            <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
          </div>

          <!-- Email Field -->
          <div class="mb-4 relative">
            <label for="email" class="text-gray-600 font-medium">Email</label>
            <input
              type="email"
              v-model="form.email"
              id="email"
              placeholder="Enter your email"
              :class="{'border-red-500': form.errors.email}"
              class="w-full px-12 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <span class="absolute top-10 left-3 text-gray-400">
              <i class="fas fa-envelope"></i>
            </span>
            <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
          </div>

          <!-- Password Field -->
          <div class="mb-4 relative">
            <label for="password" class="text-gray-600 font-medium">Password</label>
            <input
              type="password"
              v-model="form.password"
              id="password"
              placeholder="Enter your password"
              :class="{'border-red-500': form.errors.password}"
              class="w-full px-12 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <span class="absolute top-10 left-3 text-gray-400">
              <i class="fas fa-lock"></i>
            </span>
            <div v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</div>
          </div>

          <!-- Password Confirmation Field -->
          <div class="mb-6 relative">
            <label for="password_confirmation" class="text-gray-600 font-medium">Confirm Password</label>
            <input
              type="password"
              v-model="form.password_confirmation"
              id="password_confirmation"
              placeholder="Confirm your password"
              :class="{'border-red-500': form.errors.password_confirmation}"
              class="w-full px-12 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <span class="absolute top-10 left-3 text-gray-400">
              <i class="fas fa-lock"></i>
            </span>
            <div v-if="form.errors.password_confirmation" class="text-red-500">{{ form.errors.password_confirmation }}</div>
          </div>

          <button
            :disabled="loading"
            type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg transition duration-300 transform hover:bg-blue-700 hover:shadow-lg hover:-translate-y-1"
          >
            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span v-if="!loading">Register</span>
            <span v-if="loading">Registering...</span>
          </button>
        </form>

        <div class="text-center mt-4">
          Already have an account? <a href="/login" class="text-sm text-blue-600 hover:text-blue-800">Log In</a>
        </div>
      </div>

      <!-- Footer -->
      <footer class="mt-6 text-center text-white text-sm">
        &copy; 2024 TechSight Solutions | Developed by
        <a href="#" class="text-sm text-gray-300 hover:text-gray-500">Faraimunashe</a>
      </footer>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
  });

  const loading = ref(false);

  const submit = () => {
    loading.value = true;
    form.post('/register', {
      onFinish: () => (loading.value = false),
    });
  };
  </script>

  <style scoped>
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  .animate-fadeIn {
    animation: fadeIn 1s ease-in-out;
  }

  .animate-slideDown {
    animation: slideDown 1s ease-in-out;
  }
  </style>
