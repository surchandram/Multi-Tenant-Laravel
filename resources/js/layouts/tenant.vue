<script setup>
  import '../../css/tailapp.css';
  import '../tailadmin/spa.js';

  import { Head } from '@inertiajs/vue3';
  import GuestFooter from './partials/GuestFooter.vue';
  import AppFlashMessages from '@/components/AppFlashMessages.vue';
  import AppNoticeModal from '@/components/AppNoticeModal.vue';

  import { Modal } from 'momentum-modal';
</script>

<template>
  <Head :title="$page.props.tenant.name" />

  <!-- Page Container -->
  <div
    id="page-container"
    class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100"
  >
    <!-- Page Content -->
    <main
      id="page-content"
      class="flex max-w-full flex-auto flex-col"
    >
      <!-- Alerts -->
      <AppFlashMessages custom="w-full" />
      <!-- /Alerts -->

      <!-- <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl"> -->
      <!-- Default Slot -->
      <slot></slot>
      <!-- </div> -->
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <GuestFooter />
    <!-- END Page Footer -->
  </div>
  <!-- END Page Container -->

  <!-- Modal -->
  <Modal />
  <!-- END Modal -->

  <!-- Notice Modal -->
  <AppNoticeModal />
  <!-- END Notice Modal -->
</template>
