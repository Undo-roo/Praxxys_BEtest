<template>
    <MainTemplate>
        <div class="checkout">
            <div class="succes-box">
                <h4>
                    Payment Success!
                </h4>

                <p>
                    We have received your payment.
                </p>
            </div>
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
.succes-box{
    padding: .75rem;
    background-color: rgb(180, 248, 180);
    margin-left: 1.5rem;
    flex: 1;
    box-shadow: 0px .25rem .35rem rgba($color: #000000, $alpha: .20);
    border-radius: 5px;
    max-width: 500px;

    h6{
        color: $dark-gray;
        
    }
}
</style>