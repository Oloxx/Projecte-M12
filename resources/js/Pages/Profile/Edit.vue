<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    cicles: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="$t(`Perfil`)" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="mx-3">
                <div class="p-4 ">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" :cicles="cicles" />
                </div>
                <hr>

                <div class="p-4 ">
                    <UpdatePasswordForm />
                </div>
                <hr>

                <div class="p-4 mb-5">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
