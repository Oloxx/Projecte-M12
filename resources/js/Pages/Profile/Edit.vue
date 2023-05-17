<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import ImportCSV from './Partials/ImportCSV.vue'
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
const user = page.props.auth.user;

</script>

<template>
    <Head :title="$t(`Perfil`)" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="mx-3">
                <div class="p-4">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>
                <hr>

                <div class="p-4">
                    <UpdatePasswordForm />
                </div>
                <hr>

                <template v-if="user.rol_id === 1">
                    <div class="p-4">
                        <ImportCSV />
                    </div>
                    <hr>
                </template>

                <div class="p-4 mb-5">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
