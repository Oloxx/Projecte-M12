<script lang="ts">
export default {
    name: 'EmpresesIndex',
}
</script>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Footer from "@/Components/Footer.vue";
import { Head } from "@inertiajs/vue3";
import "../../../css/app.css";

defineProps({
    empreses: {
        type: Object,
        required: true,
    }
})

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout> </AuthenticatedLayout>
    <section class="section-list-companies">
        <div class="container-flex div-btn-create-new">
            <a
                class="btn btn-secondary"
                :href="`/empresa_create}`"
                role="button"
                >+ Nova Empresa</a
            >
        </div>
        <h1>Llistat d'Empreses</h1>
        <table
            id="myTable"
            class="table table-striped table-hover"
            style="width: 100%"
        >
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Telefón</th>
                    <th>Web</th>
                    <th>E-mail</th>
                    <th>Poblacio</th>
                    <th>Categoria</th>
                    <th>Sector</th>
                    <td colspan="3" class="options">Opcions</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for=" empresa in empreses">
                    <td height="17" align="left">{{ empresa.nom }}</td>
                    <td align="left">{{ empresa.telefon }}</td>
                    <td align="left">{{ empresa.web }}</td>
                    <td align="left">{{ empresa.email }}</td>
                    <td align="left" >{{ empresa.poblacio.nom }}</td>
                    <td align="left">{{ empresa.categoria.nom }}</td>
                    <td align="left" v-if="empresa.sector_id">
                        {{ empresa.sector.nom }}
                    </td>
                    <td align="center">
                        <a :href="`/empresa_show/${empresa.id}`">+ Info</a>
                    </td>
                    <td align="center">
                        <a :href="`/empresa_edit/${empresa.id}`">Editar</a>
                    </td>
                    <td align="center">
                         <form
                            method="POST"
                            :action="`/empresa_delete/${empresa.id}`"
                        >
                            @csrf @method('delete')
                            <input type="submit" id="delete" value="Eliminar" />
                        </form> 
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <Footer></Footer>
</template>
