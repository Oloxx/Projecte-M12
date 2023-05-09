<script setup>
import EditButton from "@/Components/EditButton.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';
import { Form, Field } from "vee-validate";
import { reactive } from 'vue';
import { useI18n } from "vue-i18n";

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
    },
    search: {
        type: Boolean,
        required: true,
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

const { t } = useI18n();

function deleteUser(row, name) {
    let txt = '';
    let registre = '';
    switch (name) {
        case 'empresa':
            txt = `</br><h2>${t("AVÍS DE CONFIRMACIÓ")}</h2></br><p>${t("Realment vols eliminar l'empresa")} <b>${row.nom}</b>?</p>`;
            registre = t("Empresa {name} eliminada!", {name: row.nom});
            break;
        case 'contacte':
            txt = `</br><h2>${t("AVÍS DE CONFIRMACIÓ")}</h2></br><p>${t("Realment vols eliminar el contacte")} <b>${row.nom}</b>?</p>`;
            registre = t("Contacte {name} eliminat!", {name: row.nom});
            break;
        default:
            txt = `</br><h2>${t("AVÍS DE CONFIRMACIÓ")}</h2></br><p>${t("Realment vols eliminar la col·laboració amb l'empresa")} <b>${row.empresa.nom}</b>?</p>`;
            registre = t("Col·laboració {name} eliminada!", {name: row.empresa.nom});
            break;
    }

    Swal.fire({
        html: txt,
        showDenyButton: true,
        confirmButtonText: t("Eliminar"),
        denyButtonText: t("Cancel·lar"),
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Swal.fire(registre, '', 'success');
            router.delete(`/${name}/delete/${row.id}`)
        } else if (result.isDenied) {
            Swal.fire(t("Els canvis no s'han guardat"), '', 'info')
        }
    })
}

/**
 * Inputs from the controller
 */
const form = reactive({
    nom: null,
    poblacio: null,
    sector: null
})

// Request form  
async function goIndex(values) {
    router.get('/empresa/search')
}

// Request form  
async function onSubmit(values) {
    router.post('/empresa/search', form)
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
                    v-html="fieldValue(row, column)" class="align-middle" style="cursor: pointer;">
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
    <br>
    <h1>Búsqueda personalitzada</h1>
    <Form @submit="onSubmit">
        <!--Nom empresa -->
        <div class="d-flex p-2">
            <div class="d-inline p-2 form-group col">
                <label class="mb-2">{{ $t("Nom") }}</label>
                <Field name="nom" type="text" class="form-control" v-model="form.nom" />
            </div>
            <div class="d-inline p-2 form-group col">
                <label class="mb-2">{{ $t("Població") }}</label>
                <Field name="poblacio" type="text" class="form-control" v-model="form.poblacio" />
            </div>
            <div class="d-inline p-2 form-group col">
                <label class="mb-2">{{ $t("Sector") }}</label>
                <Field name="sector" type="text" class="form-control" v-model="form.sector" />
            </div>
        </div>
        <!--Submit-->
        <div class="d-flex p-2 justify-content-md-end">
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    {{ $t("Cercar empresa") }}
                </button>
            </div>
            <div v-if="search" class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex">
                <button type="button" @click="goIndex();" class="btn btn-primary mr-1 me-3">
                    {{ $t("Netejar cerca") }}
                </button>
            </div>
        </div>
    </Form><br>
</template>
