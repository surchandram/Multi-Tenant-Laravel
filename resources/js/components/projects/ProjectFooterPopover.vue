<script setup>
  import { ref, onMounted, watch, nextTick, inject } from 'vue';
  import { vOnClickOutside } from '@vueuse/components';
  import FixedFormWrapper from '@/components/FixedFormWrapper.vue';
  import ProjectCreateDailyLogForm from '@/components/projects/ProjectCreateDailyLogForm.vue';
  import ProjectNotesForm from './ProjectNotesForm.vue';
  import useFixedFormPopover from '@/composables/useFixedFormPopover';
  import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
  } from '@/components/ui/drawer';
  import { ScrollArea } from '../ui/scroll-area';
  import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
  import LucideIcon from '../LucideIcon.vue';
  import { Button } from '../ui/button';
  import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '../ui/tooltip';

  const __ = inject('$translate');

  const minimizeDrawer = ref(false);
  const selected = ref('');
  const preventClose = ref(false);
  const drawerDragVal = ref(0);

  const { visible, hideFixedFormPopover, showFixedFormPopover } = useFixedFormPopover();

  const tabs = [
    { id: 'notes-form', ref: 'notesPFPvButtonRef', icon: 'notebook-pen', label: __('tenant.labels.notes') },
    {
      id: 'daily-log-form',
      ref: 'dailyLogPFPvButtonRef',
      icon: 'list-plus',
      label: __('tenant.labels.daily_logs'),
    },
  ];

  const handlePreventClose = () => {
    preventClose.value = !preventClose.value;
  };

  const changeTab = (tab) => {
    if (!tab.id) {
      preventClose.value = false;
      hideFixedFormPopover();
    } else {
      showFixedFormPopover();
    }

    if (preventClose.value) {
      return;
    }

    selected.value = tab.id;
    minimizeDrawer.value = false;
  };

  const closePopover = () => {
    if (preventClose.value) {
      return;
    }

    hideFixedFormPopover();
    selected.value = '';
    preventClose.value = false;
    minimizeDrawer.value = false;
  };

  const toggleDrawerMinimum = () => {
    minimizeDrawer.value = !minimizeDrawer.value;
  };

  const drawerDrag = (val) => {
    drawerDragVal.value = val;

    showFixedFormPopover();
  };

  const drawerReleased = (val) => {
    minimizeDrawer.value = val;

    if (!val) {
      minimizeDrawer.value = false;
    }
  };

  const handleDrawerOutside = () => {
    toggleDrawerMinimum();
  };

  onMounted(() => {
    watch(selected, (val) => {
      if (!val) closePopover();
    });

    watch(visible, (val) => {
      if (!val) {
        closePopover();
      }
    });
  });
</script>

<template>
  <div>
    <TooltipProvider>
      <Drawer
        v-model:open="visible"
        dismissible
        :modal="false"
        :should-scale-background="false"
        @close="closePopover"
        @drag="drawerDrag"
        @release="drawerReleased"
      >
        <DrawerContent
          as="div"
          :disable-outside-pointer-events="false"
          @interact-outside.prevent="handleDrawerOutside"
          @escape-key-down.prevent="handleDrawerOutside"
          @pointer-down-outside.prevent="handleDrawerOutside"
          @focus-outside.prevent="handleDrawerOutside"
        >
          <DrawerHeader>
            <nav class="flex justify-end pr-4 space-x-4">
              <template v-if="!minimizeDrawer">
                <Button
                  v-for="(tab, index) in tabs"
                  :id="tab.ref"
                  :key="index"
                  :variant="selected == tab.id ? 'info' : 'ghost'"
                  class="px-4 py-2 font-medium"
                  :class="[selected == '' && tab.id == '' ? 'hidden' : '']"
                  @click.prevent="changeTab(tab)"
                >
                  <LucideIcon
                    class="size-6"
                    :name="`${tab.icon}`"
                  />
                </Button>
              </template>

              <!-- Minimize Drawer Button -->
              <Button
                variant="ghost"
                @click.prevent="toggleDrawerMinimum"
              >
                <LucideIcon
                  v-if="minimizeDrawer"
                  name="chevron-up"
                />
                <LucideIcon
                  v-else
                  name="chevron-down"
                />
              </Button>
              <!-- END Minimize Drawer Button -->

              <!-- Close Button -->
              <Button
                variant="ghost"
                @click="closePopover"
              >
                <LucideIcon name="x" />
              </Button>
              <!-- END Close Button -->
            </nav>
          </DrawerHeader>

          <!-- ScrollArea -->
          <ScrollArea
            id="projectFooterPopoverContentWrapper"
            :class="[minimizeDrawer ? '!h-0' : '']"
            class="h-[60vh] lg:h-[40vh]"
          >
            <div class="px-4 py-2">
              <!-- Create Daily Log Form -->
              <ProjectCreateDailyLogForm
                v-if="selected == 'daily-log-form'"
                @close="closePopover()"
                @toggle-close="handlePreventClose"
              />
              <!-- END Create Daily Log Form -->

              <!-- Notes -->
              <ProjectNotesForm
                v-if="selected == 'notes-form'"
                @close="closePopover()"
                @toggle-close="handlePreventClose"
              />
              <!-- END Notes -->
            </div>
          </ScrollArea>
          <!-- END ScrollArea -->
        </DrawerContent>
      </Drawer>

      <FixedFormWrapper
        v-if="!visible"
        :minimized="true"
        class="z-50 bottom-20 !rounded-full !bg-transparent"
      >
        <Popover>
          <PopoverTrigger
            :as="Button"
            variant="success"
            class="rounded-full !h-12 !w-12"
          >
            <Tooltip>
              <TooltipTrigger>
                <LucideIcon name="clipboard-list" />
              </TooltipTrigger>
              <TooltipContent>
                <span
                  v-for="(tab, index) in tabs.filter((f) => f.id != '')"
                  :key="index"
                  >{{ tab.label }}<template v-if="index + 1 < tabs.length">,&nbsp;</template></span
                >
              </TooltipContent>
            </Tooltip>
          </PopoverTrigger>

          <PopoverContent class="w-40">
            <div class="flex flex-col gap-6">
              <Button
                v-for="(tab, index) in tabs"
                :id="tab.ref"
                :key="index"
                variant="ghost"
                :class="[selected == '' && tab.id == '' ? 'hidden' : '']"
                @click.prevent="changeTab(tab)"
              >
                <LucideIcon
                  :name="`${tab.icon}`"
                  class="w-5 h-5"
                />
                <span class="ml-2">{{ tab.label }}</span>
              </Button>
            </div>
          </PopoverContent>
        </Popover>
      </FixedFormWrapper>
    </TooltipProvider>
  </div>
</template>
