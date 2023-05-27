<script setup>
import EditButton from "@/Components/EditButton.vue";
import Pagination from "@/Components/Pagination.vue";
import vue3StarRatings from "vue3-star-ratings";
import { Link } from "@inertiajs/vue3";
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';
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
            registre = t("Empresa {name} eliminada!", { name: row.nom });
            break;
        case 'contacte':
            txt = `</br><h2>${t("AVÍS DE CONFIRMACIÓ")}</h2></br><p>${t("Realment vols eliminar el contacte")} <b>${row.nom}</b>?</p>`;
            registre = t("Contacte {name} eliminat!", { name: row.nom });
            break;
        default:
            txt = `</br><h2>${t("AVÍS DE CONFIRMACIÓ")}</h2></br><p>${t("Realment vols eliminar l'estada amb l'empresa")} <b>${row.empresa.nom}</b>?</p>`;
            registre = t("Estada {name} eliminada!", { name: row.empresa.nom });
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

</script>

<template>
    <div class="container-fluid tabl">
        <div class="row">
            <!--content table-->
            <div class="col" style="padding-right: 0;">
                <div class="table-responsive tableContent">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th v-if="columns[0].label === 'Logo'" width=60>
                                </th>
                                <th v-for="column in filteredColumns()">{{
                                    $t(column.label) }}</th>
                                <th v-if="name == 'collaboracio'">{{
                                    $t("Valoració") }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="rows.data">
                            <tr v-for="row in rows.data" :key="row.id">
                                <template v-if="name == 'empresa'" class="d-sm-none">
                                    <Link :href="route(name + '.show', row.id)" as="td" v-for="column in columns"
                                        v-html="fieldValue(row, column)" class="align-middle" style="cursor: pointer;">
                                    </Link>
                                </template>
                                <template v-else class="d-sm-none">
                                    <Link :href="route(name + '.index')" as="td" v-for="column in columns"
                                        v-html="fieldValue(row, column)" class="align-middle" preserve-scroll>
                                    </Link>
                                </template>
                                <td v-if="row.stars > 0">
                                    <vue3-star-ratings class="stars" starSize=15 :numberOfStars="5" inactiveColor="#DDDDDD"
                                        :showControl="false" v-model="row.stars" :disableClick="true" /><br>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="row in rows" :key="row.id">
                                <Link :href="route(name + '.show', row.id)" as="td" v-for="column in columns"
                                    v-html="fieldValue(row, column)" class="align-middle" style="cursor: pointer;">
                                </Link>
                                <td v-if="row.stars > 0">
                                    <vue3-star-ratings class="stars" starSize=15 :numberOfStars="5" inactiveColor="#DDDDDD"
                                        :showControl="false" v-model="row.stars" :disableClick="true" /><br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- buttons table -->
            <div class="col col-xs-2 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-2 text-center" style="padding-left: 0;">
                <div class="tableButtons">
                    <table class="table optionsTable">
                        <thead class="center">
                            <tr>
                                <th v-if="options">{{ $t("Opcions") }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="rows.data">
                            <tr v-for="row in rows.data" :key="row.id">
                                <td v-if="options" style="display:ruby-base-container; padding-bottom: 5px;">
                                    <EditButton :url="route(name + '.edit', row.id)" aria-label="Edit" />
                                    <button class="btn btn-danger mx-1" aria-label="Delete" @click="deleteUser(row, name)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="row in rows" :key="row.id">
                                <td v-if="options" style="padding-bottom: 5px;" >
                                    <EditButton :url="route(name + '.edit', row.id)" aria-label="Edit" />
                                    <button class="btn btn-danger mx-1" aria-label="Delete" @click="deleteUser(row, name)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <Pagination :data="rows" :search="props.search" />
</template>

<style scoped>
.stars {
    margin-top: 6px;
}

td {
    height: 53px;
}

@media only screen and (max-width: 498px) {
    .tabl {
        padding-left: 10px !important;
        padding-right: 0px !important;
    }
}
</style>