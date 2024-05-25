<script>
  export default {
    name: 'company_project',
  };
</script>

<script setup>
  import { computed, ref, onMounted, watch } from 'vue';
  import { useMediaQuery } from '@vueuse/core';
  import BackToTop from 'vue-backtotop';
  import AppButton from '@/components/AppButton.vue';
  import '../../css/app.css';
  import '../tailadmin/spa.js';
  import CompanyHeader from './partials/CompanyHeader.vue';
  import CompanySidebar from './partials/CompanySidebar.vue';
  import CompanyProjectSidebar from './partials/CompanyProjectSidebar.vue';
  import CustomerFooter from './partials/CustomerFooter.vue';
  import AppFlashMessages from '@/components/AppFlashMessages.vue';
  import AppNoticeModal from '@/components/AppNoticeModal.vue';
  import ProjectFooterPopover from '@/components/projects/ProjectFooterPopover.vue';

  import { Modal } from 'momentum-modal';
  import { ResizablePanel, ResizablePanelGroup } from '@/components/ui/resizable';
  import { Button } from '@/components/ui/button';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { ScrollArea } from '@/components/ui/scroll-area';
  import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
  import { router } from '@inertiajs/vue3';

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(true);
  const companySidebarRef = ref();
  const projectSidebarRef = ref();
  const showCompanySidebar = ref(false);
  const showProjectSidebar = ref(false);
  const isLargeScreen = useMediaQuery('(min-width: 1024px)');

  const companySidebarSize = computed(() => (isLargeScreen.value ? 18 : 6));

  const toggleSidebar = () => {
    $eventBus.emit('toggle-sidebar');
    sidebarMinimized.value
      ? companySidebarRef.value.resize(companySidebarSize.value)
      : companySidebarRef.value.collapse();
  };

  onMounted(() => {
    // watch 'mobileSidebarOpen'
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit('mobile-sidebar-toggled', val);
    });

    // listen to 'mobile-sidebar-toggled'
    $eventBus.on('mobile-sidebar-toggled', (val) => (mobileSidebarOpen.value = val));

    // listen to 'show-project-sidebar'
    $eventBus.on('show-project-sidebar', (val) => (showProjectSidebar.value = true));

    // listen to 'expand-sidebar'
    $eventBus.on('expand-sidebar', (val) => (showCompanySidebar.value = true));

    // listen to 'sidebar-minimized' event
    $eventBus.on('sidebar-minimized', (val) => {
      sidebarMinimized.value = val;
    });

    // listen to router 'finish' event
    router.on('finish', () => {
      if (!isLargeScreen.value) {
        showCompanySidebar.value = false;
        showProjectSidebar.value = false;
      } else {
        $eventBus.emit('minimize-sidebar');
      }
    });
  });
</script>

<template>
  <!-- Page Container -->
  <div
    id="page-container"
    class="flex flex-col md:max-h-screen w-full overflow-hidden dark:bg-background"
  >
    <!-- Company Project Sidebar Section -->
    <div class="flex items-center">
      <!-- Company Sidebar Mobile -->
      <Sheet
        v-if="!isLargeScreen"
        v-model:open="showCompanySidebar"
        key="companyProjectLayoutSidebar"
        :default-open="false"
        modal
      >
        <SheetContent
          id="companyProjectLayoutSidebar"
          aria-describedby="undefined"
          side="left"
          class="flex flex-col items-start bg-slate-200 dark:bg-slate-950/95"
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
      <!-- END Company Sidebar Mobile -->

      <!-- Company Project Sidebar -->
      <Sheet
        v-if="!isLargeScreen"
        v-model:open="showProjectSidebar"
        modal
      >
        <SheetContent
          aria-describedby="undefined"
          side="left"
          class="flex flex-col items-start bg-slate-100 dark:bg-slate-950"
        >
          <SheetHeader class="-mt-2">
            <SheetTitle>Project menu</SheetTitle>
          </SheetHeader>

          <ScrollArea class="w-full h-screen max-h-screen pb-10 pr-5">
            <CompanyProjectSidebar
              inline
              class="!min-w-fit !h-auto !-mx-2 !px-2 !sm:px-auto !bg-transparent !static"
            />
          </ScrollArea>
        </SheetContent>
      </Sheet>
      <!-- END Company Project Sidebar -->
    </div>
    <!-- END Company Project Sidebar Section -->

    <component
      :is="isLargeScreen ? ResizablePanelGroup : 'div'"
      direction="horizontal"
    >
      <!-- Page Sidebar -->
      <component
        v-if="isLargeScreen"
        :is="isLargeScreen ? ResizablePanel : 'div'"
        v-slot="{ isCollapsed }"
        ref="companySidebarRef"
        collapsible
        :collapsed-size="6"
        :default-size="6"
        :min-size="6"
        :max-size="companySidebarSize"
      >
        <div
          v-if="isCollapsed"
          class="flex justify-center py-2"
        >
          <Button
            variant="ghost"
            @click="toggleSidebar"
          >
            <LucideIcon
              name="menu"
              class="h-6 w-6"
            />
          </Button>
        </div>

        <ScrollArea
          :class="[isCollapsed ? 'md:pb-14' : 'pb-px']"
          class="h-screen"
        >
          <CompanySidebar
            :minimized="true"
            @minimized="
              () => (isCollapsed ? companySidebarRef.resize(companySidebarSize) : companySidebarRef.collapse())
            "
          />
        </ScrollArea>
      </component>
      <!-- Page Sidebar -->

      <!-- Main Section -->
      <component :is="isLargeScreen ? ResizablePanel : 'div'">
        <!-- Page Content -->
        <div class="flex flex-col min-w-full max-w-fit">
          <main
            id="page-content"
            class="flex flex-col flex-auto max-w-full"
          >
            <!-- Alerts -->
            <AppFlashMessages custom="w-full" />
            <!-- /Alerts -->

            <!-- Default Slot -->
            <div class="w-full flex flex-col lg:flex-row items-start gap-0 lg:gap-0 relative">
              <component
                :is="isLargeScreen ? ResizablePanelGroup : 'div'"
                :class="[isLargeScreen ? '' : 'min-w-full flex flex-col']"
                direction="horizontal"
              >
                <!-- Inner Sidebar -->
                <component
                  v-if="isLargeScreen"
                  v-slot="{ isCollapsed }"
                  :is="isLargeScreen ? ResizablePanel : 'div'"
                  ref="projectSidebarRef"
                  collapsible
                  :collapsed-size="0"
                  :default-size="20"
                  :min-size="0"
                  :max-size="20"
                >
                  <CompanyProjectSidebar
                    @opened="() => (isCollapsed ? projectSidebarRef.resize(20) : projectSidebarRef.resize(0))"
                  />
                </component>
                <!-- END Inner Sidebar -->

                <component
                  :is="isLargeScreen ? ResizablePanel : 'div'"
                  :min-size="76"
                >
                  <ScrollArea class="w-full h-screen pb-2">
                    <div
                      class="flex flex-col max-w-screen md:w-auto md:flex-1 sm:mt-0 bg-slate-50 dark:bg-slate-900 dark:text-primary min-h-screen"
                    >
                      <!-- Page Header -->
                      <div class="flex item-center">
                        <div
                          v-if="isLargeScreen && projectSidebarRef?.isCollapsed"
                          :default-size="5"
                          class="flex item-center p-2 dark:bg-secondary mb-8"
                        >
                          <!-- Project Sidebar Toggler -->
                          <Button
                            variant="ghost"
                            class="text-indigo-600"
                            @click.prevent="$eventBus.emit('show-project-sidebar')"
                          >
                            <LucideIcon
                              name="panel-left-open"
                              class="w-6 h-6"
                            />
                          </Button>
                          <!-- END Project Sidebar Toggler -->
                        </div>

                        <div class="flex-1">
                          <CompanyHeader />
                        </div>
                      </div>
                      <!-- END Page Header -->

                      <div class="w-full lg:hidden px-6 lg:px-8 py-3">
                        <!-- Project Sidebar Toggler -->
                        <Button
                          variant="outline"
                          size="lg"
                          class="flex items-center justify-center gap-2 py-2 mx-auto md:mx-0 md:ml-auto text-indigo-500 text-base leading-none font-medium dark:text-indigo-200"
                          @click.prevent="$eventBus.emit('show-project-sidebar')"
                        >
                          <span>{{ __('tenant.labels.project_options') }}</span>
                          <LucideIcon
                            name="chevrons-up-down"
                            class="w-6 h-6"
                          ></LucideIcon>
                        </Button>
                        <!-- END Project Sidebar Toggler -->
                      </div>

                      <div class="px-6 lg:px-8 pt-8 lg:pt-0">
                        <slot></slot>
                      </div>

                      <!-- Bottom Toolbar -->
                      <div class="lg:px-8">
                        <ProjectFooterPopover />
                      </div>
                      <!-- END Bottom Toolbar -->

                      <!-- Page Footer -->
                      <CustomerFooter />
                      <!-- END Page Footer -->
                    </div>
                  </ScrollArea>
                </component>
              </component>
            </div>
          </main>
        </div>
        <!-- END Page Content -->
      </component>
      <!-- END Main Section -->

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
    </component>
  </div>
  <!-- END Page Container -->
</template>
