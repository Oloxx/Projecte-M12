<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

/**
 *  Data received from the controller
 */
const props = defineProps({
    cicles: {
        type: Object,
        required: true,
    }
});

const password = "vallbona2223";

const form = useForm({
    name: "",
    cognoms: "",
    cicle_id: "",
    email: "",
    password: password,
    password_confirmation: password,
    terms: false
});

const submit = () => {
    const email = form.email;
    const emailRegex = /^[a-z]+(\.[a-z]+)?@iescarlesvallbona\.cat$/i;
    if (emailRegex.test(email)) {
        const [namePart, domain] = email.split('@');
        const [firstName, lastName] = namePart.split('.');
        form.name = firstName.charAt(0).toUpperCase() + firstName.slice(1);
        form.cognoms = lastName.charAt(0).toUpperCase() + lastName.slice(1);
        form.post(route("register"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    } else {
        form.errors.email = t("Error, email no vàlid")
    }
};
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Register" />

        <h1 class="mt-5 ms-5 mb-4">Registre d'usuari</h1>
        <form @submit.prevent="submit" class="ms-5 me-5" >
            <div class="form-outline mb-4">
                <InputLabel for="cicle_id" class="form-label" value="Cicle" />

                <select name="cicle_id" id="cicle_id" class="form-select" v-model="form.cicle_id" required>
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

            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <PrimaryButton class="btn btnlogin btn-block mb-4" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Registra el nou usuari
                </PrimaryButton> <br>
            </div>
        </form><br><br><br>
    </AuthenticatedLayout>
</template>
