<template>
    <MainTemplate>
        <div class="checkout">
            <div class="payment-methods">

                <h4 v-if="$page.props.message">
                    {{ $page.props.message }}
                </h4>
                
                <h2 style="margin-top: 10px;">Pay with gcash or paymaya</h2>
                <p> Upload proof of payment </p>

                <form action="/cart/image">
                    <input type="file">
                    <button> Submit </button>
                </form>

                or
                <h2 style="margin-top: 80px;">Pay with paypal</h2>

                <a class="button-link" href="/cart/paypal" target="_blank">
                    <img src="/paypal-logo.png" alt="lmao" width="80">
                </a>
            </div>
            
            <div class="receipt">
                <h3 style="margin-bottom: 60px;"> Receipt </h3>
                <p v-for="item in cart.items" style=" margin-bottom: 1.5rem;"><strong>{{ item.product.name }}</strong> <small>x {{ item.quantity }}</small> <em style="float: right;">{{ item.total }}</em></p>
                <p style="margin: .5rem;"> Total count of items: {{ quantity }} </p>
                <p style="margin: .5rem;">Overall Total: <small><strong>₱ {{ total }}</strong></small> </p>

            </div>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue';
import { Cart, CartItem } from '@/Utilities/Interfaces';
import { computed, reactive, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

interface Item extends CartItem{
    product: {
        name: string,
        price: number,
        id: number
        category: {
            id: number,
            title: string,
        }
    }
}

interface Current extends Cart{
    items: Item[]
}

const cart: Current = reactive(usePage().props.cart as Current);
const total = computed (() => {
    return cart.items.reduce( (sum, { total }) => (sum + total), 0).toFixed(2);
})

const quantity = computed (() => {
    return cart.items.reduce( (sum, { quantity }) => (sum + quantity), 0)
})
</script>

<style lang="scss" scoped>
.checkout{
    padding: 3rem 1.5rem 1.5rem 1.5rem;
    display: flex;
    justify-content: center;
    background-color: rgb(232, 232, 232);
    height: calc(100vh - 130px);
}

.payment-methods{
    display: flex;
    flex-direction: column;
    background-color: white;
    box-shadow: 0px .25rem .35rem rgba($color: #000000, $alpha: .20);
    border-radius: 5px;
    align-self: flex-start;
    padding: 1.5rem 2.5rem 2.5rem 2.5rem;
}
.receipt{
    padding: 1.5rem;
    background-color: rgb(250, 250, 250);
    margin-left: 1.5rem;
    flex: 1;
    box-shadow: 0px .25rem .35rem rgba($color: #000000, $alpha: .20);
    border-radius: 5px;
    align-self: flex-start;
    max-width: 500px;
    margin-left: 100px;
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