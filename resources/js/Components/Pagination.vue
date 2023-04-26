<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    }
});

const filteredLinks = computed(() => {
    return props.data.links.filter((link, index) => index !== -1 && index !== props.data.links.length);
});
</script>

<template>
    <div
        v-if="data.links.length > 3"
        class="container-fluid d-flex justify-content-end mt-4 space-x-4 end-0"
    >
        <Link
            v-for="(link, index) in filteredLinks" 
            :key="index"
            name="link"
            class="linkPaginator px-3 py-2 text-sm leading-4 rounded hover:bg-white focus:text-indigo-500 hover:shadow"
            :class="{ 'bg-indigo-400 text-white': link.active }"
            :href="link.url !== null ? link.url : ''"
            v-html="link.label"
            preserveScroll
        />
    </div>
</template>

<style scoped>
.linkPaginator {
    background-color: rgb(230, 228, 228);
    margin: 3px;
    text-decoration: none;
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
