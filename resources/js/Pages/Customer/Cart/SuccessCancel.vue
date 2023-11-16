<template>
    <MainTemplate>
        <div class="checkout">
            <div v-if="isSuccess" class="message-box">
                <img src="/paypal-logo.png" alt="paypal logo" width="150">
                <p>
                    <span class="success">Success</span> checkout payment! if you want to contiue shopping press the button below
                </p>

                <Link href="/product">
                    <ButtonIcon class="btn" label="Return to order page" />
                </Link>
            </div>

            <div v-else class="message-box">
                <img src="/paypal-logo.png" alt="paypal logo" width="150">
                <p>
                    Checkout payment has been <span class="error">Cancelled</span>! 
                    Press the button below to return to your cart list page
                </p>

                <Link href="/product">
                    <ButtonIcon class="btn" label="Return to cart list page" />
                </Link>
            </div>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue';
import ButtonIcon from '@/Components/Button.vue';
import { usePage, Link } from '@inertiajs/vue3';

const isSuccess = usePage().props.success;
</script>

<style lang="scss" scoped>
.checkout{
    padding: 1.5rem;
    padding-top: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.message-box{
    padding: .75rem;
    background-color: rgb(238, 238, 238);
    margin-left: 1.5rem;
    flex: 1;
    border-radius: 5px;
    max-width: 500px;

    h6{
        color: $dark-gray;
    }

    .btn{
        padding: .95rem 1.5rem .95rem 1.5rem;
        background-color: #005EA6;
        margin-top: 3rem;

        &:hover{
            background-color: #003d6b;
        }
    }
}

.success, .error{
    font-weight: bold;
}
.success{
    color: green;
}
.error{
    color: red;
}

a{
    text-decoration: none;
}
</style>