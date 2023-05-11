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
    cicle: null,
    any: null,
    nom: null,
    contacte: null,
    usuari: null
})

// Request form  
async function goIndex(values) {
    router.get('/collaboracio')
}

// Request form  
async function onSubmit(values) {
    router.post('/collaboracio', form)
}
</script>

<template>
    <Head :title="$t(`Col·laboracions`)" />
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
            <Form @input="onSubmit">
                <div class="d-flex p-2">
                    <!-- Cicle -->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Cicle") }}</b></label>
                        <Field name="cicle" type="text" class="form-control" v-model="form.cicle" />
                    </div>
                    <!-- Empresa -->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Empresa") }}</b></label>
                        <Field name="nom" type="text" class="form-control" v-model="form.nom" />
                    </div>
                    <!-- Any -->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Any") }}</b></label>
                        <Field name="any" id="any" as="select" class="form-select" v-model="form.any">
                            <option :value="null" >Selecciona una opció</option>
                            <option v-for="any in anys" :value="any">
                                {{ any }}
                            </option>
                        </Field>
                    </div>
                    <!-- Contacte-->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Contacte") }}</b></label>
                        <Field name="contacte" type="text" class="form-control" v-model="form.contacte" />
                    </div>
                    <!-- Usuari-->
                    <div class="d-inline p-2 form-group col">
                        <label class="mb-2"><b>{{ $t("Usuari") }}</b></label>
                        <Field name="usuari" type="text" class="form-control" v-model="form.usuari" />
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
            <DataTable :columns=columns :rows=collaboracions :options=true name="collaboracio" :search=search>
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà la col·laboració.") }}
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>
