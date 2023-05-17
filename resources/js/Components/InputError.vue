<script setup>
import { useI18n } from 'vue-i18n';

defineProps({
    message: {
        type: String,
    },
});

const { t } = useI18n();

function translate(msg) {
    return msg ? t(msg) : null
}
</script>

<template>
    <div v-show="message">
        <p class="text-danger">
            {{ translate(message) }}
        </p>
    </div>
</template>
