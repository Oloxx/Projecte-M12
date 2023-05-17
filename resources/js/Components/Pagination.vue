<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { useI18n } from "vue-i18n";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    }, 
    search: {
        type: Boolean
    } 
});

const { t } = useI18n();

const filteredLinks = computed(() => {
    const array = props.data.links.filter((link, index) => index !== -1 && index !== props.data.links.length);

    for (let i = 0; i < array.length; i++) {
        if (array[i].label === '&laquo; Previous'){
            array[i].label = "&laquo; " + t("Previous");
        }
        if (array[i].label === 'Next &raquo;') {
            array[i].label = t("Next") + " &raquo;";
        }
    }

    return array;
});

const method = props.search ? 'post' : 'get';

</script>

<template>
    <div
        v-if="data.links.length > 3"
        class="container-fluid d-flex justify-content-end mt-4 space-x-4 end-0"
    >
        <Link
            v-for="(link, index) in filteredLinks" 
            as="button"
            :method="method"
            :key="index"
            name="link"
            class="linkPaginator px-3 py-2 text-sm leading-4 rounded hover:bg-white focus:text-indigo-500 hover:shadow"
            :class="{ 'bg-indigo-400 text-light': link.active }"
            :href="link.url !== null ? link.url : ''"
            v-html="link.label"
            preserveScroll
        /> 
    </div>
</template>


<style scoped>
.linkPaginator {
    background-color: rgb(230, 228, 228);
    color:rgb(22, 99, 177);
    margin: 3px;
    text-decoration: none;
    border:none;
}

@media screen and (max-width: 850px){
    .linkPaginator{
        display: none;
    }

    .linkPaginator:nth-child(1){
        display: block;
    }
    .linkPaginator:last-child{
        display: block;
    }
}
</style>
