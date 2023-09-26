<template>
    <CreateEdit :product="product" location='Product/Edit' link="update">
    
    </CreateEdit>
</template>

<script setup>
import CreateEdit from './Parts/CreateEdit.vue'
import { usePage } from '@inertiajs/vue3';

const product = usePage().props.product;
</script>