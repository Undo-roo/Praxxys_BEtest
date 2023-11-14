<template>
    <MainTemplate>
        PROFILE

          <Link
              class="sidebar-label"
              href="/logout" method="post"
          >
            <button class="logout-btn" >Logout</button>
          </Link>

    </MainTemplate>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainTemplate from '@/MainTemplate.vue';

</script>

<style scoped>

</style>