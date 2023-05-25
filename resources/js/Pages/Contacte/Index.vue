<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { Head, Link } from "@inertiajs/vue3";
import { Form, Field } from "vee-validate";
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    contactes: {
        type: Object,
        required: true,
    },
    status: {
        type: String,
    },
    search: {
        type: Boolean,
        required: true,
    },
    nom: {
        type: String,
    },
    cognoms: {
        type: String,
    },
    empresa: {
        type: String,
    }
})

/**
 * Inputs from the controller
 */
const form = reactive({
    nom: props.nom ? props.nom : null,
    cognoms: props.cognoms ? props.cognoms : null,
    empresa: props.empresa ? props.empresa : null
})

// Request form  
async function goIndex(values) {
    router.get('/contacte')
}

// Request form  
async function onSubmit(values) {
    let route = '/contacte';

    form.nom?route += `/${form.nom}`:route += `/%25`;
    form.cognoms?route += `/${form.cognoms}`:route += `/%25`;
    form.empresa?route += `/${form.empresa}`:route += `/%25`;

    router.visit(route, { preserveScroll: true })
}
</script>

<template>
    <Head :title="$t(`Contactes`)" />
    {{ form.nomContacte }} {{ form.cognoms }} {{ form.empresaContacte }}
    <AuthenticatedLayout>
        <section class="section-list-companies">
            <div v-if="status" class="alert alert-success">
                {{ status }}
            </div>
            <div class="container-flex div-btn-create-new">
                <Link class="btn btn-secondary" :href="route('contacte.createWithoutId')">+ {{ $t("Nou Contacte") }}</Link>
            </div>
            <h1>{{ $t("Llistat de Contactes") }}</h1>
            <!-- Filtres -->
            <Form @change="onSubmit">
                <div class="d-flex p-2">
                    <!-- Nom -->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Nom") }}</b></label>
                        <Field name="nom" type="text" class="form-control" v-model="form.nom" />
                    </div>
                    <!-- Cognom -->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Cognoms") }}</b></label>
                        <Field name="cognoms" type="text" class="form-control" v-model="form.cognoms" />
                    </div>
                    <!-- Empresa-->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Empresa") }}</b></label>
                        <Field name="empresa" type="text" class="form-control" v-model="form.empresa" />
                    </div>
                    <!--Clear button-->
                    <div v-if="search" class="deleteSearch d-inline">
                        <button type="button" @click="goIndex();" class="btn btn-primary mr-1 me-3">
                            {{ $t("Netejar cerca") }}
                        </button>
                    </div>
                    <div v-else class="deleteSearch d-inline">
                        <button type="button" @click="goIndex();" class="btn btn-primary mr-1 me-3" disabled>
                            {{ $t("Netejar cerca") }}
                        </button>
                    </div>
                </div>
            </Form><br>
            <DataTable :columns=columns :rows=contactes :options=true name="contacte" :search=search>
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà el contacte.") }}
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>

<style>
.deleteSearch {
    margin-top: 40px;
    margin-left: 20px;
}
</style>