<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    url: {
        required: true
    }
})
</script>

<template>
    <Link class="btn btn-danger mx-1" as="button" :href="url" method="delete">
    <slot></slot>
    </Link>
</template>