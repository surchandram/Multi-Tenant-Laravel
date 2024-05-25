<script setup>
  import { watch, ref, onMounted } from 'vue';
  import { vOnClickOutside } from '@vueuse/components';
  import SidebarDropdown from '@/components/tailapp/SidebarDropdown.vue';
  import SidebarLink from '@/components/tailapp/SidebarLink.vue';
  import AppLanguageSelector from '@/components/AppLanguageSelector.vue';
  import { router } from '@inertiajs/vue3';

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
      $eventBus.emit('mobile-sidebar-toggled', val);

      if (val) {
        sidebarMinimized.value = false;
      }
    });

    watch(sidebarMinimized, (val) => {
      $eventBus.emit('sidebar-minimized', val);
    });

    // listen to 'mobile-sidebar-toggled' event
    $eventBus.on('mobile-sidebar-toggled', (val) =>
      mobileSidebarOpen.value == val ? null : (mobileSidebarOpen.value = val),
    );

    // listen to 'minimize-sidebar' and 'expand-sidebar' events
    $eventBus.on('minimize-sidebar', () => (sidebarMinimized.value = true));
    $eventBus.on('expand-sidebar', () => (sidebarMinimized.value = false));

    router.on('start', () => {
      mobileSidebarOpen.value = false;
    });
  });
</script>

<template>
  <nav
    v-cloak
    id="page-sidebar"
    class="fixed top-0 bottom-0 left-0 z-50 flex flex-col min-h-screen overflow-hidden transition-transform duration-500 ease-out transform bg-slate-100 lg:translate-x-0"
    :class="{
      '-translate-x-full': !mobileSidebarOpen,
      'translate-x-0': mobileSidebarOpen,
      'w-80 lg:w-64': !sidebarMinimized,
    }"
    aria-label="Main Sidebar Navigation"
  >
    <!-- Scroll Wrapper -->
    <div class="flex flex-col h-full overflow-auto bg-slate-200 relative">
      <!-- Sidebar Header -->
      <div
        class="w-full h-20 flex items-center flex-none"
        :class="{
          'px-2 justify-center': sidebarMinimized,
          'px-8 justify-between': !sidebarMinimized,
        }"
      >
        <!-- Brand -->
        <a
          :href="route('home')"
          class="inline-flex items-center space-x-2 text-lg leading-none font-bold tracking-wide transition text-slate-800 hover:opacity-75 active:opacity-100"
          :class="{
            'ml-2': sidebarMinimized,
          }"
        >
          <div class="w-6">
            <img
              v-if="$page.props.logoData['small']"
              :src="$page.props.logoData['small']"
              alt
              class="w-full"
            />
            <img
              v-else
              class="w-full"
              src="/logos/cyber_hawk_logo.svg"
              alt
            />
          </div>
          <span v-if="!sidebarMinimized">
            <span class="font-medium text-blue-600">{{ $page.props.appName }}</span>
          </span>
        </a>
        <!-- END Brand -->

        <!-- Close Sidebar on Mobile -->
        <div class="lg:hidden">
          <button
            type="button"
            class="flex items-center justify-center w-10 h-10 text-slate-400 hover:text-slate-600 active:text-slate-400"
            @click="mobileSidebarOpen = false"
          >
            <svg
              class="inline-block w-6 h-6 -mx-1 hi-solid hi-x"
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
      <div
        v-on-click-outside="closeMobileSidebar"
        class="w-full p-4 space-y-3 grow"
      >
        <!-- Menu Group -->
        <div>
          <h3
            v-if="!sidebarMinimized"
            class="mb-4 ml-4 text-sm font-medium"
          >
            MENU
          </h3>

          <div class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item Dashboard -->
            <SidebarLink
              active="admin.dashboard"
              :href="route('admin.dashboard')"
            >
              <i
                :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                class="bi bi-activity text-2xl leading-none"
              ></i>
              <span v-if="!sidebarMinimized">{{ __('admin.labels.dashboard') }}</span>
            </SidebarLink>
            <!-- Menu Item Dashboard -->

            <!-- top -->
          </div>
        </div>

        <div>
          <div class="mb-6 flex flex-col gap-1.5">
            <!-- Apps -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.apps.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-ui-radios-grid text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.apps') }}</span>
              </template>

              <!-- Dropdown menu items -->
              <SidebarLink
                theme="simple"
                :href="route('admin.apps.restore.projects.types.settings')"
                active="admin.apps.restore.projects.types.settings"
                >{{ __('admin.labels.restore_settings') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.apps.index')"
                active="admin.apps.index"
                >{{ __('admin.labels.manage_apps') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- END Apps -->

            <!-- Companies -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.companies.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-buildings text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.companies') }}</span>
              </template>

              <!-- Dropdown menu items -->
              <SidebarLink
                theme="simple"
                :href="route('admin.companies.index')"
                active="admin.companies.index"
                >{{ __('admin.labels.manage_companies') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- END Companies -->

            <!-- Documents -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.documents.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-files text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.documents') }}</span>
              </template>

              <!-- Dropdown menu items -->
              <SidebarLink
                theme="simple"
                :href="route('admin.documents.create')"
                active="admin.documents.create"
                >{{ __('admin.labels.add_document') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.documents.index')"
                active="admin.documents.index"
                >{{ __('admin.labels.manage_documents') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- END Documents -->
          </div>
        </div>

        <div>
          <h3
            v-if="!sidebarMinimized"
            class="mb-4 ml-4 text-sm font-medium uppercase"
          >
            {{ __('admin.labels.features_and_plans') }}
          </h3>

          <div class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item Features -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.features.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-plug text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.features') }}</span>
              </template>

              <!-- Dropdown menu items -->
              <SidebarLink
                theme="simple"
                :href="route('admin.features.create')"
                active="admin.features.create"
                >{{ __('admin.labels.add_feature') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.features.index')"
                active="admin.features.index"
                >{{ __('admin.labels.manage_features') }}</SidebarLink
              >
            </SidebarDropdown>

            <!-- Menu Item Plans -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.plans.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-credit-card-2-front text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.plans') }}</span>
              </template>

              <!-- Dropdown menu items -->
              <SidebarLink
                theme="simple"
                :href="route('admin.plans.create')"
                active="admin.plans.create"
                >{{ __('admin.labels.add_plan') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.plans.index')"
                active="admin.plans.index"
                >{{ __('admin.labels.manage_plans') }}</SidebarLink
              >
            </SidebarDropdown>
          </div>
        </div>

        <!-- Site Group -->
        <div>
          <h3
            v-if="!sidebarMinimized"
            class="mb-4 ml-4 text-sm font-medium uppercase"
          >
            {{ __('admin.labels.site') }}
          </h3>

          <div class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item Pages -->
            <SidebarLink
              active="admin.site.logo.*"
              :href="route('admin.site.logo.index')"
            >
              <i
                :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                class="bi bi-image-fill text-2xl leading-none"
              ></i>
              <span v-if="!sidebarMinimized">{{ __('admin.labels.site_logo') }}</span>
            </SidebarLink>
            <!-- Menu Item Pages -->

            <!-- Menu Item Pages -->
            <SidebarLink
              active="admin.pages.*"
              :href="route('admin.pages.index')"
            >
              <i
                :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                class="bi bi-link-45deg text-2xl leading-none"
              ></i>
              <span v-if="!sidebarMinimized">{{ __('admin.labels.manage_pages') }}</span>
            </SidebarLink>
            <!-- Menu Item Pages -->

            <!-- Menu Item Settings -->
            <SidebarLink
              active="admin.settings.*"
              :href="route('admin.settings.index')"
            >
              <i
                :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                class="bi bi-gear text-2xl leading-none"
              ></i>
              <span v-if="!sidebarMinimized">{{ __('admin.labels.settings') }}</span>
            </SidebarLink>
            <!-- Menu Item Settings -->
          </div>
        </div>
        <!-- /Site Group -->

        <!-- Support Group -->
        <div>
          <h3
            v-if="!sidebarMinimized"
            class="mb-4 ml-4 text-sm font-medium uppercase"
          >
            {{ __('admin.labels.support') }}
          </h3>

          <div class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item Categories -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.support.tickets.categories.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-list-columns-reverse text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.support_ticket_categories') }}</span>
              </template>

              <!-- Dropdown Menu Links -->
              <SidebarLink
                theme="simple"
                :href="route('admin.support.tickets.categories.create')"
                >{{ __('admin.labels.add_ticket_category') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.support.tickets.categories.index')"
                >{{ __('admin.labels.support_ticket_manage_categories') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- Menu Item Categories -->

            <!-- Menu Item Labels -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.support.tickets.labels.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-tags text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.support_ticket_labels') }}</span>
              </template>

              <!-- Dropdown Menu Links -->
              <SidebarLink
                theme="simple"
                :href="route('admin.support.tickets.labels.create')"
                >{{ __('admin.labels.add_ticket_label') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.support.tickets.labels.index')"
                >{{ __('admin.labels.support_ticket_manage_labels') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- Menu Item Labels -->

            <!-- Menu Item Settings -->
            <SidebarLink
              active="admin.support.tickets.*"
              :href="route('admin.support.tickets.index')"
            >
              <i
                :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                class="bi bi-life-preserver text-2xl leading-none"
              ></i>
              <span v-if="!sidebarMinimized">{{ __('admin.labels.support_ticket') }}</span>
            </SidebarLink>
            <!-- Menu Item Settings -->
          </div>
        </div>
        <!-- /Site Group -->

        <!-- Users Group -->
        <div>
          <h3
            v-if="!sidebarMinimized"
            class="mb-4 ml-4 text-sm font-medium uppercase"
          >
            Users Management
          </h3>

          <div class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item Users -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.users.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-people text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.users') }}</span>
              </template>

              <!-- Dropdown Menu Links -->
              <SidebarLink
                theme="simple"
                :href="route('admin.users.create')"
                active="admin.users.create"
                >{{ __('admin.labels.add_user') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.users.index')"
                active="admin.users.index"
                >{{ __('admin.labels.manage_users') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- Menu Item Users -->

            <!-- Menu Item Permissions -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.permissions.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-shield-lock text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.permissions') }}</span>
              </template>

              <!-- Dropdown Menu Links -->
              <SidebarLink
                theme="simple"
                :href="route('admin.permissions.create')"
                active="admin.permissions.create"
                >{{ __('admin.labels.add_permission') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.permissions.index')"
                active="admin.permissions.index"
                >{{ __('admin.labels.manage_permissions') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- Menu Item Permissions -->

            <!-- Menu Item Roles -->
            <SidebarDropdown
              :minimized="sidebarMinimized"
              active="admin.roles.*"
            >
              <template #label>
                <i
                  :class="{ 'w-6 h-6 mx-auto': sidebarMinimized, 'w-6 h-full': !sidebarMinimized }"
                  class="bi bi-shield-shaded text-2xl leading-none"
                ></i>
                <span v-if="!sidebarMinimized">{{ __('admin.labels.roles') }}</span>
              </template>

              <!-- Dropdown Menu Links -->
              <SidebarLink
                theme="simple"
                :href="route('admin.roles.create')"
                active="admin.roles.create"
                >{{ __('admin.labels.add_role') }}</SidebarLink
              >

              <SidebarLink
                theme="simple"
                :href="route('admin.roles.index')"
                active="admin.roles.index"
                >{{ __('admin.labels.manage_roles') }}</SidebarLink
              >
            </SidebarDropdown>
            <!-- Menu Item Roles -->
          </div>
        </div>
        <!-- /Users Group -->
      </div>
      <!-- END Main Navigation -->

      <!-- Sub Navigation -->
      <div class="flex-none w-full p-4 space-y-3">
        <!-- Language Selector -->
        <AppLanguageSelector
          as="div"
          trigger-styles="min-w-full"
        >
          <SidebarLink
            :minimized="sidebarMinimized"
            as="div"
            class="min-w-full cursor-pointer relative"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="inline-block w-4 h-4 text-slate-400 bi bi-globe2"
              :class="{ 'w-6 h-6 mx-auto': sidebarMinimized }"
              viewBox="0 0 16 16"
            >
              <path
                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"
              />
            </svg>
            <span
              :class="{ 'left-3 top-0.5': !sidebarMinimized, 'right-2 top-0': sidebarMinimized }"
              class="absolute text-xs"
              >{{ $page.props.language }}</span
            >
            <span v-if="!sidebarMinimized">{{ __('app.labels.language') }}</span>
          </SidebarLink>
        </AppLanguageSelector>
        <!-- END Language Selector -->

        <!-- Logout Form -->
        <form
          ref="logoutForm"
          method="POST"
          :action="route('logout')"
        >
          <input
            type="hidden"
            name="_token"
            :value="$page.props.csrf_token"
          />

          <SidebarLink
            :minimized="sidebarMinimized"
            href="#"
            native
            @click.prevent="logoutForm.submit()"
          >
            <svg
              class="inline-block w-4 h-4 bi bi-lock-fill text-slate-400"
              :class="{ 'w-6 h-6 mx-auto': sidebarMinimized }"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"
              />
            </svg>
            <span v-if="!sidebarMinimized">{{ __('app.labels.logout') }}</span>
          </SidebarLink>
        </form>
        <!-- END Logout Form -->
      </div>
      <!-- END Sub Navigation -->
    </div>
    <!-- END Scroll Wrapper -->
  </nav>

  <!-- Minimize Sidebar Toggler -->
  <div
    class="hidden lg:block ml-auto fixed top-2 z-[99999]"
    :class="{
      'left-18': sidebarMinimized,
      'left-60': !sidebarMinimized,
    }"
  >
    <a
      v-if="sidebarMinimized"
      href="#"
      class="px-1.5 py-1 rounded-full bg-white text-lg"
      @click.prevent="sidebarMinimized = false"
    >
      <i class="bi bi-chevron-right"></i>
    </a>
    <a
      v-else
      href="#"
      class="px-1.5 py-1 rounded-full bg-white text-lg"
      @click.prevent="sidebarMinimized = true"
    >
      <i class="bi bi-chevron-left"></i>
    </a>
  </div>
  <!-- END Minimize Sidebar Toggler -->
</template>

<style lang="scss"></style>
