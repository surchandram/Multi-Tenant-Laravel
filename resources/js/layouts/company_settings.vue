<script>
  export default {
    name: 'company_settings',
  };
</script>

<script setup>
  import { ref, onMounted, watch, computed } from 'vue';
  import { Link, router, usePage } from '@inertiajs/vue3';
  import BackToTop from 'vue-backtotop';
  import AppButton from '@/components/AppButton.vue';
  import '../../css/tailapp.css';
  import '../tailadmin/spa.js';
  import CompanySettingsSidebar from './partials/CompanySettingsSidebar.vue';
  import CompanyFooter from './partials/CompanyFooter.vue';
  import AppFlashMessages from '@/components/AppFlashMessages.vue';
  import AppNoticeModal from '@/components/AppNoticeModal.vue';

  import { Modal } from 'momentum-modal';

  const myDashboardRef = ref(null);
  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);
  const companyRoutes = ref(false);
  const currentRoute = ref(route().current());

  const user = usePage().props.auth.user;

  const defaults = {
    minimized: ['restore.projects.create', 'tenant.documents.create', 'tenant.documents.edit'],
  };

  const minimizedByDefault = computed(() => {
    _.some(defaults.minimized, (routeName) => {
      if (route().current(routeName)) {
        return true;
      }
    });

    return sidebarMinimized.value;
  });

  onMounted(() => {
    // watch 'mobileSidebarOpen'
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit('mobile-sidebar-toggled', val);
    });

    // listen to 'mobile-sidebar-toggled'
    $eventBus.on('mobile-sidebar-toggled', (val) => (mobileSidebarOpen.value = val));

    // listen to 'sidebar-minimized' event
    $eventBus.on('sidebar-minimized', (val) => (sidebarMinimized.value = val));

    // listen to 'router:navigate' event
    router.on('navigate', () => {
      // expand sidebar first
      sidebarMinimized.value = false;
      $eventBus.emit('expand-sidebar');

      _.some(defaults.minimized, (routeName) => {
        if (route().current(routeName)) {
          sidebarMinimized.value = true;

          // emit 'minimize-sidebar' event
          $eventBus.emit('minimize-sidebar');

          return true;
        }
      });

      currentRoute.value = route().current();

      companyRoutes.value = route().current('companies.*');
    });

    tippy(myDashboardRef.value, {
      content: `${user.name} (${user.email})`,
      theme: 'light',
    });
  });
</script>

<template>
  <!-- Page Container -->
  <div
    id="page-container"
    class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-white"
    :class="{
      'lg:pl-21': sidebarMinimized,
      'lg:pl-64': !sidebarMinimized,
    }"
  >
    <!-- Page Sidebar -->
    <CompanySettingsSidebar :minimized="sidebarMinimized" />

    <!-- Page Sidebar -->

    <!-- Page Content -->
    <main
      id="page-content"
      class="flex flex-col flex-auto max-w-full"
    >
      <!-- Alerts -->
      <AppFlashMessages custom="w-full" />
      <!-- /Alerts -->

      <!-- Default Slot -->
      <div class="flex flex-col lg:flex-row items-start gap-4 lg:gap-0 relative">
        <div class="w-full lg:w-auto lg:flex-1 bg-slate-50 min-h-screen">
          <!-- Page Header -->
          <header
            id="page-header"
            class="flex items-center flex-none h-20 bg-slate-100 lg:bg-slate-50"
          >
            <div class="container flex justify-between px-4 mx-auto lg:px-8 xl:max-w-7xl">
              <!-- Left Section -->
              <div class="flex items-center space-x-2">
                <!-- Toggle Sidebar on Mobile -->
                <button
                  type="button"
                  class="inline-flex items-center justify-center lg:hidden space-x-2 rounded border border-slate-300 bg-white px-2 py-1.5 font-semibold leading-6 text-slate-800 shadow-sm hover:border-slate-300 hover:bg-slate-100 hover:text-slate-800 hover:shadow focus:outline-none focus:ring focus:ring-slate-500 focus:ring-opacity-25 active:border-white active:bg-white active:shadow-none"
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
              <div class="flex items-center lg:hidden lg:mr-auto space-x-2">
                <!-- Brand -->
                <component
                  :is="!route().current('tenant.*') ? 'a' : Link"
                  :href="
                    route().current('tenant.*')
                      ? route('tenant.home')
                      : route('tenant.switch', { tenant: $page.props.model.company })
                  "
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
                    <span class="font-medium text-blue-600">{{ $page.props.appName }}</span>
                  </span>
                </component>
                <!-- END Brand -->
              </div>
              <!-- END Middle Section -->

              <!-- Right Section -->
              <div class="flex items-center space-x-2">
                <!-- Settings -->
                <a
                  ref="myDashboardRef"
                  :href="route('dashboard')"
                  class="inline-flex items-center gap-2 px-2 py-1 rounded text-sm font-semibold text-indigo-500 hover:bg-indigo-200 focus:ring focus:outline-none"
                >
                  <i class="bi bi-person-circle text-xl leading-none"></i>
                  <span class="hidden lg:inline-block">My Dashboard</span>
                </a>
                <!-- <HeaderUserDropdown /> -->
                <!-- END Toggle Sidebar on Mobile -->
              </div>
              <!-- END Right Section -->
            </div>
          </header>
          <!-- END Page Header -->

          <div class="px-6 lg:px-8 pt-20 lg:pt-0">
            <slot></slot>
          </div>
        </div>
      </div>
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <CompanyFooter
      :company="$page.props.model.company"
      app-mode
    />
    <!-- END Page Footer -->

    <!-- Modal -->
    <Modal />
    <!-- END Modal -->

    <!-- Notice Modal -->
    <AppNoticeModal />
    <!-- END Notice Modal -->

    <back-to-top
      text="Back to top"
      visibleoffset="500"
    >
      <AppButton type="button">
        <i class="bi bi-chevron-up"></i>
      </AppButton>
    </back-to-top>
  </div>
  <!-- END Page Container -->
</template>
