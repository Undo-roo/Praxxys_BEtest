<template>
    <MainTemplate>
        <div class="filter-box">
            
        </div>
        <div class="product-page">
            
            <div class="wrapper">
                <div class="product-box" v-for="item in pagination.data">
                    <img src="/product-placeholder.png" alt="Alt Product Image" width="150">
                    <p class="name">{{ item.name }}</p>

                    <div class="d-flex">
                        <span> ₱ {{ item.price }} </span>
                        <Link :href="item.path ?? ''"> More details </Link>
                    </div>
                </div>
            </div>

            <div class="d-flex link-holder">
                <Link 
                    v-for="link in pagination.links" :class="{ active: link.active }"
                    :href="link.url"  disabled
                >
                    <span v-html="link.label"></span>
                </Link>    
            </div>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue'
import { usePage, Link } from '@inertiajs/vue3';
import { Product } from '@/Utilities/Interfaces';
import { Pagination } from '@/Utilities/Type/Pagination';

console.log(usePage().props.pagination);

interface Data extends Pagination{
    data: Product[],
}

const pagination: Data = usePage().props.pagination as Data;

// console.log(products);
</script>

<style lang="scss" scoped>
.product-page{
    padding: 1.5rem;

    .wrapper{

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

    .link-holder{
        align-self: center;
        padding: .5rem;

        a{
            text-decoration: none;
            padding: .25rem .5rem .25rem .5rem;
            font-weight: bold;
            font-size: 12px;
            background-color: white;
            border: 1px solid gray;
            color: black;
            outline: none;
            
            &.active{
                background-color: #303030;
                color: $white;
                border: 0px;
            }

            &:disabled{
                border: none;
                background-color: gray !important;
            }
        }
    }
}
</style>