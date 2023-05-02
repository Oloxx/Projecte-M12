<script setup>
import EditButton from "@/Components/EditButton.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';

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

function deleteUser(row, name) {

    let txt = '';
    let registre = '';
    if(name == 'empresa'){
        txt = `</br><h2>AVÍS DE CONFIRMACIÓ</h2></br><p>Realment vols eliminar l\'empresa <b>${row.nom}</b>?</p>`;
        registre = `Empresa ${row.nom} eliminada!`;
    } else if (name == 'contacte'){
        txt = `</br><h2>AVÍS DE CONFIRMACIÓ</h2></br><p>Realment vols eliminar el contacte <b>${row.nom}</b>?</p>`;
        registre = `Contacte ${row.nom} eliminat!`;
    } else {
        txt = `</br><h2>AVÍS DE CONFIRMACIÓ</h2></br><p>Realment vols eliminar la col·laboració amb l'empresa <b>${row.empresa.nom}</b>?</p>`;
        registre = `Col·laboració ${row.empresa.nom} eliminada!`;
    }

    Swal.fire({
        html: txt,
        showDenyButton: true,
        confirmButtonText: 'Eliminar',
        denyButtonText: `Cancelar`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Swal.fire(registre, '', 'success');
            router.delete(`/${name}/delete/${row.id}`)
        } else if (result.isDenied) {
            Swal.fire('Els canvis no s\'han guardat', '', 'info')
        }
    })

}

</script>

<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-if="columns[0].label === 'Logo'" width=60></th>
                <th v-for="column in filteredColumns()">{{ $t(column.label) }}</th>
                <th v-if="options">{{ $t("Opcions") }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows.data" :key="row.id">
                <Link :href="route(name + '.show', row.id)" as="td" v-for="column in columns"
                    v-html="fieldValue(row, column)" class="align-middle">
                </Link>
                <td v-if="options">
                    <EditButton :url="route(name + '.edit', row.id)" />
                    <button class="btn btn-danger mx-1" @click="deleteUser(row, name)">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <Pagination :data="rows" />
</template>
