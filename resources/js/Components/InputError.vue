<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-danger">
            {{ message }}
        </p>
    </div>
</template>
