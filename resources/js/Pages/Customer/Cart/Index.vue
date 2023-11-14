<template>
    <MainTemplate>
        <div class="cart-box">
            <table>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, ind) in cart">
                        <td scope="row">{{ ind+1 }}</td>
                        <td><img src="/product-placeholder.png" alt="" width="150"></td>
                        <td>{{ item.product.name }}</td>
                        <td>{{ item.product.category.title }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.product.price * item.quantity }}</td>
                        <td>
                            <div class="d-flex">
                                <button @click="destroy(item.id, ind)" class="delete-btn"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </td>
                    </tr>

                    <p v-if="cart.length <= 0"> No item in the cart </p>
                </tbody>
            </table>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3';
import MainTemplate from '@/MainTemplate.vue';
import { Cart, Product } from '@/Utilities/Interfaces';

interface Category {
    id: number,
    title: string,
}

interface Data extends Product{
    category: Category
}
interface Item extends Cart{
    product: Data
}

const cart: Item[] = usePage().props.cart as Item[];

function destroy(id: number, ind: number){
    if (confirm("Are you sure you want to delete this cart?")) {
        cart.splice(ind, 1);

        router.delete('/cart/delete/'+id);
    }
}
</script>

<style lang="scss" scoped>
$borderColor: rgb(191, 191, 191);
.cart-box{
    padding: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
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

.delete-btn{
    color: $dark-gray;
    background-color: transparent;
    border: none;
    outline: none;
    cursor: pointer;
    transition: .35s ease;
    padding: .5rem .75rem .5rem .75rem;

    &:hover{
        background-color: rgb(219, 219, 219);
        color: $black;
    }
}
</style>