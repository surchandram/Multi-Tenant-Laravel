<script setup>
  import { watch, ref, onMounted } from "vue";
  import { Link } from "@inertiajs/vue3";
  import { vOnClickOutside } from "@vueuse/components";
  import SidebarLink from "@/components/tailapp/SidebarLink.vue";
  import AppLanguageSelector from "@/components/AppLanguageSelector.vue";

  const props = defineProps({
    minimized: {
      type: Boolean,
      default: false,
    },
  });

  const logoutForm = ref(null);
  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(props.minimized);
  const minimizedInitState = ref(props.minimized);

  const closeMobileSidebar = () => {
    mobileSidebarOpen.value = false;

    if (minimizedInitState.value) {
      sidebarMinimized.value = minimizedInitState.value;
    }
  };

  onMounted(() => {
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit("mobile-sidebar-toggled", val);

      if (val) {
        sidebarMinimized.value = false;
      } else {
        sidebarMinimized.value = minimizedInitState.value;
      }
    });

    watch(sidebarMinimized, (val) => {
      $eventBus.emit("sidebar-minimized", val);
    });

    $eventBus.on(
      "mobile-sidebar-toggled",
      (val) => (mobileSidebarOpen.value = val)
    );
  });
</script>

<template>
  <nav
    v-cloak
    id="page-sidebar"
    class="fixed top-0 bottom-0 left-0 z-50 flex flex-col h-full overflow-auto transition-transform duration-500 ease-out transform bg-slate-100 lg:translate-x-0"
    :class="{
      '-translate-x-full': !mobileSidebarOpen,
      'translate-x-0': mobileSidebarOpen,
      'w-80 lg:w-64': !sidebarMinimized,
    }"
    aria-label="Main Sidebar Navigation"
  >
    <!-- Sidebar Header -->
    <div class="relative flex items-center justify-between flex-none w-full h-20 px-8">
      <!-- Brand -->
      <Link
        :href="route('tenant.customers.portal.dashboard')"
        class="inline-flex items-center space-x-2 text-lg font-bold tracking-wide transition text-slate-800 hover:opacity-75 active:opacity-100"
      >
        <img class="w-8 h-8 rounded-full" :src="$page.props.tenant.logo" />
        <span v-if="!sidebarMinimized">
          <span class="font-medium text-blue-600">{{ $page.props.tenant.name }}</span>
        </span>
      </Link>
      <!-- END Brand -->

      <div
        class="hidden lg:block"
        :class="{ 'lg:ml-auto': !sidebarMinimized, 'lg:absolute lg:right-0 lg:mr-2': sidebarMinimized, }"
      >
        <a href="#" class="text-lg" @click.prevent="sidebarMinimized = !sidebarMinimized">
          <i v-if="!sidebarMinimized" class="bi bi-chevron-left"></i>
          <i v-else class="bi bi-chevron-right"></i>
        </a>
      </div>

      <!-- Close Sidebar on Mobile -->
      <div class="lg:hidden">
        <button
          type="button"
          class="flex items-center justify-center w-10 h-10 text-slate-400 hover:text-slate-600 active:text-slate-400"
          @click="mobileSidebarOpen = false"
        >
          <svg
            class="inline-block w-5 h-5 -mx-1 hi-solid hi-x"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
      <!-- END Close Sidebar on Mobile -->
    </div>
    <!-- END Sidebar Header -->

    <!-- Main Navigation -->
    <div v-on-click-outside="closeMobileSidebar" class="w-full p-4 space-y-3 grow">
      <SidebarLink
        :minimized="sidebarMinimized"
        :href="route('tenant.customers.portal.dashboard')"
        active="tenant.customers.portal.dashboard"
      >
        <svg
          class="inline-block w-4 h-4 bi bi-house-heart-fill text-slate-400"
          :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 16 16"
        >
          <path
            d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.707L8 2.207 1.354 8.853a.5.5 0 1 1-.708-.707L7.293 1.5Z"
          />
          <path
            d="m14 9.293-6-6-6 6V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9.293Zm-6-.811c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.691 0-5.018Z"
          />
        </svg>
        <span v-if="!sidebarMinimized">Dashboard</span>
      </SidebarLink>

      <!-- Projects -->
      <SidebarLink
        :minimized="sidebarMinimized"
        active="tenant.customers.portal.projects.*"
        :href="route('tenant.customers.portal.dashboard')"
      >
        <svg
          class="inline-block w-4 h-4 bi bi-briefcase-fill text-slate-400"
          :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 16 16"
        >
          <path
            d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"
          />
          <path
            d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"
          />
        </svg>
        <span v-if="!sidebarMinimized">Projects</span>
      </SidebarLink>
      <!-- END Projects -->
    </div>
    <!-- END Main Navigation -->

    <!-- Sub Navigation -->
    <div class="flex-none w-full p-4 space-y-3">
      <AppLanguageSelector as="div">
        <SidebarLink :minimized="sidebarMinimized" as="div" class="cursor-pointer relative">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="inline-block w-4 h-4 text-slate-400 bi bi-globe2"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            viewBox="0 0 16 16"
          >
            <path
              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"
            />
          </svg>
          <span
            v-if="sidebarMinimized"
            class="absolute top-0 right-2 text-xs"
          >{{ $page.props.language }}</span>
          <span v-if="!sidebarMinimized">Language</span>
        </SidebarLink>
      </AppLanguageSelector>

      <SidebarLink :minimized="sidebarMinimized" href="javascript:void(0)">
        <svg
          class="inline-block w-4 h-4 bi bi-gear-fill text-slate-400"
          :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 16 16"
        >
          <path
            d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"
          />
        </svg>
        <span v-if="!sidebarMinimized">Settings</span>
      </SidebarLink>

      <!-- Logout Form -->
      <form ref="logoutForm" method="POST" :action="route('logout')">
        <input type="hidden" name="_token" :value="$page.props.csrf_token" />

        <SidebarLink
          :minimized="sidebarMinimized"
          href="#"
          native
          @click.prevent="logoutForm.submit()"
        >
          <svg
            class="inline-block w-4 h-4 bi bi-lock-fill text-slate-400"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Logout</span>
        </SidebarLink>
      </form>
      <!-- END Logout Form -->
    </div>
    <!-- END Sub Navigation -->
  </nav>
</template>

<style lang="scss">
.sidebar-minimized {
  @media (min-width: 1024px) {
    &:not(:hover) {
      .sidebar-title {
        display: none;
      }

      nav {
        padding: 0;
      }

      h3 {
        display: none;
      }

      .sidebar-link {
        overflow-x: hidden;

        i {
          min-width: 100%;
          width: 100%;
          margin-right: 6px;
          text-align: center;
        }

        :not(i) {
          display: none;
        }
      }

      .sidebar-dropdown-menu {
        display: none;
      }
    }
  }
}
</style>
