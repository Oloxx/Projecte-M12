<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { Head, Link } from "@inertiajs/vue3";


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
    }
})
</script>

<template>
    <Head title="Llistat de Contactes" />
    <AuthenticatedLayout>
        <section class="section-list-companies">
            <div v-if="status" class="alert alert-success">
                {{ status }}
            </div>
            <div class="container-flex div-btn-create-new">
                <Link class="btn btn-secondary" :href="route('contacte.create')">+ Nou Contacte</Link>
            </div>
            <h1>Llistat de Contactes</h1>
            <DataTable :columns=columns :rows=contactes :options=true name="contacte">
                <template #confirmDelete>
                    Aquesta acció eliminarà el contacte.
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>
