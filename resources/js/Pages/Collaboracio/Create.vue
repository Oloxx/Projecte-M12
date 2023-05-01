<script setup>
import { Form, Field } from "vee-validate";
import * as Yup from "yup";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'


/**
 *  Data received from the controller
 */
const props = defineProps({
    empreses: {
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
        type: Object,
        required: true,
    },
    ano: {
        type: Number,
    },
    contactes: {
        type: Object,
    }
});

/**
 * Validations
 */
const schema = Yup.object().shape({
    nom: Yup.string().required("El nom de l'usuari és obligatori"),
    cognoms: Yup.string().required("Els cognoms de l'usuari són obligatoris"),
    movil: Yup.string().matches(
        /^[0-9]{9}/,
        "El número de telèfon ha d'estar compost per nomès 9 números."
    ),
    email: Yup.string().email("El E-mail introduït és invàlid"),
    empresa_id: Yup.string().required("S'ha d'assignar una empresa a cada contacte."),
});

/**
 * Inputs from the controller
 */
const form = reactive({
    empresa_id: null,
    contacte_id: null,
    cicle_id: null,
    any: null,
    user: props.user,
    comentaris: null
})

// Request form  
async function onSubmit(values) {
    router.post('/collaboracio/store', form)
}

// Load contacts

async function changeEmpresa() {
    var ruta = "{{ route('collaboracio_getcontactes') }}";
    var empresa_id = form.empresa_id;

    props.contactes = router.get(`/collaboracio/getcontactes/${empresa_id}`);
    console.log(props.contactes);

}

</script>

<template>
    <AuthenticatedLayout>
        <h1 class="mt-5 ms-5 mb-4">Crear nova estada</h1>
        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors }" class="ms-5 me-5">
            <div class="form-row">
                <!-- Empresa -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Empresa</label>
                    <Field name="empresa_id" as="select" class="form-select" :class="{ 'is-invalid': errors.empresa_id }"
                        v-model="form.empresa_id" @change="changeEmpresa()">
                        <option v-for="empresa in empreses" :value="empresa.id">
                            {{ empresa.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.empresa_id }}</div>
                </div>
                <!-- Contacte -->
                <div class="form-group col">
                    <label class="mb-2">Contacte</label>
                    <Field name="contacte_id" id='contacte_id' as="select" class="form-select"
                        :class="{ 'is-invalid': errors.contacte_id }" v-model="form.contacte_id">
                        <template v-id="contactes > 0">
                            <option v-for="contacte in contactes" :value="contacte.id">
                            {{ contacte.nom }}
                        </option>
                        </template>
                        
                    </Field>
                    <div class="invalid-feedback">{{ errors.contacte_id }}</div>
                </div>
                <!-- Cicle -->
                <div class="form-group col">
                    <label class="mb-2">Cicle</label>
                    <Field name="cicle_id" id='cicle_id' as="select" class="form-select"
                        :class="{ 'is-invalid': errors.cicle_id }" v-model="form.cicle_id">
                        <option v-for="cicle in cicles" :value="cicle.id">
                            {{ cicle.nom }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.cicle_id }}</div>
                </div>
                <!-- Any -->
                <div class="form-group col">
                    <label class="mb-2">Any</label>
                    <Field name="any" id='any' as="select" class="form-select" :class="{ 'is-invalid': errors.any }"
                        v-model="form.any">
                        <option v-for=" n in year" :value="n">
                            {{ n }}
                        </option>
                    </Field>
                    <div class="invalid-feedback">{{ errors.any }}</div>
                </div>
                <!-- User -->
                <Field name="user" type="text" class="form-control" v-model="form.user" hidden />
                <!-- Comentaris -->
                <div class="form-group col mt-3">
                    <label class="mb-2">Comentaris</label>
                    <Field name="comentaris" type="textarea" class="form-control"
                        :class="{ 'is-invalid': errors.comentaris }" v-model="form.comentaris" />
                    <div class="invalid-feedback">
                        {{ errors.comentaris }}
                    </div>
                </div>
            </div>
            <!--Submit-->
            <div class="form-group mt-3 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary mr-1 me-3">
                    Crear Estada
                </button>
                <Link :href="route('contacte.index')" as="button" class="btn btn-secondary">Cancel·lar</Link>
            </div>
        </Form>
    </AuthenticatedLayout>
</template>
