<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2>Actualitza la contrasenya</h2>

            <p class="mt-1">
                Assegureu-vos que el vostre compte utilitzi una contrasenya llarga i aleatòria per mantenir la seguretat.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-1">
            <div>
                <InputLabel for="current_password" value="Contrasenya Actual" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    autocomplete="current-password"
                    style="max-width: 400px;"
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password" value="Nova Contrasenya" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    autocomplete="new-password"
                    style="max-width: 400px;"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="mb-3">
                <InputLabel for="password_confirmation" value="Confirma la Contrasenya" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    style="max-width: 400px;"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div>
                <PrimaryButton :disabled="form.processing">Desa</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="alert alert-info mt-3" style="max-width: 400px;">Desat.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
