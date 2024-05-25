<script setup>
  import '../../css/app.css';
  import AppFooter from './partials/AppFooter.vue';
  import AppNavbar from './partials/AppNavbar.vue';

  import { Modal } from 'momentum-modal';
</script>

<template>
  <div class="w-full min-h-screen relative">
    <AppNavbar />

    <div class="w-full">
      <slot />
    </div>

    <!-- Modal -->
    <Modal />
    <!-- END Modal -->

    <AppFooter />
  </div>
</template>
