<template>
    <MainTemplate>
        <div class="show-page">
            <div class="wrapper-box">

                <section class="product-image">
                    <img :src="`/${selected}`" alt="Product Image Placeholder" width="400">
                    
                    <div class="d-flex">
                        <div @click="selectImage(ind)" v-for="(cat, ind) in cats" :class="[{ active: cat.active }, 'image-carousel']" :style="{ backgroundImage: 'url(/' + cat.dir + ')'}">
                        </div>
                    </div>
                    <!-- <CustomCarousel /> -->
                </section>

                <section class="product-details">
                    <h1>{{ product.name }}</h1>
                    <h4>₱ {{ total }}</h4>
                    <p style="max-width: 400px;">{{ product.description }}</p>

                    <Quantity v-model="fields.quantity" />
                    <form @submit.prevent="fields.post('/cart/add/'+product.id)">
                        <button class="cart-button"> <i class="fa-solid fa-cart-shopping"></i> Add to Cart </button>
                    </form>
                </section>
            </div>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import { reactive, ref, computed } from 'vue';
import MainTemplate from '@/MainTemplate.vue';
import { usePage, Link, useForm } from '@inertiajs/vue3';
import { Product, User } from '@/Utilities/Interfaces';
import Quantity from '@/Components/Quantity.vue'
// import CustomCarousel from '@/Components/CustomCarousel.vue';

const product: Product = usePage().props.product as Product;
const { id }: User = usePage().props.product as User;

const fields = useForm({
    quantity: 1,
    product_id: product.id,
    user_id: id,
});
const selected = ref('product-placeholder.png');

const total = computed( ()=> fields.quantity * product.price )


const cats = reactive([
    { dir: 'product-placeholder.png', active: true },
    { dir: '1.jpg', active: false },
    { dir: '2.jpg', active: false },
    { dir: '3.jpg', active: false },
    { dir: '4.jpg', active: false }
])

function selectImage(ind: number){
    cats.forEach( (cat) => cat. active= false );

    selected.value = cats[ind].dir;
    cats[ind].active = true;
}
</script>

<style lang="scss" scoped>
.show-page{
    padding: 1.5rem;
    background-color: rgb(232, 232, 232);

    display: flex;
    height: 100%;
    justify-content: center;
    
    .wrapper-box{
        padding: 1rem .75rem 0rem .75rem;
        border-radius: 3px;
        display: flex;
        background-color: white;
        .product-image{
            margin-right: 1.5rem;

            img{
                margin-bottom: .75rem;
            }
            .image-carousel{
                width: 50px;
                height: 50px;
                margin-right: .5rem;
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
                cursor: pointer;
            }
        }

        .product-details{

            .cart-button{
                margin-top: 1.5rem;
                border: 1px solid black;
                outline: none;
                padding: .35rem 1.5rem .35rem 1.5rem;
                background-color: $dark-gray;
                color: $white;
                border-radius: 2px;
                cursor: pointer;
            }
        }
    }
}
</style>