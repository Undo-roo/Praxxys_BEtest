<template>
    <header>
        <Button @click="closeSidebar" variant="flat" icon="bars" />
    </header>
</template>

<script setup>
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