<template>
    <div class="min-h-screen bg-gray-50 font-sans">
        <NavBar :username="username" :cart_count="cart_count" :role="role" />
        <slot />
        <!-- <Footer /> -->
    </div>
</template>

<script>
import NavBar from './NavBar.vue';
//import Footer from './Footer.vue';

export default {
    components: {
        NavBar
    },
    computed: {
        username() {
            return this.$page.props.auth ? this.$page.props.auth.user.name : 'Guest';
        },
        cart_count(){
            return this.$page.props.auth ? this.$page.props.auth.cart_count : '0';
        },
        role(){
            return this.$page.props.auth ? this.$page.props.auth.role.name : 'user';
        }
    }
}
</script>
