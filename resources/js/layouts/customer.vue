<script>
  export default {
    name: "customer",
  };
</script>

<script setup>
  import { ref, onMounted, watch } from "vue";
  import "../../css/tailapp.css";
  import "../tailadmin/spa.js";
  import CustomerHeader from "./partials/CustomerHeader.vue";
  import CustomerSidebar from "./partials/CustomerSidebar.vue";
  import CustomerFooter from "./partials/CustomerFooter.vue";
  import AppFlashMessages from "@/components/AppFlashMessages.vue";

  import { Modal } from "momentum-modal";

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);

  onMounted(() => {
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit("mobile-sidebar-toggled", val);
    });

    $eventBus.on(
      "mobile-sidebar-toggled",
      (val) => (mobileSidebarOpen.value = val)
    );
    $eventBus.on("sidebar-minimized", (val) => (sidebarMinimized.value = val));
  });
</script>

<template>
  <!-- Page Container -->
  <div
    id="page-container"
    x-data="{ mobileSidebarOpen: false }"
    class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-white"
    :class="{
      'lg:pl-24': sidebarMinimized,
      'lg:pl-64': !sidebarMinimized
    }"
  >
    <!-- Page Sidebar -->
    <CustomerSidebar />
    <!-- Page Sidebar -->

    <!-- Page Header -->
    <CustomerHeader />
    <!-- END Page Header -->

    <!-- Page Content -->
    <main id="page-content" class="flex flex-col flex-auto max-w-full pt-20 lg:pt-0">
      <!-- Alerts -->
      <AppFlashMessages custom="w-full" />
      <!-- /Alerts -->

      <!-- Default Slot -->
      <slot></slot>
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <CustomerFooter />
    <!-- END Page Footer -->
  </div>
  <!-- END Page Container -->

  <!-- Modal -->
  <Modal />
  <!-- END Modal -->
</template>
