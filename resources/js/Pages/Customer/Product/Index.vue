<template>
    <MainTemplate>
        <div class="filter-box">
            
        </div>
        <div class="product-page">
            
            <div class="product-box" v-for="product in products">
                <img src="/product-placeholder.png" alt="Alt Product Image" width="150">
                <p class="name">{{ product.name }}</p>

                <div class="d-flex">
                    <span> ₱ {{ product.price }} </span>
                    <Link :href="product.path ?? ''"> More details </Link>
                </div>
            </div>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue'
import { usePage, Link } from '@inertiajs/vue3';
import { Product } from '@/Utilities/Interfaces';

const products: Product[] = usePage().props.products as Product[];

// console.log(products);
</script>

<style lang="scss" scoped>
.product-page{
    padding: 1.5rem;

    display: flex;
    flex-wrap: wrap;

    .product-box{
        width: 260px;
        display: flex;
        flex-direction: column;
        padding: 2rem 1.5rem 2rem 1.5rem;
        border-radius: 3px;
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 1.5rem;
        box-shadow: 0px 0px .25rem rgba($color: #000000, $alpha: .3);

        img{
            margin-right: auto;
            margin-left: auto;
            margin-bottom: .75rem;
        }

        .name{
            font-weight: bold;
            margin: none;
        }

        a{
            border: 0px;
            outline: none;
            background-color: #1D7398;
            color: white;
            padding: 3px 10px 3px 10px;
            border-radius: 2px;
            margin-left: auto;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: .25s ease;

            &:hover{
                background-color: #0a4862;
            }
        }
    }
}
</style>