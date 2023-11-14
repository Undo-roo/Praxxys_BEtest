<template>
    <MainTemplate :large="true">
        <div class="landing-page">
            
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainTemplate from '@/MainTemplate.vue'

const navigations: {label: string, route: string }[] = [
    { label: 'Home', route: '/'},
    { label: 'Order', route: '/product'},
    { label: 'Login', route: '/login'},
    { label: 'Register', route: '/register'},
]
</script>

<style lang="scss" scoped>
</style>