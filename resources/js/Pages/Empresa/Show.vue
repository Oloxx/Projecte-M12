<script setup>
import { Head, Link } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

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
    columns: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head :title="empresa.nom" />

    <AuthenticatedLayout>
        <div class="m-5">
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <Link :href="route('empresa.index')" as="button" type="button" class="btn btn-secondary">{{ $t("Anar al Llistat") }}</Link>
                <Link :href="route('empresa.create')" as="button" type="button" class="btn btn-secondary">{{ $t("Afegir nova empresa") }}</Link>
            </div>
            <h1 class="mb-4">{{ $t("Informació de l'empresa") }}: <b>{{ empresa.nom }}</b></h1>
            <div class="div-content mb-3">
                <label for="telefon" class="box-label"><b>{{ $t("Telèfon") }}</b></label>
                <span class="box">{{ empresa.telefon }}</span>
            </div>
            <div class="div-content mb-3">
                <label for="web" class="box-label"><b>{{ $t("Web") }}</b></label>
                <span class="box">{{ empresa.web }}</span>
            </div>
            <div class="div-content mb-3">
                <label for="email" class="box-label"><b>{{ $t("E-mail") }}</b></label>
                <span class="box">{{ empresa.email }}</span>
            </div>
            <div class="div-content mb-3">
                <label for="poblacio_id" class="box-label"><b>{{ $t("Població") }}</b></label>
                <span class="box">{{ empresa.poblacio.nom }}</span>
            </div>
            <div class="div-content mb-3">
                <label for="categoria_id" class="box-label"><b>{{ $t("Categoria") }}</b></label>
                <span class="box">{{ empresa.categoria.nom }}</span>
            </div>
            <div class="div-content mb-3">
                <label for="sector_id" class="box-label"><b>{{ $t("Sector") }}</b></label>
                <span class="box"> {{ empresa.sector.nom }}</span>
            </div>
            <br />
            <h1 class="mb-4">{{ $t("Llistat de Contactes") }}</h1>
            <DataTable v-if="Object.keys(props.contactes).length == 0" :columns="columns" :rows="contactes" :options="true"
                name="contacte">
                <template #confirmDelete>
                    {{ $t("Aquesta acció eliminarà TOTS els contactes de l'empresa") }}
                </template>
            </DataTable>
            <span v-else>{{ $t("Encara no s'ha afegit cap contacte") }}</span>
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <Link :href="route('contacte.create', empresa.id)" class="btn btn-secondary">
                {{ $t("Afegir contacte") }}</Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.box-label {
    display: inline-block;
    width: 6%;
}

.box {
    display: inline-block;
    border: 1px solid rgb(105, 105, 105);
    border-radius: 3px;
    padding: 5px;
    width: 94%;
}
</style>
