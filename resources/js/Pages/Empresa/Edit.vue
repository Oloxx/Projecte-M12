<script setup>
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';
import SearchSelect from "@/Components/SearchSelect.vue";
import { useI18n } from "vue-i18n";

/**
 *  Data received from the controller
 */
const props = defineProps({
    empresa: {
        type: Object,
        required: true,
    },
    poblacions: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    }
});

const { t } = useI18n();

const state = reactive({
    url: props.empresa.logo,
    logo: null
})

/**
 * Validations
 */
const schema = Yup.object().shape({
    nom: Yup.string().required("El nom de l'empresa és obligatori"),
    telefon: Yup.string().matches(
        /^[0-9]{9}/,
        "El número de telèfon ha d'estar compost per nomès 9 números."
    ),
    email: Yup.string().email("El E-mail introduït és invàlid"),
});

/**
 * Inputs from the controller
 */
const form = reactive({
    _method: 'put',
    nom: props.empresa.nom,
    telefon: props.empresa.telefon,
    web: props.empresa.web,
    email: props.empresa.email,
    poblacio_id: props.poblacions.find(x => x.id == props.empresa.poblacio_id),
    categoria_id: props.empresa.categoria_id,
    sector_id: props.empresa.sector_id,
    logo: null
})

function onFileChange(e) {
    if (e.target.files[0]) {
        const file = e.target.files[0];
        const maxSize = 2048 * 1024; // 2MB
        if (file.type.startsWith('image/') && file.size < maxSize) {
            state.url = URL.createObjectURL(file);
            state.logo = null;
        } else {
            state.logo = t("Error, imatge no valida (Màxim 2MB)");
            state.url = null;
        }
    } else {
        state.url = null;
    }
}

function checkLogo() {
    if (!props.empresa.logo && !form.logo) {
        state.url = null;
    }
}

// Request form  
async function onSubmit(values) {
    let id = props.empresa.id;
    router.post(`/empresa/update/${id}`, form)
}
</script>

<template>
    <Head :title="$t(`Editar Empresa`)" />
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">{{ $t("Editar Empresa") }}</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5" method="PUT">
            <div class="form-row">
                <!--Nom empresa -->
                <div class="form-group col">
                    <label class="mb-2">{{ $t("Empresa") }}</label>
                    <Field name="nom" type="text" class="form-control" :class="{ 'is-invalid': errors.nom }"
                        v-model="form.nom" />
                    <div class="invalid-feedback">
                        {{ errors.nom }}
                    </div>
                </div>
                <!--Telèfon empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Telèfon") }}</label>
                    <Field name="telefon" type="tel" class="form-control" :class="{ 'is-invalid': errors.telefon }"
                        v-model="form.telefon" />
                    <div class="invalid-feedback">
                        {{ errors.telefon }}
                    </div>
                </div>
                <!--Web empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Web") }}</label>
                    <Field name="web" type="text" class="form-control" v-model="form.web" />
                </div>
                <!--E-mail empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("E-mail") }}</label>
                    <Field name="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }"
                        v-model="form.email" />
                    <div class="invalid-feedback">{{ errors.email }}</div>
                </div>
                <!--Població empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Població") }}</label>
                    <SearchSelect
                    name="poblacio_id"
                    v-model="form.poblacio_id"
                    :options="poblacions"
                    label="nom"
                    trackBy="id"
                    />
                </div>
                <!--Categoria empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Categoria") }}</label>
                    <Field name="categoria_id" as="select" class="form-select"
                        :class="{ 'is-invalid': errors.categoria_id }" v-model="form.categoria_id">
                        <option v-for="categoria in categories" :value="categoria.id"
                            :selected="categoria.id == empresa.categoria_id">{{ categoria.nom }} </option>
                    </Field>
                    <div class="invalid-feedback">
                        {{ errors.categoria_id }}
                    </div>
                </div>
                <!--Sector empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Sector") }}</label>
                    <Field name="sector_id" as="select" class="form-select" :class="{ 'is-invalid': errors.sector_id }"
                        v-model="empresa.sector_id">
                        <option v-for="sector in sectors" :value="sector.id" :selected="sector.id == form.sector_id">
                            {{ sector.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.sector_id }}</div>
                </div>
                <!--Logo empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Logo") }}</label>
                    <Field name="logo" type="file" class="form-control" :class="{ 'is-invalid': state.logo }" v-model="form.logo" @change="onFileChange"/>
                    <div class="invalid-feedback">
                        {{ state.logo }}
                    </div>
                    <div class="mt-2" v-if="state.url">
                        <label for="preview">Preview:</label><br>
                        <img id="preview" :src="state.url" width="100"/><br>
                        <Link v-if="empresa.logo" :href="route('empresa.removeLogo', empresa.id)" method="post" as="button" class="btn btn-danger mt-2" preserve-scroll @success="checkLogo">{{ $t("Esborrar Logo") }}</Link>
                    </div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    {{ $t("Editar Empresa") }}
                </button>
                <Link :href="route('empresa.index')" as="button" class="btn btn-secondary mr-1 me-3">{{ $t("Cancel·la") }}</Link>
            </div>
        </Form><br><br><br>
    </AuthenticatedLayout>
</template>
