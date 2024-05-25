<script setup>
  import { ref, onMounted, watch } from 'vue';
  import { Link } from '@inertiajs/vue3';
  import HeaderUserDropdown from "@/components/customer/HeaderUserDropdown.vue";

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);

  onMounted(() => {
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit('mobile-sidebar-toggled', val);
    });

    $eventBus.on('mobile-sidebar-toggled', (val) => mobileSidebarOpen.value = val);
    $eventBus.on('sidebar-minimized', (val) => sidebarMinimized.value = val);
  });
</script>

<template>
  <header
    id="page-header"
    class="fixed top-0 left-0 right-0 z-30 flex items-center flex-none h-20 bg-white shadow-sm lg:hidden"
  >
    <div
      class="container flex justify-between px-4 mx-auto lg:px-8 xl:max-w-7xl"
    >
      <!-- Left Section -->
      <div class="flex items-center space-x-2">
        <!-- Toggle Sidebar on Mobile -->
        <button
          type="button"
          class="inline-flex items-center justify-center space-x-2 rounded border border-slate-300 bg-white px-2 py-1.5 font-semibold leading-6 text-slate-800 shadow-sm hover:border-slate-300 hover:bg-slate-100 hover:text-slate-800 hover:shadow focus:outline-none focus:ring focus:ring-slate-500 focus:ring-opacity-25 active:border-white active:bg-white active:shadow-none"
          @click="mobileSidebarOpen = true"
        >
          <svg
            class="inline-block w-5 h-5 hi-solid hi-menu-alt-1"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
        <!-- END Toggle Sidebar on Mobile -->
      </div>
      <!-- END Left Section -->

      <!-- Middle Section -->
      <div class="flex items-center space-x-2">
        <!-- Brand -->
        <Link
          :href="route('tenant.customers.portal.dashboard')"
          class="inline-flex items-center space-x-2 text-lg font-bold tracking-wide transition text-slate-800 hover:opacity-75 active:opacity-100"
        >
          <svg
            class="inline-block w-4 h-4 text-blue-600 bi bi-window-sidebar"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"
            />
            <path
              d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v2H1V3a1 1 0 0 1 1-1h12zM1 13V6h4v8H2a1 1 0 0 1-1-1zm5 1V6h9v7a1 1 0 0 1-1 1H6z"
            />
          </svg>
          <span>
            <span class="font-medium text-blue-600">{{ $page.props.tenant.name }}</span>
          </span>
        </Link>
        <!-- END Brand -->
      </div>
      <!-- END Middle Section -->

      <!-- Right Section -->
      <div class="flex items-center space-x-2">
        <!-- Settings -->
        <HeaderUserDropdown />
        <!-- END Toggle Sidebar on Mobile -->
      </div>
      <!-- END Right Section -->
    </div>
  </header>
</template>
