<template>
    
    <div class="main-page">
        <MainHeader :navigations="navigations" /> 
        <slot></slot>
    </div>
</template>

<script setup lang="ts">
import MainHeader from './Components/MainHeader.vue';

const navigations: {label: string, route: string }[] = [
    { label: 'Home', route: '/'},
    { label: 'Order', route: '/product'},
]
</script>

<style lang="scss" scoped>
.main-page{
}
</style>
