<template>
    <MainTemplate>
        <div class="checkout">
            <div class="payment-methods">

                <h4 v-if="$page.props.message">
                    {{ $page.props.message }}
                </h4>
                
                <h2 style="margin-top: 10px; margin-bottom: 0px;">Pay with gcash or paymaya</h2>
                <p> <small>Upload proof of payment</small> </p>

                <form @submit.prevent="fields.post('/cart/payment')">
                    <div @click="triggerFile()" class="file-box">
                        <small><strong>{{ filename }}</strong></small>
                    </div>
                    <input hidden id="file" @change="addFile($event)" type="file" name="proofOfPayment">
                    <button class="button-submit"> Submit </button>
                </form>

                <p v-if="fields.errors.proofOfPayment" style="color: red;">{{ fields.errors.proofOfPayment }}</p>

                <div class="seperator">
                    <div class="divider"></div>
                    <p> or </p>
                    <div class="divider"></div>
                </div>

                <h2 style="margin-top: 10px;">Pay with paypal</h2>

                <a class="button-link" href="/cart/payment" target="_blank">
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
import { usePage, useForm, InertiaForm } from '@inertiajs/vue3';

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

const fields: InertiaForm <{
    proofOfPayment?: File,
    method: string,
}> = useForm({
    proofOfPayment: undefined,
    method: 'Proof'
});

const filename = ref('Select a file');

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

function triggerFile(){
    document.getElementById('file')?.click();
}

const addFile = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if(target){
        if(target.files){
            const file: File = target.files[0];

            if(file){
                filename.value = file.name
                fields.proofOfPayment = file;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.checkout{
    padding: 3rem 1.5rem 1.5rem 1.5rem;
    display: flex;
    justify-content: center;
    background-color: rgb(232, 232, 232);
    height: calc(100vh - 130px);
}

.seperator{
    display: flex;
    align-items: center;
    margin-top: 30px;
    margin-bottom: 30px;

    .divider{
        height: 1px;
        background-color: rgb(163, 163, 163);
        flex: 1;
    }
    p{
        margin: 0px .75rem 0px .75rem;
        color: rgb(93, 93, 93);
    }
}

.payment-methods{
    display: flex;
    flex-direction: column;
    background-color: white;
    box-shadow: 0px .25rem .35rem rgba($color: #000000, $alpha: .20);
    border-radius: 5px;
    align-self: flex-start;
    padding: 1.5rem 2.5rem 2.5rem 2.5rem;

    .file-box{
        width: 100%;
        border: 1px solid rgb(156, 156, 156);
        padding: .5rem .95rem .5rem .95rem;
        border-radius: 3px;
        margin-bottom: 15px;
        cursor: pointer;
    }
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
    transition: .35s ease;
    
    
    &:hover{
        background-color: rgb(220, 150, 20);
    }
}

.button-submit{
    max-width: 180px;
    width: 100%;
    padding: .5rem 1.25rem .5rem 1.25rem;
    border: none;
    border-radius: 3px;
    background-color: rgb(3, 175, 3);
    color: white;
    transition: .35s ease;
    cursor: pointer;
    
    &:hover{
        background-color: green;
    }
}
</style>