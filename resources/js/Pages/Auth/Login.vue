<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: true,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <body class="d-flex flex-column m-0">
            <main class="d-flex align-items-center justify-content-center">
                <div class="container rounded-4">
                    <h1 class="text-center m-4">Inicia la sessió</h1>
                    <form
                        @submit.prevent="submit"
                        class="d-flex flex-column justify-content-center m-auto"
                    >
                        <!-- Email input -->
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
                                placeholder="exemple@iescarlesvallbona.cat"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <InputLabel
                                for="password"
                                class="form-label"
                                value="Password"
                            />

                            <TextInput
                                id="password"
                                type="password"
                                class="form-control"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check mb-4">
                            <Checkbox
                                class="form-check-input"
                                name="remember"
                                v-model:checked="form.remember"
                            />
                            <label class="form-check-label" for="rememberMe">
                                Recorda el nom d'usuari</label
                            >
                        </div>

                        <!-- Submit button -->

                        <PrimaryButton
                            class="btn btn-primary btn-block mb-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            >Inicia la sessió</PrimaryButton
                        >
                    </form>

                    <!-- Simple link -->
                    <div class="text-center mt-2">
                        Heu oblidat el nom d'usuari o la contrasenya?
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="link-primary"
                        >
                            Fes click aquí
                        </Link>
                    </div>
                </div>
            </main>
        </body>
        <footer class="text-center text-light col fixed-bottom bg-primary p-3 ">
                Copyright © 2023 IES Carles Vallbona. Tots els drets reservats.
        </footer>
    </GuestLayout>
</template>
