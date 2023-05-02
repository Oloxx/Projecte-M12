<script setup>
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';

/**
 *  Data received from the controller
 */
const props = defineProps({
    contacte: {
        type: Object,
        required: true,
    }
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

// Request form  
async function onSubmit(values) {
    router.put(`/contacte/update/${props.contacte.id}`, form)
}
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">Editar contacte:</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5">
            <div class="form-row">
                <!--Nom contacte -->
                <div class="form-group col">
                    <label class="mb-2">Nom</label>
                    <Field name="nom" type="text" class="form-control" :class="{ 'is-invalid': errors.nom }" v-model="form.nom"/>
                    <div class="invalid-feedback">
                        {{ errors.nom }}
                    </div>
                </div>
                <!--Congoms contacte -->
                <div class="form-group col">
                    <label class="mb-2">Cognoms</label>
                    <Field name="cognoms" type="text" class="form-control" :class="{ 'is-invalid': errors.cognoms }" v-model="form.cognoms"/>
                    <div class="invalid-feedback">
                        {{ errors.cognoms }}
                    </div>
                </div>
                <!--Mòvil contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Telèfon</label>
                    <Field name="movil" type="text" class="form-control" :class="{ 'is-invalid': errors.movil }" v-model="form.movil"/>
                    <div class="invalid-feedback">
                        {{ errors.movil }}
                    </div>
                </div>
                <!--E-mail contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">E-mail</label>
                    <Field name="email" type="text" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="form.email"/>
                    <div class="invalid-feedback">{{ errors.email }}</div>
                </div>
                <!-- Empresa contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Empresa</label>
                    <Field name="empresa_id" type="text" class="form-control" :class="{ 'is-invalid': errors.empresa_id }" :value="contacte.empresa.nom" disabled/>
                    <div class="invalid-feedback">{{ errors.empresa_id }}</div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    Editar Contacte
                </button>
                <Link :href="route('contacte.index')" as="button" class="btn btn-secondary">Cancel·lar</Link>
            </div>
        </Form><br><br><br>
    </AuthenticatedLayout>
</template>
