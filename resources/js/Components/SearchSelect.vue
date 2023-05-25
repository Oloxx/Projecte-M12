<script setup>
import { ref } from 'vue';
import VueMultiselect from 'vue-multiselect';

const props = defineProps({
    values: {
        type: Object,
        required: true,
    },
    value:{
        type: String,
        default: null
    }
});

const options = ref(props.value ?? '');

function removeDiacritics(text) {
    return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

function normalizedContains(needle, haystack) {
    const regExp = new RegExp(removeDiacritics(needle), 'gi');
    return regExp.test(removeDiacritics(haystack));
}

const fullOptions = Object.values(props.values).map((item) => item.nom);;
const filteredOptions = ref(fullOptions);

const searchChange = (search) => {
    filteredOptions.value = search
        ? fullOptions.filter((option) => normalizedContains(search, option))
        : fullOptions;
};
</script>

<template>
    <VueMultiselect
    :allow-empty="false"
    :close-on-select="true"
    :clear-on-select="false"
    selectLabel=""
    selectedLabel=""
    deselectLabel=""
    placeholder=""
    v-model="options"
    :options="filteredOptions" 
    :internal-search="false"
    @search-change="searchChange" 
    >
        <template #noResult>
            {{ $t("No s'ha trobat cap element. Prova de canviar la consulta de cerca.") }}
        </template>
    </VueMultiselect>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>