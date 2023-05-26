<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <body>
        <div class="container-fluid colorvb">
            <Link href="/">
                <ApplicationLogo />
            </Link>
        </div>
        <div class="py-4">
            <slot />
        </div>
    </body>
</template>
