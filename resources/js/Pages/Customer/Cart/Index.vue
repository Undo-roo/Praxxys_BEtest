<template>
    <MainTemplate>
        <div class="cart-box">

            <div class="cart-items">

                <!-- Create a vue model for this -->
                <table aria-label="Cart Items">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th style="min-width: 250px;" scope="col">Image</th>
                            <th style="min-width: 200px;" scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Quantity</th>
                            <th style="min-width: 180px;" scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, ind) in cart.items">
                            <td scope="row">{{ ind+1 }}</td>
                            <td><img src="/product-placeholder.png" alt="" width="150"></td>
                            <td>{{ item.product.name }}</td>
                            <td>{{ item.product.category.title }}</td>
                            <td style="padding-right: .5rem; padding-left: .5rem"> <Quantity @change-val="changeTotal(ind)" v-model="item.quantity" /> </td>
                            <!-- <td>{{ item.quantity }}</td> -->
                            <td>{{ item.total.toFixed(2) }}</td>
                            <td>
                                <div class="d-flex" style="justify-content: center;">
                                    <button @click="edit(item.id, ind)" class="edit-btn"><i class="fa-solid fa-edit"></i></button>
                                    <button @click="destroy(item.id, ind)" class="delete-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </td>
                        </tr>

                        <p v-if="cart.items.length <= 0"> No item in the cart </p>
                    </tbody>
                </table>
            </div>

            <div class="receipt">
                <p v-show="alert" style="font-weight: bold; color: green; margin-bottom: 1.75rem;"> Cart has been updated! </p>
                <h3 style="margin-bottom: 60px;"> Receipt </h3>

                <p> Total count of items: {{ quantity }} </p>
                <p>Overall Total: {{ total }} </p>

                <Link href="/cart/checkout"> 
                    <ButtonIcon :disabled="cart.items.length < 1" color="green" style="padding-top: .25rem; padding-bottom: .25rem; float: right" label="Checkout" />
                </Link>
            </div>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import { usePage, router, Link } from '@inertiajs/vue3';
import MainTemplate from '@/MainTemplate.vue';
import { Cart, CartItem } from '@/Utilities/Interfaces';
import ButtonIcon from '@/Components/Button.vue'
import Quantity from '@/Components/Quantity.vue'
import { computed, reactive, ref } from 'vue';

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

const alert = ref(false);

const cart: Current = reactive(usePage().props.cart as Current);
 
const total = computed (() => {
    return cart.items.reduce( (sum, { total }) => (sum + total), 0).toFixed(2);
})

const quantity = computed (() => {
    return cart.items.reduce( (sum, { quantity }) => (sum + quantity), 0)
})

function destroy(id: number, ind: number){
    if (confirm(`Are you sure you want to delete this ${cart.items[ind].product.name} Item in the cart?`)) {
        cart.items.splice(ind, 1);

        router.delete('/cart/delete/'+id, { preserveScroll: true });
    }
}

function edit(id: number, ind: number){

    router.patch('/cart/edit/'+id, {
        quantity: cart.items[ind].quantity,
    }, { preserveScroll: true, onSuccess: () => {
        alert.value = true;

        setTimeout(() => alert.value = false, 5000);
        return true;
    } }, );
    
}

function changeTotal(ind: number){
    let item = cart.items[ind];

    cart.items[ind].total = item.product.price * item.quantity
}
</script>

<style lang="scss" scoped>
$borderColor: rgb(191, 191, 191);
.cart-box{
    padding: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: flex-start;

    .receipt{
        padding: .75rem;
        background-color: rgb(250, 250, 250);
        margin-left: 1.5rem;
        flex: 1;
        box-shadow: 0px .25rem .35rem rgba($color: #000000, $alpha: .20);
        border-radius: 5px;
    }

    .cart-items{
        overflow-y: auto;
        overflow-x: hidden;
        max-height: calc(100vh - 180px);
    }
}
table{
    border: 1px solid $borderColor;
    border-radius: 2px;
    box-shadow: 0rem .25rem .25rem rgba($color: #000000, $alpha: .150);
    th{
        border-right: 1px solid $borderColor;
        // border-top: 1px solid $borderColor;
        border-bottom: 1px solid $borderColor;
        padding: 1rem;
    }
    th:last-child{
        border-right: 0px solid $borderColor;
        padding: 1rem 1.5rem 1rem 1.5rem;
    }

    td{
        text-align: center;
    }
}

.delete-btn, .edit-btn{
    color: $dark-gray;
    background-color: transparent;
    border: none;
    outline: none;
    cursor: pointer;
    transition: .35s ease;
    padding: .5rem .75rem .5rem .75rem;

    &:hover{
        background-color: rgb(219, 219, 219);
    }
}

.delete-btn{
    &:hover{
        color: rgb(237, 0, 0);
    }
}
.edit-btn{
    &:hover{
        color: rgb(238, 175, 0);
    }
}
</style>