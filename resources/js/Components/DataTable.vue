<script setup>
import DeleteButton from "@/Components/DeleteButton.vue"
import EditButton from "@/Components/EditButton.vue"
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    rows: {
        type: Array,
        required: true
    },
    options: {
        type: Boolean,
        default: false
    }
})

const fieldValue = (row, column) => {
    if (column.field.includes('.')) {
        const [objectKey, propertyKey] = column.field.split('.');
        return row[objectKey][propertyKey];
    } else {
        return row[column.field];
    }
}

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
            <tr v-for="row in rows" :key="row.id">
                <Link :href="route('empresa.show', row.id)" as="td" v-for="column in columns">
                {{ fieldValue(row, column) }}
                </Link>
                <td>
                    <EditButton :url="route('empresa.edit', row.id)" />
                    <DeleteButton :url="route('empresa.delete', row.id)" />
                </td>

            </tr>
        </tbody>
    </table>
</template>