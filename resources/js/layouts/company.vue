<script>
  export default {
    name: 'company',
  };
</script>

<script setup>
  import { ref, onMounted, watch, computed } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { useMediaQuery } from '@vueuse/core';
  import { some } from 'lodash';
  import BackToTop from 'vue-backtotop';
  import '../../css/app.css';
  import '../tailadmin/spa.js';
  import CompanyHeader from './partials/CompanyHeader.vue';
  import CompanySidebar from './partials/CompanySidebar.vue';
  import CompanyFooter from './partials/CompanyFooter.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppFlashMessages from '@/components/AppFlashMessages.vue';
  import AppNoticeModal from '@/components/AppNoticeModal.vue';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { Button } from '@/components/ui/button';
  import { ResizablePanel, ResizablePanelGroup } from '@/components/ui/resizable';
  import { ScrollArea } from '@/components/ui/scroll-area';
  import { Sheet, SheetContent, SheetHeader, SheetTitle } from '@/components/ui/sheet';

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);
  const currentRoute = ref(route().current());
  const companySidebarRef = ref();
  const openCompanySidebar = ref(false);
  const isLargeScreen = useMediaQuery('(min-width: 1024px)');

  const companySidebarSize = computed(() => (isLargeScreen.value && !sidebarMinimized.value ? 18 : 6));

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

    // listen to 'expand-sidebar'
    $eventBus.on('expand-sidebar', (val) => (openCompanySidebar.value = true));

    // listen to 'sidebar-minimized' event
    $eventBus.on('sidebar-minimized', (val) => (sidebarMinimized.value = val));

    // listen to 'router:navigate' event
    router.on('navigate', () => {
      sidebarMinimized.value = false;

      // expand sidebar first
      if (isLargeScreen.value) {
        $eventBus.emit('expand-sidebar');
      }

      some(defaults.minimized, (routeName) => {
        if (route().current(routeName)) {
          sidebarMinimized.value = true;

          // emit 'minimize-sidebar' event
          $eventBus.emit('minimize-sidebar');

          return true;
        }
      });

      currentRoute.value = route().current();
    });

    // listen to router 'finish' event
    router.on('finish', () => {
      openCompanySidebar.value = false;
    });
  });
</script>

<template>
  <!-- Page Container -->
  <div
    id="page-container"
    class="flex flex-col min-h-screen w-full min-w-[320px] dark:bg-background"
  >
    <!-- Company Sidebar Mobile -->
    <div class="flex items-center">
      <Sheet
        v-if="!isLargeScreen"
        v-model:open="openCompanySidebar"
        key="companyLayoutSidebar"
        modal
        :default-open="false"
      >
        <SheetContent
          id="companyLayoutSidebar"
          aria-describedby="undefined"
          side="left"
          class="flex flex-col items-start bg-slate-200"
        >
          <SheetHeader class="-mt-2">
            <SheetTitle>Menu</SheetTitle>
          </SheetHeader>

          <ScrollArea class="w-full h-screen pb-5">
            <CompanySidebar
              inline
              class="!w-full !bg-transparent"
            />
          </ScrollArea>
        </SheetContent>
      </Sheet>
    </div>
    <!-- END Company Sidebar Mobile -->

    <component
      :is="isLargeScreen ? ResizablePanelGroup : 'div'"
      direction="horizontal"
    >
      <!-- Page Sidebar -->
      <component
        v-if="isLargeScreen"
        :is="isLargeScreen ? ResizablePanel : 'div'"
        v-slot="{ isCollapsed }"
        class="flex"
        ref="companySidebarRef"
        collapsible
        :collapsed-size="6"
        :default-size="18"
        :min-size="18"
        :max-size="companySidebarSize"
      >
        <div class="min-h-screen flex flex-col flex-nowrap bg-slate-200 dark:bg-secondary">
          <!-- Toggle Sidebar -->
          <Button
            v-if="sidebarMinimized"
            variant="ghost"
            @click="$eventBus.emit('expand-sidebar')"
          >
            <LucideIcon name="menu" />
          </Button>
          <!-- END Toggle Sidebar -->

          <CompanySidebar
            class="!flex-1"
            :minimized="sidebarMinimized"
            @minimized="
              () => (isCollapsed ? companySidebarRef.resize(companySidebarSize) : companySidebarRef.collapse())
            "
          />
        </div>
      </component>
      <!-- Page Sidebar -->

      <!-- Page Content -->
      <component :is="isLargeScreen ? ResizablePanel : 'div'">
        <div class="h-full flex flex-col">
          <main
            id="page-content"
            class="flex flex-col flex-auto max-w-full mb-auto"
          >
            <!-- Alerts -->
            <AppFlashMessages custom="w-full" />
            <!-- /Alerts -->

            <!-- Default Slot -->
            <div class="flex flex-col lg:flex-row items-start gap-4 lg:gap-0 relative">
              <div class="w-full lg:w-auto lg:flex-1 min-h-full">
                <!-- Page Header -->
                <CompanyHeader />
                <!-- END Page Header -->

                <div class="px-6 lg:px-8 pt-20 lg:pt-0">
                  <slot></slot>
                </div>

                <!-- Bottom Toolbar -->
                <!-- <div class="lg:px-8"> -->
                <!-- <FixedFormWrapper></FixedFormWrapper> -->
                <!-- </div> -->
                <!-- END Bottom Toolbar -->
              </div>
            </div>
          </main>
          <!-- END Page Content -->

          <!-- Page Footer -->
          <CompanyFooter />
          <!-- END Page Footer -->
        </div>
      </component>
    </component>

    <!-- Notice Modal -->
    <AppNoticeModal />
    <!-- END Notice Modal -->

    <back-to-top
      text="Back to top"
      visibleoffset="500"
    >
      <AppButton type="button"><i class="bi bi-chevron-up"></i></AppButton>
    </back-to-top>
  </div>
  <!-- END Page Container -->
</template>
