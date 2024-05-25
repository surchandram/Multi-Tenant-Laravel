<script setup>
  import "../../css/auth.css";
  import AppNavigation from '@/layouts/partials/AppNavigation.vue';
  import AppFooter from '@/layouts/partials/AppFooter.vue';
</script>

<template>
  <div class="max-w-screen min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <!-- Navigation -->
    <AppNavigation />

    <!-- Main -->
    <main>
      <slot></slot>
    </main>

    <!-- Footer -->
    <AppFooter />
  </div>
</template>

<script>
export default {
  name: 'Default',
};
</script>
