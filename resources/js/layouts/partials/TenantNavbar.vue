<script setup>
  import { Link } from "@inertiajs/vue3";
  import AuthNavbarSearch from "./AuthNavbarSearch.vue";
  import NotificationDropdown from "@/components/auth/NotificationDropdown.vue";
  import UserDropdown from "@/components/auth/UserDropdown.vue";
</script>

<template>
  <!-- Navbar -->
  <nav
    class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4"
  >
    <div
      class="w-full mx-auto items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <!-- Brand -->
      <a
        class="text-white text-sm uppercase hidden lg:inline-block font-semibold"
        :href="route('tenant.home')"
      >
        Dashboard
      </a>

      <!-- Form -->
      <AuthNavbarSearch />
      <!-- /Form -->

      <!-- User -->
      <ul
        class="flex-col md:flex-row list-none items-center hidden md:flex"
      >
        <!-- NotificationDropdown -->
        <NotificationDropdown class="mr-2" />
        <!-- /NotificationDropdown -->

        <!-- UserDropdown -->
        <UserDropdown />
        <!-- /UserDropdown -->
      </ul>
    </div>
  </nav>

  <!-- End Navbar -->
</template>
