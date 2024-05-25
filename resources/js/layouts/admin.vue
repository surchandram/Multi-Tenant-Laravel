<script>
  export default {
    name: 'admin',
  };
</script>

<script setup>
  import { ref, onMounted, watch, computed } from 'vue';
  import { router } from '@inertiajs/vue3';
  import BackToTop from 'vue-backtotop';
  import AppButton from '@/components/AppButton.vue';
  import '../../css/tailapp.css';
  import '../tailadmin/spa.js';
  import AdminHeader from './partials/AdminHeader.vue';
  import AdminSidebar from './partials/AdminSidebar.vue';
  import AdminFooter from './partials/AdminFooter.vue';
  import AppFlashMessages from '@/components/AppFlashMessages.vue';

  import { Modal } from 'momentum-modal';

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);
  const shopRoutes = ref(false);
  const currentRoute = ref(route().current());

  const defaults = {
    minimized: [],
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

      shopRoutes.value = route().current('shops.*');
    });
  });
</script>

<template>
  <!-- Page Container -->
  <div
    id="page-container"
    class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-white"
    :class="{
      'lg:pl-[5.5rem]': sidebarMinimized,
      'lg:pl-64': !sidebarMinimized,
    }"
  >
    <!-- Page Sidebar -->
    <AdminSidebar :minimized="sidebarMinimized" />

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
          <AdminHeader />
          <!-- END Page Header -->

          <div class="px-6 lg:px-8 pt-20 lg:pt-0">
            <slot></slot>
          </div>
        </div>
      </div>
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <AdminFooter />
    <!-- END Page Footer -->

    <!-- Modal -->
    <Modal />
    <!-- END Modal -->

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
