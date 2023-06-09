<script setup>
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';

/**
 *  Data received from the controller
 */
const props = defineProps({
    contacte: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: false,
    },
});



/**
 * Validations
 */
const schema = Yup.object().shape({
    nom: Yup.string().required("El nom de l'usuari és obligatori"),
    cognoms: Yup.string().required("Els cognoms de l'usuari són obligatoris"),
    movil: Yup.string().matches(
        /^[0-9]{9}/,
        "El número de telèfon ha d'estar compost per nomès 9 números."
    ),
    email: Yup.string().email("El E-mail introduït és invàlid"),
    empresa_id: Yup.string().required("S'ha d'assignar una empresa a cada contacte."),
}); 

/**
 * Inputs from the controller
 */
const form = reactive({
    nom: props.contacte.nom,
    cognoms: props.contacte.cognoms,
    movil: props.contacte.movil,
    email: props.contacte.email,
    empresa_id: props.contacte.empresa_id
})

async function scrollTop() {
    window.scroll({
        top: 100,
        behavior: "smooth",
    });
}

// Request form  
async function onSubmit(values) {
    router.put(`/contacte/update/${props.contacte.id}`, form);
    if (Object.keys(props.errors).length > 0) {
        scrollTop();
    }
}
</script>

<template>
    <Head :title="$t(`Editar Contacte`)" />
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">{{ $t("Editar Contacte") }}:</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5 mb-5">
            <div class="form-row">
                <div class="serverError" v-if="Object.keys(props.errors).length > 0">
                    <ol>
                        <li v-for="item in props.errors">
                            {{ $t(item) }}
                        </li>
                    </ol>
                </div>
                <!--Nom contacte -->
                <div class="form-group col">
                    <label class="mb-2">{{ $t("Nom") }}</label>
                    <Field name="nom" type="text" class="form-control" :class="{ 'is-invalid': errors.nom }"
                        v-model="form.nom" />
                    <div class="invalid-feedback">
                        {{ errors.nom }}
                    </div>
                </div>
                <!--Congoms contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Cognoms") }}</label>
                    <Field name="cognoms" type="text" class="form-control" :class="{ 'is-invalid': errors.cognoms }"
                        v-model="form.cognoms" />
                    <div class="invalid-feedback">
                        {{ errors.cognoms }}
                    </div>
                </div>
                <!--Mòvil contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Telèfon") }}</label>
                    <Field name="movil" type="text" class="form-control" :class="{ 'is-invalid': errors.movil }"
                        v-model="form.movil" />
                    <div class="invalid-feedback">
                        {{ errors.movil }}
                    </div>
                </div>
                <!--E-mail contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("E-mail") }}</label>
                    <Field name="email" type="text" class="form-control" :class="{ 'is-invalid': errors.email }"
                        v-model="form.email" />
                    <div class="invalid-feedback">{{ errors.email }}</div>
                </div>
                <!-- Empresa contacte -->
                <div class="form-group col mt-3 mb-5">
                    <label class="mb-2">{{ $t("Empresa") }}</label>
                    <Field name="empresa_id" type="text" class="form-control" :class="{ 'is-invalid': errors.empresa_id }"
                        :value="contacte.empresa.nom" disabled />
                    <div class="invalid-feedback">{{ errors.empresa_id }}</div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-lg-3">
                    {{ $t("Editar Contacte") }}
                </button>
                <Link :href="route('contacte.index')" as="button" class="btn btn-secondary">{{ $t("Cancel·la") }}</Link>
            </div>
        </Form><br><br>
    </AuthenticatedLayout>
</template>

<style scoped>
.serverError {
    color: rgb(202, 8, 8);
    background-color: rgb(252, 239, 183);
    border-radius: 5px;
    padding: 20px 20px 5px 10px;
    margin-bottom: 20px;
}
</style>
