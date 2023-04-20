<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    url: {
        required: true
    }
})
</script>

<template>
    <Link class="btn btn-primary mx-1" as="button" :href="url">
        <i class="bi bi-pencil-square"></i>
    </Link>
</template>