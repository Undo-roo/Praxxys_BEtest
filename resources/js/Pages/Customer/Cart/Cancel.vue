<template>
    <MainTemplate>
        <div class="checkout">
            Payment Cancelled!
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue';
</script>

<style lang="scss" scoped>
.checkout{
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
}

.button-link{
    border-radius: 2px;
    background-color: rgb(252, 174, 29);
    color: white;
    text-decoration: none;
    display: flex;
    justify-content: center;
    max-width: 180px;
}
</style>