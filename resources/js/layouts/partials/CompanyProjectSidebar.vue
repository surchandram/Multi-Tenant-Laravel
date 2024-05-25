<script setup>
  import { computed, watch, ref, onMounted } from 'vue';
  import { Link, usePage } from '@inertiajs/vue3';
  import { useMediaQuery } from '@vueuse/core';
  import SidebarLink from '@/components/tailapp/SidebarLink.vue';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { Button } from '@/components/ui/button';
  import { ScrollArea } from '@/components/ui/scroll-area';

  const props = defineProps({
    minimized: {
      type: Boolean,
      default: false,
    },
    inline: {
      type: Boolean,
      default: false,
    },
  });

  const emit = defineEmits(['opened']);

  const isLargeScreen = useMediaQuery('(min-width: 1024px)');
  const navbarOpen = ref(true);
  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(props.minimized);
  const project = ref(usePage().props?.model?.project);
  const editing = ref(false);
  const showDocs = ref(false);

  const moistureMapLink = computed(() =>
    project.value.affectedAreas?.length < 1 ? '' : window.route('restore.projects.moisture-map.index', project.value),
  );

  const psychrometricReportLink = computed(() =>
    project.value.affectedAreas?.length < 1
      ? ''
      : window.route('restore.projects.psychrometric-report.index', project.value),
  );

  const handleRouteChange = () => {
    navbarOpen.value = isLargeScreen.value;
  };

  onMounted(() => {
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit('mobile-sidebar-toggled', val);

      if (val) {
        sidebarMinimized.value = false;
      }
    });

    watch(isLargeScreen, (val) => {
      navbarOpen.value = val;
    });

    watch(navbarOpen, (val) => {
      emit('opened', val);
    });

    $eventBus.on('route::changed', handleRouteChange);

    $eventBus.on('show-project-sidebar', () => {
      navbarOpen.value = true;
    });

    $eventBus.on('hide-project-sidebar', () => {
      navbarOpen.value = false;
    });

    $eventBus.on('setup-project-sidebar', (projectData) => (project.value = projectData));
  });
</script>

<template>
  <div
    class="lg:flex flex-col px-4 fixed sm:sticky lg:top-0 bg-indigo-50 dark:bg-secondary dark:text-primary z-[9999] md:z-[60] lg:z-auto"
    :class="{
      'w-full lg:w-64 h-screen py-3 lg:ml-0.5 overflow-y-auto md:overflow-hidden': navbarOpen,
      'hidden lg:w-16 lg:ml-0.5': !navbarOpen,
    }"
  >
    <!-- Project Loaded -->
    <template v-if="project">
      <!-- Project Sidebar Header -->
      <div
        class="flex items-center"
        :class="{
          'h-10 justify-start lg:justify-center': !navbarOpen,
          'h-20 justify-end mb-3': navbarOpen,
        }"
      >
        <template v-if="navbarOpen">
          <Link
            v-if="!editing"
            :href="route('restore.projects.edit', project)"
            class="px-4 py-2 mr-auto rounded-md text-sm text-indigo-100 font-semibold bg-indigo-600"
            >{{ __('app.labels.edit') }}</Link
          >

          <!-- Editing status -->
          <div
            v-else
            class="px-1 py-1 mr-auto rounded-md text-xs font-semibold bg-indigo-400 text-white"
          >
            {{ __('tenant.labels.editing') }}
          </div>
        </template>
        <!-- END Edit Button -->

        <!-- Project Sidebar Toggler -->
        <Button
          v-if="!inline"
          variant="ghost"
          class="text-indigo-600"
          @click.prevent="navbarOpen = !navbarOpen"
        >
          <LucideIcon
            v-if="navbarOpen"
            name="panel-left-close"
          />

          <LucideIcon
            v-else
            name="panel-left-open"
          />
        </Button>
        <!-- END Project Sidebar Toggler -->
      </div>
      <!-- END Project Sidebar Header -->

      <!-- Navigation -->
      <component
        :is="inline ? 'div' : ScrollArea"
        class="w-full min-h-full pb-12"
      >
        <div
          class="transition ease-linear duration-100"
          :class="{
            hidden: !navbarOpen,
            block: navbarOpen,
          }"
        >
          <div class="min-h-full">
            <!-- Status Badge -->
            <p class="inline-flex items-center flex-wrap gap-2 text-sm font-semibold mb-6">
              {{ __('tenant.labels.status') }}&colon;
              <span class="px-1 py-1 rounded-md bg-blue-200 text-blue-600">{{ project.status?.name }}</span>
            </p>
            <!-- END Status Badge -->

            <!-- Project Information -->
            <SidebarLink
              v-slot="{ iconStyles, isActive }"
              :href="route('restore.projects.show', project)"
              active="restore.projects.show"
              theme="admin"
            >
              <i
                class="bi bi-journal-bookmark"
                :class="{ [iconStyles]: !isActive }"
              ></i>
              <span class="grow">{{ __('tenant.labels.project_information') }}</span>
            </SidebarLink>
            <!-- END Project Information -->

            <hr class="h-5 border-0" />

            <div class="space-y-1.5">
              <!-- Moisture Map -->
              <SidebarLink
                v-slot="{ iconStyles, isActive }"
                :href="moistureMapLink"
                active="restore.projects.moisture-map.index"
                theme="admin"
              >
                <i
                  class="bi bi-moisture text-sm"
                  :class="{ [iconStyles]: !isActive }"
                ></i>
                <span class="grow">{{ __('tenant.labels.moisture_map') }}</span>
              </SidebarLink>
              <!-- END Moisture Map -->

              <!-- Psychrometric Report -->
              <SidebarLink
                v-slot="{ iconStyles, isActive }"
                :href="psychrometricReportLink"
                active="restore.projects.psychrometric-report.index"
                theme="admin"
              >
                <i
                  class="bi bi-thermometer-half text-sm"
                  :class="{ [iconStyles]: !isActive }"
                ></i>
                <span class="grow">{{ __('tenant.labels.psychrometric_report') }}</span>
              </SidebarLink>
              <!-- END Psychrometric Report -->
            </div>

            <hr class="h-5 border-0" />

            <!-- Documents -->
            <div class="space-y-1 5">
              <SidebarLink
                as="a"
                href="#"
                theme="admin"
                @click.prevent="showDocs = !showDocs"
              >
                <i class="bi bi-file-text"></i>
                <div class="flex-1">{{ __('tenant.labels.documents') }}</div>
                <i
                  :class="[showDocs ? 'bi-chevron-up' : 'bi-chevron-down']"
                  class="ml-auto bi text-xs leading-none"
                ></i>
              </SidebarLink>

              <div
                v-if="project.documents?.length < -1"
                class="text-center py-3"
              >
                <i class="bi bi-exclamation-circle"></i>
                <p class="text-sm">{{ __('tenant.projects.no_documents_found') }}</p>
              </div>

              <!-- Documents Dropdown -->
              <div
                v-else
                class="py-3"
              >
                <ul
                  v-if="showDocs"
                  class="space-y-2"
                >
                  <SidebarLink
                    v-for="document in project.documents"
                    :key="`document-${document.id}`"
                    theme="admin"
                    :active="document.signed ? route().current() : ''"
                    href="#"
                    as="a"
                    @click.prevent="$eventBus.emit('show-document', document)"
                  >
                    <div
                      class="inline-flex flex-1 sm:items-center flex-col sm:flex-row gap-y-4 sm:gap-y-1 gap-x-2.5 text-slate-700 dark:text-primary font-medium"
                    >
                      <div class="flex items-center gap-1 mr-auto text-sm">
                        <LucideIcon
                          :name="!document.signed ? 'file-pen' : 'check'"
                          class="size-4"
                        />
                        <span>{{ document.title }}</span>
                      </div>

                      <div
                        :class="[
                          document.signed
                            ? 'bg-indigo-600 text-white'
                            : 'bg-slate-300 dark:bg-primary-foreground dark:text-primary',
                        ]"
                        class="px-2 py-1 border rounded-full text-sm text-center"
                      >
                        {{
                          document.signed
                            ? __('customer.labels.document_signed')
                            : __('customer.labels.document_not_signed')
                        }}
                      </div>
                    </div>
                  </SidebarLink>
                </ul>
              </div>
              <!-- END Documents Dropdown -->
            </div>
            <!-- END Documents -->
          </div>
        </div>
      </component>
      <!-- END Navigation -->
    </template>
    <!-- END Project Loaded -->

    <template v-else>
      <p class="text-sm text-red-400 font-semibold">{{ __('Whoops! Failed setting up project sidebar.') }}</p>
    </template>
  </div>
</template>

<style lang="scss"></style>
