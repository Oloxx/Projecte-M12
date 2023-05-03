<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";


/**
 *  Data received from the controller
 */
const props = defineProps({
    cicles: {
        type: Object,
        required: true,
    }
});

const form = useForm({
    name: "",
    cognoms: "",
    cicle_id: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Register" />

        <h1 class="mt-5 ms-5 mb-4">Registre d'usuari</h1>
        <form @submit.prevent="submit" class="ms-5 me-5" >
            <div class="form-outline mb-4">
                <InputLabel for="name" class="form-label" value="Nom" />

                <TextInput id="name" type="text" class="form-control" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="form-outline mb-4">
                <InputLabel for="cognoms" class="form-label" value="Cognoms" />

                <TextInput id="cognoms" type="text" class="form-control" v-model="form.cognoms" required
                    autocomplete="family-name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="form-outline mb-4">
                <InputLabel for="cicle_id" class="form-label" value="Cicle" />

                <select name="cicle_id" id="cicle_id" class="form-control" v-model="form.cicle_id" required>
                    <option v-for="cicle in cicles" :value="cicle.id">
                        {{ cicle.nom }}
                    </option>
                </select>

                <InputError class="mt-2" :message="form.errors.cicle_id" />

            </div>

            <div class="form-outline mb-4">
                <InputLabel for="email" class="form-label" value="Email" />

                <TextInput id="email" type="email" class="form-control" v-model="form.email" required
                    autocomplete="email" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="form-outline mb-4">
                <InputLabel for="password" class="form-label" value="Contrasenya" />

                <TextInput id="password" type="password" class="form-control" v-model="form.password" required
                    autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="form-outline mb-4">
                <InputLabel for="password_confirmation" class="form-label" value="Confirmeu la contrasenya" />

                <TextInput id="password_confirmation" type="password" class="form-control"
                    v-model="form.password_confirmation" required autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <PrimaryButton class="btn btnlogin btn-block mb-4" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Registra el nou usuari
                </PrimaryButton> <br>
            </div>
        </form><br><br><br>
    </AuthenticatedLayout>
</template>
