<template>
    <div>
        PROFILE

          <Link
              class="sidebar-label"
              href="/logout" method="post"
          >
            <button class="logout-btn" >Logout</button>
          </Link>

    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

</script>

<style scoped>

</style>