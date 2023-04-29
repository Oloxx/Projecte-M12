<script setup>
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import BModal from "@/Components/BModal.vue";

const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    rows: {
        type: Object,
        required: true,
    },
    options: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
        required: true
    }
});

const fieldValue = (row, column) => {
    if (column.field.includes(".")) {
        const [objectKey, propertyKey] = column.field.split(".");
        return row[objectKey][propertyKey];
    } else {
        if (column.field !== 'logo') {
            return row[column.field];
        }
        if (row['logo'] !== null) {
            return `<div class="rounded-circle overflow-hidden" style="width: 36px; height: 36px; border: 1px solid #808080;">
                    <img src='${row['logo']}' alt='Logo' style='width: 100%; height: 100%; object-fit: cover;' />
                </div>`;
        }
        return `<span class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border: 1px solid #808080;">
                        <i class="bi bi-briefcase"></i>
                    </span>`;
    }
};

const filteredColumns = () => {
    return props.columns.filter(column => column.label !== 'Logo');
}

</script>

<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-if="columns[0].label === 'Logo'" width=60></th>
                <th v-for="column in filteredColumns()">{{ column.label }}</th>
                <th v-if="options">Opcions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows.data" :key="row.id">
                <Link :href="route(name + '.show', row.id)" as="td" v-for="column in columns" v-html="fieldValue(row, column)" class="align-middle"></Link>
                <td v-if="options">
                    <EditButton :url="route(name + '.edit', row.id)" />
                    <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#Modal">
                        <i class="bi bi-trash"></i>
                    </button>
                    <BModal>
                        <template #header>
                            <h1>Confirmeu la supressió</h1>
                        </template>
                        <template #body>
                            <p>
                                Estàs segur que vols eliminar <b>{{ row.nom }}</b>?
                                <br>
                                <slot name="confirmDelete"></slot>
                            </p>
                        </template>
                        <template #button>
                            <DeleteButton data-bs-dismiss="modal" :url="route(name + '.delete', row.id)">
                                Elimina
                            </DeleteButton>
                        </template>
                    </BModal>
                </td>
            </tr>
        </tbody>
    </table>
    <Pagination :data="rows" />
</template>
