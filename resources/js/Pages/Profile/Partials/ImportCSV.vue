<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    csv: null,
});
</script>

<template>
    <section>
        <header>
            <h2>{{ $t("Importar CSV") }}</h2>

            <p>
                {{ $t("Afegir empreses a la base de dades mitjançant fitxer .CSV") }}
            </p>
        </header>

        <form @submit.prevent="form.post(route('empresa.importCSV'), { preserveScroll: true })" >
            <div class="mb-3 mt-2">
                <InputLabel for="csv" value="CSV" />

                <input
                    id="csv"
                    name="csv"
                    type="file"
                    class="form-control"
                    @input="form.csv = $event.target.files[0]"
                    required
                    style="max-width: 400px;"
                    accept=".csv"
                />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <InputError class="mt-2" :message="form.errors.csv" />
            </div>

            <div >
                <PrimaryButton :disabled="form.processing" >{{ $t("Afegir") }}</PrimaryButton>
            </div>
        </form>
    </section>
</template>
