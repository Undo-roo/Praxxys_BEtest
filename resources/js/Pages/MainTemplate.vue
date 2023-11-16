<template>
    
    <div class="main-page">
        <MainHeader :large="props.large" :navigations="navigations" /> 
        <slot></slot>
    </div>
</template>

<script setup lang="ts">
import MainHeader from './Components/MainHeader.vue';

const props = defineProps({
    large: {
        type: Boolean,
        default: false,
    },
})

const navigations: {label: string, route: string }[] = [
    { label: 'Home', route: '/' },
    { label: 'Order', route: '/product' },
]
</script>

<style lang="scss" scoped>
.main-page{
}
</style>
