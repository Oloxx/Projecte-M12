<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { Head } from "@inertiajs/vue3";


const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    empreses: {
        type: Object,
        required: true,
    }
})

</script>




  

<template>
    <Head title="Llistat d'Empreses" />
    <AuthenticatedLayout></AuthenticatedLayout>
        <section class="section-list-companies">
            <div class="container-flex div-btn-create-new">
                <a class="btn btn-secondary" :href="`/empresa/create`" role="button">+ Nova Empresa</a>
            </div>
            <h1>Llistat d'Empreses</h1>
            <DataTable :columns=columns :rows=empreses :options=true />
        </section>
</template>
