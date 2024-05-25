<script setup>
  import HeaderUserDropdown from "@/components/admin/HeaderUserDropdown.vue";
</script>

<template>
  <header id="page-header" class="flex items-center flex-none h-20 bg-slate-100 lg:bg-slate-50">
    <div class="container flex justify-between px-4 mx-auto lg:px-8 xl:max-w-7xl">
      <!-- Left Section -->
      <div class="flex items-center space-x-2">
        <!-- Toggle Sidebar on Mobile -->
        <button
          type="button"
          class="inline-flex items-center justify-center lg:hidden space-x-2 rounded border border-slate-300 bg-white px-2 py-1.5 font-semibold leading-6 text-slate-800 shadow-sm hover:border-slate-300 hover:bg-slate-100 hover:text-slate-800 hover:shadow focus:outline-none focus:ring focus:ring-slate-500 focus:ring-opacity-25 active:border-white active:bg-white active:shadow-none"
          @click="$eventBus.emit('mobile-sidebar-toggled', true)"
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
      <div class="flex items-center lg:hidden lg:mr-auto space-x-2">
        <!-- Brand -->
        <a
          :href="route('home')"
          class="inline-flex items-center space-x-2 text-lg font-bold tracking-wide transition text-slate-800 hover:opacity-75 active:opacity-100"
        >
          <div class="w-4">
            <img v-if="$page.props.logoData['small']" :src="$page.props.logoData['small']" alt="" class="w-4">
            <span v-else class="text-2xl leading-none font-semibold"><i class="bi bi-cart3"></i></span>
          </div>

        </a>
        <!-- END Brand -->
      </div>
      <!-- END Middle Section -->

      <!-- Right Section -->
      <div class="flex items-center space-x-2">
        <!-- User Dropdown -->
        <HeaderUserDropdown class="z-40" />
        <!-- END User Dropdown -->
      </div>
      <!-- END Right Section -->
    </div>
  </header>
</template>
