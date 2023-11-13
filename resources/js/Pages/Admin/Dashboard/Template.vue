<template>
    <div class="dashboard">
        <Sidebar 
            :close="close" :avatar="{name: avatarName}" :logo="{ name: 'Label Logo' }"
            :navigations="navigations"
        />

        <div class="content-box">
            <Header @close-sidebar="close = !close" />
            <div class="content">
                <slot></slot>
            </div>
        </div>

        <div  @click="triggerClose" :class="[{open: close}, 'dark-box']"></div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Sidebar from './Parts/Sidebar.vue'
import Header from './Parts/Header.vue'
import { usePage } from '@inertiajs/vue3' 
import { Navigations, User } from '@/Utilities/Interfaces'


let close = ref(false);

// let avatarName = 'Andrew Dacumos';

let user: User = usePage().props.user as User;
let avatarName: string = user.name as string

const triggerClose = () =>{
    if(screen.width < 934){
        console.log(close.value)
        if(close.value){
            close.value = false;
        }
    }
}

const navigations: Navigations[] = [
    {
        button: true,
        label: 'Dashboard',
        icon: 'gauge',
        link: '/admin/dashboard/widgets',
    },
    {
        label: 'Exam',
    },
    {
        dropdown: true,
        label: 'Product',
        icon: 'box',
        prefix: '/admin/product',
        menuLinks: [
            {
                link: '/product',
                label: 'List', 
                component: 'Product/Index',
            },
            {
                link: '/product/create',
                label: 'Create', 
                component: 'Product/Create',
            }
        ],
    },
    {
        button: true,
        label: 'Video Bonus',
        icon: 'file-video',
        fontType: 'regular',
    }
]
</script>

<style lang="scss" scoped>
.dashboard{
    display: flex;

    .content-box{
        flex: 1;
        max-height: 100vh;
        background-color: #F6EAEB;
        overflow-y: auto;

        .content{
            width: 100%;
            padding: 1.25rem;
        }
    }

    .dark-box{
        display: none;
        position: fixed;
        background-color: rgba($color: #000000, $alpha: .15);
        width: 100vw;
        height: 100vh;
        z-index: 5;
    }
}

@media screen and (min-width: 0px) and (max-width: 933px) {
    .dark-box{
        display: block;
        
        &.open{
            display: block;
        }
    }
}
</style>