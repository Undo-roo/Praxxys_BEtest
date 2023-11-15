<template>
    <div class="test-box">

    </div>
</template>

<script setup lang="ts">
import { Form } from './Function/Form';
const form = Form(1);

form.hello()

</script>

<style lang="scss" scoped>
.test-box{
    width: 100vw;
    height: 100vh;
    background-color: rgb(149, 149, 149);
}
</style>