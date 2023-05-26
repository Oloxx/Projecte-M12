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
    empreses: {
        type: Object,
        required: true,
    },
    search: {
        type: Boolean,
        required: true,
    },
    nomEmpresa: {
        type: String
    },
    nomPoblacio: {
        type: String
    },
    nomSector: {
        type: String
    }
})


/**
 * Inputs from the controller
 */
const form = reactive({
    nom: props.nomEmpresa ?? null,
    poblacio: props.nomPoblacio ?? null,
    sector: props.nomSector ?? null
})


// Request form  
async function goIndex(values) {
    router.get('/empresa')
}

// Request form  
async function onSubmit(values) {

    let route = '/empresa';

    form.nom ? route += `/${form.nom}` : route += `/%25`;
    form.poblacio ? route += `/${form.poblacio}` : route += `/%25`;
    form.sector ? route += `/${form.sector}` : route += `/%25`;


    // router.visit necessary to preserveScroll works
    router.visit(route, { preserveScroll: true })
}

</script>

<template>
    <Head :title="$t(`Empreses`)" />
    <AuthenticatedLayout>
        <section class="section-list-companies">
            <div class="container-flex div-btn-create-new">
                <Link class="btn btn-secondary" :href="route('empresa.create')">+ {{ $t("Nova Empresa") }}</Link>
            </div>
            <h1>{{ $t(`Llistat d'Empreses`) }}</h1>
            <!-- Filtres -->
            <Form @change="onSubmit" class="mb-4">
                <div class="d-flex flex-wrap p-2">
                    <!--Nom empresa -->
                    <div class="p-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Nom") }}</b></label>
                        <Field name="nom" type="text" class="form-control" v-model="form.nom" />
                    </div>
                    <!--Nom població -->
                    <div class="p-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Població") }}</b></label>
                        <Field name="poblacio" type="text" class="form-control" v-model="form.poblacio" />
                    </div>
                    <!--Nom sector -->
                    <div class="p-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Sector") }}</b></label>
                        <Field name="sector" type="text" class="form-control" v-model="form.sector" />
                    </div>
                    <!--Clear button-->
                    <div class="deleteSearch ms-2">
                        <button type="button" @click="goIndex();" class="btn btn-primary mr-1 me-3" :disabled="!search">
                            {{ $t("Netejar cerca") }}
                        </button>
                    </div>
                </div>
            </Form>
            <DataTable :columns=columns :rows=empreses :options=true name="empresa" :search=search>
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà TOTS els contactes de l'empresa") }}
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>
@media only screen and (min-width: 768px) {
    .deleteSearch{
        margin-top: 40px;
    }
}
</style>