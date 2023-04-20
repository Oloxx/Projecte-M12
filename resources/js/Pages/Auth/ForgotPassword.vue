<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />
        <body class="d-flex flex-column m-0">
            <main class="d-flex align-items-center justify-content-center">
                <div class="container rounded-4">
                    <h1 class="text-center m-4">
                        Regenera la teva contrasenya
                    </h1>
                    <div
                        v-if="status"
                        class="mb-4 font-medium text-sm text-green-600"
                    >
                        {{ status }}
                    </div>
                    <form @submit.prevent="submit" style="max-width:650px" class="mx-auto">
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
                                autofocus
                                autocomplete="username"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>

                        <div class="text-center mt-2">
                            <PrimaryButton
                                class="btn btnlogin btn-block mb-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Email Password Reset Link
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </main>
        </body>
    </GuestLayout>
</template>
