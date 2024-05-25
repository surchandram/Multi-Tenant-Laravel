<script>
  export default {
    name: "customer_auth",
  };
</script>

<script setup>
  import { ref, onMounted, watch } from "vue";
  import "../../css/tailapp.css";
  import "../tailadmin/spa.js";
  import CustomerFooter from "./partials/CustomerFooter.vue";
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
    <!-- Page Header -->
    <header id="page-header" class="z-1 flex flex-none items-center">
      <div class="container mx-auto px-4 lg:px-8 xl:max-w-7xl">
        <div class="flex justify-between border-b-2 border-slate-200/50 py-6">
          <!-- Left Section -->
          <div class="flex items-center">
            <!-- Logo -->
            <a
              :href="route('tenant.index')"
              class="text-md group inline-flex items-center space-x-1 font-bold tracking-wide text-slate-700 hover:text-indigo-600 active:text-slate-700 sm:text-lg"
            >
              <svg
                class="hi-mini hi-square-3-stack-3d inline-block h-5 w-5 rotate-90 text-indigo-500"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  d="M3.196 12.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 12.87z"
                />
                <path
                  d="M3.196 8.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 8.87z"
                />
                <path
                  d="M10.38 1.103a.75.75 0 00-.76 0l-7.25 4.25a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.76 0l7.25-4.25a.75.75 0 000-1.294l-7.25-4.25z"
                />
              </svg>
              <span>{{ $page.props.tenant.name }}</span>
            </a>
            <!-- END Logo -->
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
          <div class="flex items-center space-x-1 lg:space-x-5">
            <!-- Header Navigation -->
            <nav class="flex items-center space-x-2">
              <a
                :href="route('tenant.index')"
                class="group flex items-center justify-between rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100 sm:space-x-2"
              >
                <span
                  class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-indigo-200 bg-indigo-50 text-indigo-900"
                >
                  <i class="bi bi-x-lg"></i>
                </span>
              </a>
            </nav>
            <!-- END Header Navigation -->

            <!-- User Dropdown -->
            <!-- END User Dropdown -->

            <!-- Toggle Mobile Navigation -->
            <div class="lg:hidden"></div>
            <!-- END Toggle Mobile Navigation -->
          </div>
          <!-- END Right Section -->
        </div>

        <!-- Mobile Navigation -->
        <!-- END Mobile Navigation -->
      </div>
    </header>
    <!-- END Page Header -->

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
    <CustomerFooter />
    <!-- END Page Footer -->
  </div>
  <!-- END Page Container -->
</template>
