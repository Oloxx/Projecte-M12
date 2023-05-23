<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);

const form = useForm({
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.patch(route('profile.updateDefaultPassword'), {
        preserveScroll: true,
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <Head :title="$t(`Actualitza la contrasenya`)" />
    <GuestLayout>
        <body class="d-flex flex-column m-0">
            <main class="d-flex align-items-center justify-content-center">
                <div class="container rounded-4">
                    <h1 class="text-center m-4">{{ $t("Actualitza la contrasenya") }}</h1>

                    <p class="mt-1">
                        {{ $t("Assegureu-vos que el vostre compte utilitzi una contrasenya llarga i aleatòria per mantenir la seguretat.") }}
                    </p>

                    <form @submit.prevent="updatePassword" class="mt-1">

                        <div>
                            <InputLabel for="password" :value="$t(`Nova Contrasenya`)" />

                            <TextInput
                                id="password"
                                ref="passwordInput"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                type="password"
                                autocomplete="new-password"
                            />

                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password_confirmation" :value="$t(`Confirma la Contrasenya`)" />

                            <TextInput
                                id="password_confirmation"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                type="password"
                                autocomplete="new-password"
                            />

                            <InputError :message="form.errors.password_confirmation" class="mt-2" />
                        </div>

                        <div class="d-flex items-center justify-end mt-4">
                            <PrimaryButton class="btn btnlogin btn-block mb-4" :disabled="form.processing">{{ $t("Actualitza la contrasenya") }}</PrimaryButton>
                        </div>
                    </form>
                </div>
            </main>
        </body>
    </GuestLayout>
</template>
