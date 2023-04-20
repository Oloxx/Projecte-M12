<script setup>
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import Pagination from "@/Components/Pagination.vue";
import "../../css/app.css";
import { Link } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";


const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    rows: {
        type: Array,
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
        return row[column.field];
    }
};

</script>

<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="column in columns">{{ column.label }}</th>
                <th v-if="options">Opcions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows.data" :key="row.id">
                <Link :href="route(name + '.show', row.id)" as="td" v-for="column in columns">
                    {{ fieldValue(row, column) }}
                </Link>
                <td v-if="options">
                    <EditButton :url="route(name + '.edit', row.id)" />
                    <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#Modal">
                        <i class="bi bi-trash"></i>
                    </button>
                    <Modal>
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
                    </Modal>
                </td>
            </tr>
        </tbody>
    </table>
    <Pagination :data="rows"/>
</template>
