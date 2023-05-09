<script setup>
import { Head, Link } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from '@inertiajs/vue3';


/**
 *  Data received from the controller
 */
const props = defineProps({
    empresa: {
        type: Object,
        required: true,
    },
    contactes: {
        type: Object,
        required: true,
    },
    columnsContacte: {
        type: Array,
        required: true,
    },
    collaboracions: {
        type: Object,
        required: true,
    },
    columnsCollaboracio: {
        type: Array,
        required: true,
    },
});

// Request form  
async function onSubmitContacte() {
    router.get(`/contacte/create/${props.empresa.id}`)
}

async function onSubmitCollaboracio() {
    router.get(`/collaboracio/create/${props.empresa.id}`)
}
</script>

<template>
    <Head :title="empresa.nom" />

    <AuthenticatedLayout>
        <div class="m-5">
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <Link :href="route('empresa.index')" as="button" type="button" class="btn btn-secondary">{{ $t("Anar al Llistat") }}</Link>
                <Link :href="route('empresa.create')" as="button" type="button" class="btn btn-secondary">{{ $t("Afegir nova empresa") }}</Link>
            </div>
            <h1 class="mb-4">{{ $t("Informació de l'empresa") }}: {{ empresa.nom }}</h1>
            <div class="d-flex align-items-center mb-3">
                <label for="telefon" class="me-2 fw-bold">{{ $t("Telèfon") }}</label>
                <input class="form-control" type="text" id="telefon" :value="empresa.telefon" readonly>
            </div>
            <div class="d-flex align-items-center mb-3">
                <label for="web" class="me-2 fw-bold">{{ $t("Web") }}</label>
                <input class="form-control" type="text" id="web" :value="empresa.web" readonly>
            </div>
            <div class="d-flex align-items-center mb-3">
                <label for="email" class="me-2 fw-bold">{{ $t("E-mail") }}</label>
                <input class="form-control" type="text" id="email" :value="empresa.email" readonly>
            </div>
            <div class="d-flex align-items-center mb-3">
                <label for="poblacio_id" class="me-2 fw-bold">{{ $t("Població") }}</label>
                <input class="form-control" type="text" id="poblacio_id" :value="empresa.poblacio.nom" readonly>
            </div>
            <div class="d-flex align-items-center mb-3">
                <label for="categoria_id" class="me-2 fw-bold">{{ $t("Categoria") }}</label>
                <input class="form-control" type="text" id="categoria_id" :value="empresa.categoria.nom" readonly>
            </div>
            <div class="d-flex align-items-center mb-3">
                <label for="sector_id" class="me-2 fw-bold">{{ $t("Sector") }}</label>
                <input class="form-control" type="text" id="sector_id" :value="empresa.sector.nom" readonly>
            </div>
            <br />
            <h1 class="mb-4">{{ $t("Llistat de Contactes") }}</h1>
            <DataTable v-if="props.contactes.total != 0" :columns="columnsContacte" :rows="contactes" :options="true"
                name="contacte">
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà TOTS els contactes de l'empresa") }}
                </template>
            </DataTable>
            <span v-else>{{ $t("Encara no s'ha afegit cap contacte") }}</span>
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" @click="onSubmitContacte()" class="btn btn-primary mr-1 me-3">
                    {{ $t("Afegir contacte") }}
                </button>
            </div>
            <h1 class="mb-4">Llistat d'estades</h1>
            <DataTable v-if="props.collaboracions.total != 0" :columns="columnsCollaboracio" :rows="collaboracions" :options="true"
                name="collaboracio">
            </DataTable>
            <span v-else> Encara no s'ha afegit cap estada.</span>
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" @click="onSubmitCollaboracio()" class="btn btn-primary mr-1 me-3">
                    Afegir Estada
                </button>
            </div><br>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
label {
    width: 95px;
}
</style>