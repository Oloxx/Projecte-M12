<script setup>
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { reactive } from 'vue';

/**
 *  Data received from the controller
 */
var props = defineProps({
    collaboracio: {
        type: Object,
        required: true,
    },
    empreses: {
        type: Object,
        required: true,
    },
    contactes: {
        type: Object,
        required: true,
    },
    cicles: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
    year: {
        type: Number,
        required: true,
    },
    errors: {
        type: Object,
        required: false,
    }
});

/**
 * Validations
 */
const schema = Yup.object().shape({
    empresa_id: Yup.string().required("S'ha d'assignar una empresa a l'estada."),
    contacte_id: Yup.string().required("S'ha d'assignar un contacte a l'estada."),
    cicle_id: Yup.string().required("S'ha d'assignar un cicle a l'estada."),
    any: Yup.number("Assignar un any és obligatori."),
    comentaris: Yup.string().required(
        "S'ha d'afegir un comentari."
    ),
});

/**
 * Inputs from the controller
 */
const form = reactive({
    empresa_id: props.collaboracio.empresa_id,
    contacte_id: props.collaboracio.contacte_id,
    cicle_id: props.collaboracio.cicle_id,
    any: props.collaboracio.any,
    user: props.collaboracio.user,
    comentaris: props.collaboracio.comentaris,
});

async function scrollTop() {
    window.scroll({
        top: 100,
        behavior: "smooth",
    });
}

// Request form
async function onSubmit(values) {
    router.put(`/collaboracio/update/${props.collaboracio.id}`, form,);

    if (Object.keys(props.errors).length > 0) {
        scrollTop();
    }
}

var contactesFiltrats = reactive([]);

// Load contacts

async function ChargeContactes(empresa) {
    contactesFiltrats.length = 0;
    for (const contacte of props.contactes) {
        if (contacte.empresa_id == empresa) {
            contactesFiltrats.push(contacte);
        }
    }

    return contactesFiltrats;
}

ChargeContactes(form.empresa_id);

var anys = reactive([]);

function carregarAny() {
    anys.length = 0;

    for (let index = 1970; index < props.year; index++) {
        anys.push(index);
    }

    anys = anys.reverse();

    return anys;
}

carregarAny();
</script>

<template>
    <Head :title="$t(`Editar Estada`)" />
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">{{ $t("Editar Estada") }}</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5">
            <div class="form-row">
                <div class="serverError" v-if="Object.keys(props.errors).length > 0">
                    <ol>
                        <li v-for="item in props.errors">
                            {{ $t(item) }}
                        </li>
                    </ol>
                </div>
                <!-- Empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Empresa") }}</label>
                    <Field name="empresa_id" as="select" class="form-select" :class="{ 'is-invalid': errors.empresa_id }"
                        v-model="form.empresa_id">
                        <option v-for="empresa in empreses" :value="empresa.id">
                            {{ empresa.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.empresa_id }}</div>
                </div>
                <!-- Contacte -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Contacte") }}</label>
                    <Field name="contacte_id" as="select" class="form-select" :class="{ 'is-invalid': errors.contacte_id }"
                        v-model="form.contacte_id">
                        <template v-if="form.empresa_id === null">
                            <option value="">{{ $t("Selecciona una empresa") }}</option>
                        </template>
                        <template v-else-if="contactesFiltrats.length > 0">
                            <option v-for="contactef of contactesFiltrats" :value="contactef.id">
                                {{ contactef.nom }} {{ contactef.cognoms }}
                            </option>
                        </template>
                        <template v-else>
                            <option value="">{{ $t("Encara no hi ha contactes assignats a aquesta empresa") }}</option>
                        </template>
                    </Field>
                    <div class="invalid-feedback">{{ errors.empresa_id }}</div>
                </div>
                <!-- Cicle -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Cicle") }}</label>
                    <Field name="cicle_id" id="cicle_id" as="select" class="form-select"
                        :class="{ 'is-invalid': errors.cicle_id }" v-model="form.cicle_id">
                        <option v-for="cicle in cicles" :value="cicle.id">
                            {{ cicle.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.cicle_id }}</div>
                </div>
                <!-- Any -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Any") }}</label>
                    <Field name="any" id="any" as="select" class="form-select" :class="{ 'is-invalid': errors.any }"
                        v-model="form.any">
                        <option v-for="any in anys" :value="any">
                            {{ any }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.any }}</div>
                </div>
                <!-- User -->
                <Field name="user" type="text" class="form-control" v-model="form.user" hidden />
                <!-- Comentaris -->
                <div class="form-group col mt-3">
                    <label class="mb-2">{{ $t("Comentaris") }}</label>
                    <Field as="textarea" name="comentaris" class="form-control" :class="{ 'is-invalid': errors.comentaris }"
                        v-model="form.comentaris">
                    </Field>
                    <div class="invalid-feedback">
                        {{ errors.comentaris }}
                    </div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    {{ $t("Editar Estada") }}
                </button>
                <Link :href="route('contacte.index')" as="button" class="btn btn-secondary">{{ $t("Cancel·lar") }}</Link>
            </div>
        </Form><br><br><br>
    </AuthenticatedLayout>
</template>

<style scoped>
.serverError {
    color: rgb(202, 8, 8);
    background-color: rgb(252, 239, 183);
    border-radius: 5px;
    padding: 20px 20px 5px 10px;
    margin-bottom: 20px;
}
</style>