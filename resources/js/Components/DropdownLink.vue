<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="link-dark link-underline link-underline-opacity-0"
    >
        <slot />
    </Link>
</template>
