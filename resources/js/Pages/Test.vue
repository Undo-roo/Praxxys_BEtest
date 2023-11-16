<template>
    <div class="test-box">

        <div class="grid">
            <Alert type="success" />
            <Alert type="primary" />
        </div>

        <div class="grid">
            <Alert type="warning" />
            <Alert type="error" />
        </div>
    </div>
</template>

<script setup lang="ts">
import Alert from './Components/Widgets/Alert.vue';


</script>

<style lang="scss" scoped>
.test-box{
    width: 100vw;
    height: 100vh;
    padding: 2rem;
    background-color: rgb(214, 214, 214);

    .grid{
        display: grid;
        grid-auto-flow: column;  
        column-gap: 1rem;
    }
}
</style>