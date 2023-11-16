<template>
    <header>
        <Button @click="closeSidebar" variant="flat" :icon="{ name: 'bars'}" />
    </header>
</template>

<script setup lang="ts">
import Button from '@/Components/Button.vue';

const emits = defineEmits(['closeSidebar'])

const closeSidebar = () =>{

    emits('closeSidebar')
}

</script>

<style lang="scss" scoped>
header{
    @include boxShadowExtraSmall();
    width: 100%;
    background-color: $white;
    padding: .5rem;
    height: 55px;

    display: flex;
    align-items: center;
}
</style>