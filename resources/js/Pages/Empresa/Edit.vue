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
    empresa: {
        type: Object,
        required: true,
    },
    poblacions: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    }
});

/**
 * Validations
 */
const schema = Yup.object().shape({
    nom: Yup.string().required("El nom de l'empresa és obligatori"),
    telefon: Yup.string().matches(
        /^[0-9]{9}/,
        "El número de telèfon ha d'estar compost per nomès 9 números."
    ),
    email: Yup.string().email("El E-mail introduït és invàlid"),
    poblacio_id: Yup.number().required("La població és obligatoria"),
    categoria_id: Yup.number().required("La població és obligatoria"),
    sector_id: Yup.number().required("La població és obligatoria"),
});

/**
 * Inputs from the controller
 */
const form = reactive({
    nom: props.empresa.nom,
    telefon: props.empresa.telefon,
    web: props.empresa.web,
    email: props.empresa.email,
    poblacio_id: props.empresa.poblacio_id,
    categoria_id: props.empresa.categoria_id,
    sector_id: props.empresa.sector_id
})

// Request form  
async function onSubmit(values) {
    let id = props.empresa.id;
    router.put(`/empresa/update/${id}`, form)
}
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">Editar empresa</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5">
            <div class="form-row">
                <!--Nom empresa -->
                <div class="form-group col">
                    <label class="mb-2">Empresa</label>
                    <Field name="nom" type="text" class="form-control" :class="{ 'is-invalid': errors.nom }"
                        v-model="form.nom" />
                    <div class="invalid-feedback">
                        {{ errors.nom }}
                    </div>
                </div>
                <!--Telèfon empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Telèfon</label>
                    <Field name="telefon" type="text" class="form-control" :class="{ 'is-invalid': errors.telefon }"
                        v-model="form.telefon" />
                    <div class="invalid-feedback">
                        {{ errors.telefon }}
                    </div>
                </div>
                <!--Web empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Web</label>
                    <Field name="web" type="text" class="form-control" v-model="form.web" />
                </div>
                <!--E-mail empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">E-mail</label>
                    <Field name="email" type="text" class="form-control" :class="{ 'is-invalid': errors.email }"
                        v-model="form.email" />
                    <div class="invalid-feedback">{{ errors.email }}</div>
                </div>
                <!--Població empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Població</label>
                    <Field name="poblacio_id" as="select" class="form-select" :class="{ 'is-invalid': errors.poblacio_id }"
                        v-model="form.poblacio_id">
                        <option v-for="poblacio in poblacions" :value="poblacio.id"
                            :selected="poblacio.id == empresa.poblacio_id">
                            {{ poblacio.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.poblacio_id }}</div>
                </div>
                <!--Categoria empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Categoria</label>
                    <Field name="categoria_id" as="select" class="form-select"
                        :class="{ 'is-invalid': errors.categoria_id }" v-model="form.categoria_id">
                        <option v-for="categoria in categories" :value="categoria.id"
                            :selected="categoria.id == empresa.categoria_id">{{ categoria.nom }} </option>
                    </Field>
                    <div class="invalid-feedback">
                        {{ errors.categoria_id }}
                    </div>
                </div>
                <!--Sector empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Sector</label>
                    <Field name="sector_id" as="select" class="form-select" :class="{ 'is-invalid': errors.sector_id }"
                        v-model="empresa.sector_id">
                        <option v-for="sector in sectors" :value="sector.id" :selected="sector.id == form.sector_id">
                            {{ sector.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.sector_id }}</div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    Editar Empresa
                </button>
                <Link :href="route('empresa.index')" as="button" class="btn btn-secondary">Cancel·lar</Link>
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
