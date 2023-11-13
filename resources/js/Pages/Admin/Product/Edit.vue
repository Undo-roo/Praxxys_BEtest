<template>
    <CreateEdit :product="product" location='Product/Edit' link="update">
    
    </CreateEdit>
</template>

<script setup lang="ts">
import CreateEdit from './Parts/CreateEdit.vue'
import { usePage } from '@inertiajs/vue3';
import { Product } from '@/Utilities/Classes';

const product: Product = usePage().props.product as Product;
</script>