<script setup>
import { usePage } from '@inertiajs/vue3'
import * as bootstrap from 'bootstrap/dist/js/bootstrap.js';
import { watchEffect, onMounted, ref } from 'vue';

const message = ref(null);

onMounted(() => {
    const toastElement = document.getElementById('app-toast')
    const toast = new bootstrap.Toast(toastElement)

    watchEffect(() => {
        if (usePage().props.toast) {
            message.value = usePage().props.toast;
            toast.show();
        }
    })
})
</script>

<template>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="app-toast" class="toast align-items-center bg-success text-light">
            <div class="d-flex">
                <div class="toast-body">
                    {{ message }}
                </div>
                <button type="button" class="btn-close btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>