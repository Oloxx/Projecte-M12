<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    cognoms: user.cognoms,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2>Informació del perfil</h2>

            <p>
                Actualitzeu la informació del perfil i l'adreça de correu electrònic del vostre compte.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" >
            <div>
                <InputLabel for="name" value="Nom" />

                <TextInput
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    style="max-width: 400px;"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-2">
                <InputLabel for="cognoms" value="Cognoms" />

                <TextInput
                    id="cognoms"
                    type="text"
                    v-model="form.cognoms"
                    required
                    autocomplete="family-name"
                    style="max-width: 400px;"
                />

                <InputError class="mt-2" :message="form.errors.cognoms" />
            </div>

            <div class="mb-3 mt-2">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                    style="max-width: 400px;"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    La teva adreça de correu electrònic no està verificada.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                    >
                        Feu clic aquí per tornar a enviar el correu electrònic de verificació.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-success"
                >
                    S'ha enviat un nou enllaç de verificació a la vostra adreça de correu electrònic.
                </div>
            </div>

            <div >
                <PrimaryButton :disabled="form.processing">Desa</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="alert alert-info mt-3" style="max-width: 400px;">Desat.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
