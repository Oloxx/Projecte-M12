<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    }
});

</script>

<template>
    <div
        v-if="data.links.length > 3"
        class="container-fluid d-flex justify-content-end mt-4 space-x-4 end-0"
    >
        <Link
            v-for="(link, k) in data.links"
            v-if="k != 0 || k != data.links.length"
            name="link"
            :key="k"
            class="linkPaginator px-3 py-2 text-sm leading-4 rounded hover:bg-white focus:text-indigo-500 hover:shadow"
            :class="{ 'bg-indigo-400 text-white': link.active }"
            :href="link.url"
            v-html="link.label"
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
