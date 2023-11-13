<template>
    <header :class="{ large: props.large }">
        <nav>
            <Link :class="{ active: navigation.route === $page.url}" v-for="navigation in props.navigations" :href="navigation.route">{{ navigation.label }}</Link>
        </nav>

        <img src="/logo-placeholder.png" alt="Logo place holder" height="50">

        <nav>
            <Link :class="{ active: '/cart' === $page.url}" :href="'#'"> <i class="fa-solid fa-cart-shopping" style="margin-right: .35rem;"></i> Cart</Link>
            <Link :class="{ active: '/login' === $page.url}" :href="'/login'">Login</Link>
        </nav>
    </header>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface MainHeader{
    navigations: {label: string, route: string }[],
    large?: boolean,
}

const props = withDefaults( defineProps<MainHeader>(), {
    large: false,
})

console.log(props.navigations)
</script>

<style scoped lang="scss">
header{
    display: flex;
    justify-content: space-between;
    background-color: #EEF1F5;
    padding: 50px 25px 0px 35px;
    height: 130px;

    a {
        text-decoration: none;
        margin-right: 1.5rem;
        font-weight: bold;
        color: #1E2C78;

        &.active, &:hover{
            color: #7714B4;
            text-decoration: underline;
            text-underline-offset: 4px;
            text-decoration-thickness: 2px;
        }
    }
}

.large{
    height: 300px;
}
</style>