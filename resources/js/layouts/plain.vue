<script>
  export default {
    name: "plain",
  };
</script>

<script setup>
  import { ref, onMounted, watch } from "vue";
  import "../../css/tailapp.css";
  import "../tailadmin/spa.js";
  import GuestFooter from "./partials/GuestFooter.vue";
  import AppFlashMessages from "@/components/AppFlashMessages.vue";

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(true);

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
    class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100"
  >
    <!-- Page Content -->
    <main id="page-content" class="flex max-w-full flex-auto flex-col">
      <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <!-- Alerts -->
        <AppFlashMessages />
        <!-- /Alerts -->

        <!-- Default Slot -->
        <slot></slot>
      </div>
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <GuestFooter />
    <!-- END Page Footer -->
  </div>
  <!-- END Page Container -->
</template>
