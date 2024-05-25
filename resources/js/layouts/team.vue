<script>
  export default {
    name: 'team'
  };
</script>

<script setup>
  import "../../css/tailadmin.css";
  import "../tailadmin/spa.js";
  import TeamHeader from "./partials/TeamHeader.vue";
  import TeamSidebar from "./partials/TeamSidebar.vue";
  import AppFlashMessages from "@/components/AppFlashMessages.vue";
</script>

<template>
  <div
    x-data="{
      page: 'analytics',
      loaded: true,
      darkMode: true,
      stickyMenu: false,
      sidebarMinimized: false,
      sidebarToggle: false,
      scrollTop: false
    }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    x-bind:class="{ 'dark text-bodydark bg-boxdark-2': darkMode === true }"
  >
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <TeamSidebar />
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div id="contentWrapper" class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <!-- ===== Header Start ===== -->
        <TeamHeader />
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Alerts -->
            <AppFlashMessages />
            <!-- /Alerts -->

            <!-- Default Slot -->
            <slot></slot>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </div>
</template>
