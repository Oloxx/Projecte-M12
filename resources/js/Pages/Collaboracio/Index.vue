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
    collaboracions: {
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
    year: {
        type: Number,
        required: true,
    },
    cicleColab: {
        type: String,
    },
    empresaColab: {
        type: String,
    },
    anyColab: {
        type: String,
    },
    contacteColab: {
        type: String,
    },
    usuariColab: {
        type: String,
    }
})

var anys = reactive([]);

function carregarAny() {
    anys.length = 0;

    for (let index = 1970; index < props.year; index++) {
        anys.push(index);
    }

    anys = anys.reverse();

    return anys;
}

carregarAny();

/**
 * Inputs from the controller
 */
const form = reactive({
    cicle: props.cicleColab ?? null,
    any: props.anyColab ?? null,
    nom: props.empresaColab ?? null,
    contacte: props.contacteColab ?? null,
    usuari: props.usuariColab ?? null,
})

// Request form  
async function goIndex(values) {
    router.get('/collaboracio')
}

// Request form  
async function onSubmit(values) {
    let route = '/collaboracio';

    form.cicle ? route += `/${form.cicle}` : route += `/%25`;
    form.nom ? route += `/${form.nom}` : route += `/%25`;
    form.any ? route += `/${form.any}` : route += `/%25`;
    form.contacte ? route += `/${form.contacte}` : route += `/%25`;
    form.usuari ? route += `/${form.usuari}` : route += `/%25`;

    router.visit(route, { preserveScroll: true })
}
</script>

<template>
    <Head :title="$t(`Estades`)" />
    <AuthenticatedLayout>
        <section class="section-list-companies">
            <div v-if="status" class="alert alert-success">
                {{ status }}
            </div>
            <div class="container-flex div-btn-create-new">
                <Link class="btn btn-secondary" :href="route('collaboracio.create')">+ {{ $t("Nova Col·laboració") }}</Link>
            </div>
            <h1>{{ $t("Llistat d'Estades") }}</h1>
            <!-- Filtres -->
            <Form @change="onSubmit" class="mb-4">
                <div class="d-flex flex-wrap p-2">
                    <!-- Cicle -->
                    <div class="p-2 col-md-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Cicle") }}</b></label>
                        <Field name="cicle" type="text" class="form-control" v-model="form.cicle" />
                    </div>
                    <!-- Empresa -->
                    <div class="p-2 col-md-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Empresa") }}</b></label>
                        <Field name="nom" type="text" class="form-control" v-model="form.nom" />
                    </div>
                    <!-- Any -->
                    <div class="p-2 col-md-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Any") }}</b></label>
                        <Field name="any" id="any" as="select" class="form-select" v-model="form.any">
                            <option :value="null">Selecciona una opció</option>
                            <option v-for="any in anys" :value="any">
                                {{ any }}
                            </option>
                        </Field>
                    </div>
                    <!-- Contacte-->
                    <div class="p-2 col-md-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Contacte") }}</b></label>
                        <Field name="contacte" type="text" class="form-control" v-model="form.contacte" />
                    </div>
                    <!-- Usuari-->
                    <div class="p-2 col-md-2 flex-fill form-group">
                        <label class="mb-2"><b>{{ $t("Usuari") }}</b></label>
                        <Field name="usuari" type="text" class="form-control" v-model="form.usuari" />
                    </div>
                    <!--Clear button-->
                    <div class="deleteSearch ms-2">
                        <button type="button" @click="goIndex();" class="btn btn-primary mr-1 me-3" :disabled="!search">
                            {{ $t("Netejar cerca") }}
                        </button>
                    </div>
                </div>
            </Form>
            <DataTable :columns=columns :rows=collaboracions :options=true name="collaboracio" :search=search>
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà la col·laboració.") }}
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>

<style>
.deleteSearch{
    margin-top: 40px;
}
</style>