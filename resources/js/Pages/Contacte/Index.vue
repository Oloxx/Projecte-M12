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
    }
})

/**
 * Inputs from the controller
 */
 const form = reactive({
    nomContacte: null,
    cognoms: null,
    empresaContacte: null
})

// Request form  
async function goIndex(values) {
    router.get('/contacte')
}

// Request form  
async function onSubmit(values) {
    router.post('/contacte', form)
}
</script>

<template>
    <Head :title="$t(`Contactes`)" />
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
            <Form @input="onSubmit">
                <div class="d-flex p-2">
                    <!-- Nom -->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Nom") }}</b></label>
                        <Field name="nomContacte" type="text" class="form-control" v-model="form.nomContacte" />
                    </div>
                   <!-- Cognom -->
                   <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Cognoms") }}</b></label>
                        <Field name="cognoms" type="text" class="form-control" v-model="form.cognoms" />
                    </div>
                    <!-- Empresa-->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Empresa") }}</b></label>
                        <Field name="empresaContacte" type="text" class="form-control" v-model="form.empresaContacte" />
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
            <DataTable :columns=columns :rows=contactes :options=true name="contacte" :search=search>
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà el contacte.") }}
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>
