<script setup>
  import { Head } from '@inertiajs/vue3';
  import BackToTop from 'vue-backtotop';
  import AccountSidebar from './partials/AccountSidebar.vue';
  import AppNavbar from './partials/AppNavbar.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppFlashMessages from '@/components/AppFlashMessages.vue';

  import { Modal } from 'momentum-modal';

  import '../../css/app.css';
  import '../tailadmin/spa.js';
</script>

<template>
  <Head title="Account" />

  <div class="w-full min-h-screen relative">
    <header class="mb-12 bg-slate-50 dark:bg-slate-900 sticky">
      <AppNavbar>
        <template #start>
          <AppLightButton
            class="md:hidden mr-2"
            @click="$eventBus.emit('show-mobile-sidebar')"
          >
            <i class="bi bi-list text-3xl leading-none"></i>
          </AppLightButton>
        </template>
      </AppNavbar>
    </header>
    <!-- END Header -->

    <AppFlashMessages
      :custom="['w-10/12 max-w-7xl px-6 md:px-12 mx-auto', $page.props.flash ? 'mb-12' : ''].join(' ')"
    />

    <div class="container px-6 md:px-12 pb-12 mx-auto">
      <!-- Main -->
      <main>
        <div class="flex flex-col md:flex-row md:gap-8">
          <!-- Account Sidebar -->
          <AccountSidebar />
          <!-- END Account Sidebar -->

          <!-- Content Section -->
          <div class="flex-1">
            <slot></slot>
          </div>
        </div>
      </main>
    </div>

    <!-- Modal -->
    <Modal />
    <!-- END Modal -->

    <back-to-top
      text="Back to top"
      visibleoffset="500"
    >
      <AppButton type="button">
        <i class="bi bi-chevron-up"></i>
      </AppButton>
    </back-to-top>
  </div>
</template>
