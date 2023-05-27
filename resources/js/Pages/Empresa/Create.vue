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
    poblacions: {
        type: Object,
        required: true,
        default: () => ({}), 
    },
    categories: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object
    }
});

const { t } = useI18n();

const state = reactive({
    poblacioSelected: false,
    showPoblacioError: false,
    sectorSelected: false,
    showSectorError: false,
    url: null,
    logo: null
})

/**
 * Validations
 */
const schema = Yup.object().shape({
    nom: Yup.string().min(1, 'El nom ha de contenir mínim un caràcter').max(60, 'El nom ha de contenir màxim 60 caràcters').required("El nom de l'empresa és obligatori"),
    telefon: Yup.string('').matches(
        /^[0-9]{9}/,
        "El número de telèfon ha d'estar compost per nomès 9 números."
    ).required("El telèfon de l'empresa és obligatori"),  
    web: Yup.string('').matches(
        /^[a-zA-Z]+\.[a-zA-Z]/,
        "La Web introduïda no és valida"
    ).notRequired(),
    email: Yup.string('').email("El E-mail introduït és invàlid").notRequired(),
    categoria_id: Yup.number().required("La categoria és obligatòria"),
});  

function handleSelectPoblacio(selectedOption) {
    if (selectedOption) {
        form.poblacio_id = selectedOption.id;
        state.poblacioSelected = true;
        state.showPoblacioError = false;
    }
}

function handleClosePoblacio() {
    if (!state.poblacioSelected) {
        state.showPoblacioError = true;
    }
}

function handleSelectSector(selectedOption) {
    if (selectedOption) {
        form.sector_id = selectedOption.id;
        state.sectorSelected = true;
        state.showSectorError = false;
    }
}

function handleCloseSector() {
    if (!state.sectorSelected) {
        state.showSectorError = true;
    }
}

/**
 * Inputs from the controller
 */
const form = reactive({
    nom: null,
    telefon: null,
    web: null,
    email: null,
    poblacio_id: null,
    categoria_id: null,
    sector_id: null,
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

const serverError = reactive({ error: null, message: [] });

async function scrollTop() {
    window.scroll({
        top: 100,
        behavior: "smooth",
    });
}

function checkPoblacio() {
    if (state.poblacioSelected) {
        return true;
    } else {
        state.showPoblacioError = true;
        return false;
    }
}

function checkSector() {
    if (state.sectorSelected) {
        return true;
    } else {
        state.showSectorError = true;
        return false;
    }
}

function checks() {
    checkPoblacio();
    checkSector();
}

// Request form  
async function onSubmit() {
    checks();
    if (checkPoblacio() && checkSector() && !state.logo) {
        router.post("/empresa/store", form);
        if (Object.keys(props.errors).length > 0) {
            scrollTop();
        }
    }
}
</script>

<template>
    <Head :title="$t(`Crear Empresa`)" />
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">{{ $t("Nova Empresa") }}</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5 mb-5">
            <div class="form-row">
                <div class="serverError" v-if="serverError.error">
                    <ol>
                        <li v-for="item in serverError.message">
                            {{ $t(item) }}
                        </li>
                    </ol>
                </div>
                <!--Nom empresa -->
                <div class="form-group col">
                    <label class="mb-2">{{ $t("Empresa") }}</label>
                    <Field name="nom" type="text" class="form-control" :class="{ 'is-invalid': errors.nom }" v-model="form.nom"/>
                    <div class="invalid-feedback">
                        {{ errors.nom }}
                    </div>
                </div>
                <!--Telèfon empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Telèfon") }}</label>
                    <Field name="telefon" type="text" class="form-control" :class="{ 'is-invalid': errors.telefon }" v-model="form.telefon"/>
                    <div class="invalid-feedback">
                        {{ errors.telefon }}
                    </div>
                </div>
                <!--Web empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Web") }}</label>
                    <Field name="web" type="url" class="form-control" :class="{ 'is-invalid': errors.web }" v-model="form.web" />
                    <div class="invalid-feedback">{{ errors.web }}</div>
                </div>
                <!--E-mail empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("E-mail") }}</label>
                    <Field name="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="form.email"/>
                    <div class="invalid-feedback">{{ errors.email }}</div>
                </div>
                <!--Població empresa-->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Població") }}</label>
                    <SearchSelect
                    :values="props.poblacions"
                    @select="handleSelectPoblacio"
                    @close="handleClosePoblacio"
                    />
                    <div v-if="state.showPoblacioError" class="text-danger">
                        {{ $t("La població és obligatòria") }}
                    </div>
                </div>
                <!--Categoria empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Categoria") }}</label>
                    <Field name="categoria_id" as="select" class="form-select"
                        :class="{ 'is-invalid': errors.categoria_id }" v-model="form.categoria_id">
                        <option v-for="categoria in categories" :value="categoria.id">
                            {{ categoria.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">
                        {{ errors.categoria_id }}
                    </div>
                </div>
                <!--Sector empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Sector") }}</label>
                    <SearchSelect
                    :values="props.sectors"
                    @select="handleSelectSector"
                    @close="handleCloseSector"
                    />
                    <div v-if="state.showSectorError" class="text-danger">
                        {{ $t("El sector és obligatori") }}
                    </div>
                </div>
                <!--Logo empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Logo") }}</label>
                    <Field name="logo" type="file" class="form-control" :class="{ 'is-invalid': state.logo }" accept="image/*" @input="form.logo = $event.target.files[0]" @change="onFileChange"/>
                    <div class="invalid-feedback">
                        {{ state.logo }}
                    </div>
                    <div class="mt-2" v-if="state.url">
                        <label for="preview">Preview:</label><br>
                        <img id="preview" :src="state.url" width="100"/>
                    </div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3" @click="checks()">
                    {{ $t("Crear Empresa") }}
                </button>
                <Link :href="route('empresa.index')" as="button" class="btn btn-secondary">{{ $t("Cancel·la") }}</Link>
            </div><br>
        </Form>
    </AuthenticatedLayout>
</template>

<style scoped>
.serverError{
    color: rgb(202, 8, 8);
    background-color: rgb(252, 239, 183);
    border-radius: 5px;
    padding: 20px 20px 5px 10px;
    margin-bottom: 20px;
}
</style>