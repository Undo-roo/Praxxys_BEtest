<template>
    <MainTemplate>

        <!-- Create alert box -->
        <p class="message" v-if="$page.props.message">{{ $page.props.message }}</p>

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
.message{
  font-weight: bold;
  color: green;
  margin-bottom: 1rem;
}
</style>