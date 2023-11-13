<template>

    <Link v-if="!props.dropdown" :class="[{active: props.active}, 'sidebar-btn d-flex']" :href="props.link">
      <i :class="`fa-${props.icon?.type ?? 'solid'} fa-${props.icon?.name}`"></i>
      <p class="btn-label"> {{ props.label }}</p>
    </Link>

    <div v-else :class="[{open: open}, 'dropdown-box']">
        <button :class="[{active: props.active}, 'dropdown-btn']" @click="open = !open">
            <div class="dropdown-content d-flex">
                <i :class="`fa-${props.icon?.type ?? 'solid'} fa-${props.icon?.name}`"></i>
                <p class="btn-label"> {{ props.label }}</p>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </button>

        <div class="dropdown-menu">
            
            <Link v-for="menuLink in menuLinks" :class="[{active: $page.component == menuLink.component}, 'dropdown-link d-flex']" :href="menuLink.link">
                <i :class="`fa-${ $page.component == menuLink.component ? 'solid' : 'regular'} fa-square`"></i>
                <p class="btn-label"> {{ menuLink.label }}</p>
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Icon, MenuLinks } from '@/Utilities/Interfaces';

interface SidebarMenu{
    label: string,
    icon?: Icon,
    active?: boolean,
    dropdown?: boolean,
    link?: string,
    menuLinks?: MenuLinks[]
}

const props = withDefaults( defineProps<SidebarMenu>(), {
    active: false,
    dropdown: false,
    link: '#',
})

let open = ref(props.active)
</script>

<style lang="scss" scoped>
@mixin baseStats(){
    background-color: transparent;
    color: rgb(255, 218, 218);
    transition: .3s ease-out;
    text-decoration: none;
    border: none;
    outline: none;
    padding: .65rem 1.35rem .65rem 1.35rem;
    cursor: pointer;
    width: 100%;
    border-radius: 4px;

    &:hover{
        background-color: #dfa8a83a;
    }

    &.active{
        background-color: white;
        font-weight: bold;
        color: rgba($color: #9c0f1e, $alpha: .80);
    }

    .btn-label{
        margin: 0px;
        margin-left: 1rem;
        @include sidebarText();
    }
}

.sidebar-btn{
    margin-top: .5rem;
    font-size: 15px;
    @include baseStats();
}

.dropdown-box{
    margin-top: .5rem;

    &.open{
        .dropdown-btn .fa-chevron-down{
            transform: rotate(0deg);
        }

        .dropdown-menu{
            height: max-content;
            margin-top: .35rem;
        }
    }

    .dropdown-btn{
        @include baseStats();
        .fa-chevron-down{
            transition: all ease .25s;
            margin-left: auto;
            transform: rotate(90deg);
        }
    }

    .dropdown-menu{
        width: 100%;
        overflow: hidden;
        height: 0px;
        transition: all ease .25s;

        .dropdown-link{
            @include baseStats();
            margin-top: .25rem;

            &:hover{
                color: white;
                background-color: #dfa8a83a !important;
            }
            &.active{
                color: rgba($color: #9c0f1e, $alpha: .80);
                background-color: rgba($color: $white, $alpha: .6);
            }
        }
    }

}
</style>