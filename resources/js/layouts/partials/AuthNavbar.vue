<script setup>
  import { Link } from "@inertiajs/vue3";
  import AuthNavbarSearch from "./AuthNavbarSearch.vue";
  import SidebarToggler from "@/components/tailadmin/SidebarToggler.vue";
  import NotificationDropdown from "@/components/auth/NotificationDropdown.vue";
  import UserDropdown from "@/components/auth/UserDropdown.vue";
  import AppButton from "@/components/AppButton.vue";
</script>

<template>
  <!-- Navbar -->
  <header
    class="
      sticky
      top-0
      z-999
      flex
      w-full
      bg-white
      drop-shadow-1
      dark:bg-boxdark
      dark:drop-shadow-none
    "
  >
    <div
      class="
        flex
        flex-grow
        items-center
        justify-between
        py-4
        px-4
        shadow-2
        md:px-6
        2xl:px-11
      "
    >
      <SidebarToggler />
      <!-- Brand -->
      <a
        class="
          text-white
          text-sm
          uppercase
          hidden
          lg:inline-block
          font-semibold
        "
        :href="route('dashboard')"
      >
        Dashboard
      </a>

      <!-- Stop Impersonating -->
      <div
        v-if="$page.props.auth.impersonating"
        class="lg:ml-3"
      >
        <AppButton
          as="button"
          class="inline-flex items-center"
          method="delete"
          :href="route('admin.users.impersonate.destroy')"
        >
          Stop Impersonating
        </AppButton>
      </div>

      <!-- Form -->
      <AuthNavbarSearch />
      <!-- /Form -->

      <!-- User -->
      <ul
        class="
          flex
          flex-row
          items-center
          gap-2
          ml-auto
          list-none
        "
      >
        <!-- NotificationDropdown -->
        <NotificationDropdown />
        <!-- /NotificationDropdown -->

        <!-- UserDropdown -->
        <UserDropdown />
        <!-- /UserDropdown -->
      </ul>
    </div>
  </header>
  <!-- End Navbar -->
</template>
