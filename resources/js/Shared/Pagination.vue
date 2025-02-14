<template>
    <nav aria-label="Page navigation" class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-2">
            <li
                v-for="(link, index) in links"
                :key="index"
                :class="{
                    'bg-gray-200 text-gray-500 cursor-not-allowed': !link.url,
                    'bg-purple-600 text-white': link.active,
                    'hover:bg-purple-500 hover:text-white': link.url && !link.active,
                    'text-gray-700 border border-gray-300': !link.active && link.url,
                }"
                class="px-4 py-2 border rounded shadow-sm transition duration-200 ease-in-out"
            >

                <Component
                    :is="link.url ? 'Link' : 'span'"
                    :href="link.url"
                    class="block text-center"
                    v-html="link.label"
                />
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        links: {
            type: Array,
            required: true,
        },
    },
};
</script>
