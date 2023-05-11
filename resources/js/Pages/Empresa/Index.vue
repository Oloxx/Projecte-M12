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
    }
})

/**
 * Inputs from the controller
 */
 const form = reactive({
    nom: null,
    poblacio: null,
    sector: null
})

// Request form  
async function goIndex(values) {
    router.get('/empresa')
}

// Request form  
async function onSubmit(values) {
    router.post('/empresa', form)
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
            <Form @input="onSubmit">
                <!--Nom empresa -->
                <div class="d-flex p-2">
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Nom") }}</b></label>
                        <Field name="nom" type="text" class="form-control" v-model="form.nom" />
                    </div>
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Població") }}</b></label>
                        <Field name="poblacio" type="text" class="form-control" v-model="form.poblacio" />
                    </div>
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Sector") }}</b></label>
                        <Field name="sector" type="text" class="form-control" v-model="form.sector" />
                    </div>
                </div>
                <!--Submit-->
                <div class="d-flex p-2 justify-content-md-end">
                    <div v-if="search" class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex">
                        <button type="button" @click="goIndex();" class="btn btn-primary mr-1 me-3">
                            {{ $t("Netejar cerca") }}
                        </button>
                    </div>
                </div>
            </Form><br>
            <DataTable :columns=columns :rows=empreses :options=true name="empresa" :search=search>
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà TOTS els contactes de l'empresa") }}
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>
.footer {
    bottom: 0;
}
</style>