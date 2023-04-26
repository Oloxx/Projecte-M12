<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    cognoms: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <body class="d-flex flex-column m-0">
            <main class="d-flex align-items-center justify-content-center">
                <div class="container rounded-4">
                    <h1 class="text-center m-4">Registre d'usuari</h1>
                    <form 
                        @submit.prevent="submit" 
                        class="d-flex flex-column justify-content-center m-auto"
                        style="max-width:650px"
                    >
                        <div class="form-outline mb-4">
                            <InputLabel
                                for="name"
                                class="form-label"
                                value="Nom"
                            />

                            <TextInput
                                id="name"
                                type="text"
                                class="form-control"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="form-outline mb-4">
                            <InputLabel
                                for="cognoms"
                                class="form-label"
                                value="Cognoms"
                            />

                            <TextInput
                                id="cognoms"
                                type="text"
                                class="form-control"
                                v-model="form.cognoms"
                                required
                                autocomplete="family-name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="form-outline mb-4">
                            <InputLabel
                                for="email"
                                class="form-label"
                                value="Email"
                            />

                            <TextInput
                                id="email"
                                type="email"
                                class="form-control"
                                v-model="form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>

                        <div class="form-outline mb-4">
                            <InputLabel
                                for="password"
                                class="form-label"
                                value="Contrasenya"
                            />

                            <TextInput
                                id="password"
                                type="password"
                                class="form-control"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>

                        <div class="form-outline mb-4">
                            <InputLabel
                                for="password_confirmation"
                                class="form-label"
                                value="Confirmeu la contrasenya"
                            />

                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="form-control"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <div class="text-center mt-2">
                            <PrimaryButton
                                class="btn btnlogin btn-block mb-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Registra't
                            </PrimaryButton> <br>
                            <Link :href="route('login')" class="link-primary">
                                Ja estàs registrat? Fes click aquí
                            </Link>
                        </div>
                    </form>
                </div>
            </main>
        </body>
    </GuestLayout>
</template>
