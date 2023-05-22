<script setup>
import { useI18n } from 'vue-i18n';

defineProps({
    message: {
        type: String,
    },
});

</script>

<template>
    <div v-if="message">
        <p class="text-danger">
            {{ $t(message) }}
        </p>
    </div>
</template>
