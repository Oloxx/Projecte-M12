<script setup>
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect'

/**
 *  Data received from the controller
 */
const props = defineProps({
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
    },
});

const data = reactive({
    poblacioSelected: false,
    showPoblacioError: false
})

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
    categoria_id: Yup.number().required("La població és obligatoria"),
    sector_id: Yup.number().required("La població és obligatoria"),
});

/**
 * Inputs from the controller
 */
const form = reactive({
    nom: null,
    telefon: null,
    web: null,
    email: null,
    poblacio_id: null,
    categoria_id: null,
    sector_id: null
})

function handleSelect() {
    data.poblacioSelected = true
    data.showPoblacioError = false
}

// Request form  
async function onSubmit() {
    if (data.poblacioSelected === true) {
        router.post('/empresa/store', form)
    } else {
        console.log('a');
        data.showPoblacioError = true
        console.log(data.showPoblacioError);
    }
}
</script>

<template>
    <Head :title="$t(`Crear Empresa`)" />

    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">{{ $t("Nova Empresa") }}</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5">
            <div class="form-row">
                <!--Nom empresa -->
                <div class="form-group col">
                    <label class="mb-2">{{ $t("Empresa") }}</label>
                    <Field name="nom" type="text" class="form-control" :class="{ 'is-invalid': errors.nom }" v-model="form.nom"/>
                    <div class="invalid-feedback">
                        {{ errors.nom }}
                    </div>
                </div>
                <!--Telèfon empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Telèfon") }}</label>
                    <Field name="telefon" type="text" class="form-control" :class="{ 'is-invalid': errors.telefon }" v-model="form.telefon"/>
                    <div class="invalid-feedback">
                        {{ errors.telefon }}
                    </div>
                </div>
                <!--Web empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Web") }}</label>
                    <Field name="web" type="text" class="form-control" v-model="form.web"/>
                </div>
                <!--E-mail empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("E-mail") }}</label>
                    <Field name="email" type="text" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="form.email"/>
                    <div class="invalid-feedback">{{ errors.email }}</div>
                </div>
                <!--Població empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Població") }}</label>
                    <VueMultiselect
                    name="poblacio_id"
                    v-model="form.poblacio_id"
                    :options="poblacions"
                    :allow-empty="false"
                    :close-on-select="true"
                    :clear-on-select="false"
                    selectLabel=""
                    selectedLabel=""
                    deselectLabel=""
                    placeholder=""
                    label="nom"
                    trackBy="id"
                    @select="handleSelect"
                    />
                    <div v-if="data.showPoblacioError" class="invalid-feedback">La població és obligatoria</div>
                </div>
                <!--Categoria empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Categoria") }}</label>
                    <Field name="categoria_id" as="select" class="form-select"
                        :class="{ 'is-invalid': errors.categoria_id }" v-model="form.categoria_id">
                        <option v-for="categoria in categories" :value="categoria.id">
                            {{ categoria.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">
                        {{ errors.categoria_id }}
                    </div>
                </div>
                <!--Sector empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Sector") }}</label>
                    <Field name="sector_id" as="select" class="form-select" :class="{ 'is-invalid': errors.sector_id }" v-model="form.sector_id">
                        <option v-for="sector in sectors" :value="sector.id">
                            {{ sector.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.sector_id }}</div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    {{ $t("Crear Empresa") }}
                </button>
                <Link :href="route('empresa.index')" as="button" class="btn btn-secondary">{{ $t("Cancel·la") }}</Link>
            </div>
        </Form><br><br><br>
    </AuthenticatedLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>