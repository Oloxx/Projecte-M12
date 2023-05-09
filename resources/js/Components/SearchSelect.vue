<script setup>
import VueMultiselect from 'vue-multiselect';
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
    >
        <template #noResult>
            {{ $t("No s'ha trobat cap element. Prova de canviar la consulta de cerca.") }}
        </template>
    </VueMultiselect>
    
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>