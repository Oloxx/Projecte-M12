<script setup>

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
})

</script>

<template>
    <div v-for="item in items" :key="item.id" class="d-flex align-items-center mb-3">
        <label :for="item.id" class="me-2 fw-bold" style="width: 95px;">{{ $t(item.label) }}</label>
        <input class="form-control" type="text" :id="item.id" :value="item.value" readonly>
    </div>
    <br>
</template>
