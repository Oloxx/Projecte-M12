<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { Head, Link } from "@inertiajs/vue3";


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
    }
})
</script>

<template>
    <Head title="Llistat de Col·laboracions" />
    <AuthenticatedLayout>
        <section class="section-list-companies">
            <div v-if="status" class="alert alert-success">
                {{ status }}
            </div>
            <div class="container-flex div-btn-create-new">
                <Link class="btn btn-secondary" :href="route('collaboracio.create')">+ Nova Col·laboració</Link>
            </div>
            <h1>Llistat de Col·laboracions</h1>
            <DataTable :columns=columns :rows=collaboracions :options=true name="collaboracio">
                <template #confirmDelete>
                    Aquesta acció eliminarà la col·laboració.
                </template>
            </DataTable>
        </section>
    </AuthenticatedLayout>
</template>
