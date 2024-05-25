<script setup>
  import { watch, ref, nextTick, onMounted } from 'vue';
  import { vOnClickOutside } from '@vueuse/components';
  import SidebarDropdown from '@/components/tailapp/SidebarDropdown.vue';
  import SidebarLink from '@/components/tailapp/SidebarLink.vue';
  import AppLanguageSelector from '@/components/AppLanguageSelector.vue';
  import LucideIcon from '../../components/LucideIcon.vue';
  import UserCompaniesDropdown from '../../components/companies/UserCompaniesDropdown.vue';

  const props = defineProps({
    minimized: {
      type: Boolean,
      default: false,
    },
    noBackground: {
      type: Boolean,
      default: false,
    },
    inline: {
      type: Boolean,
      default: false,
    },
  });

  const emit = defineEmits(['minimized']);

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
    nextTick(() => {
      watch(mobileSidebarOpen, (val) => {
        $eventBus.emit('mobile-sidebar-toggled', val);

        if (val) {
          sidebarMinimized.value = false;
        }
      });
    });

    watch(sidebarMinimized, (val) => {
      $eventBus.emit('sidebar-minimized', val);
      emit('minimized', val);
    });

    // listen to 'mobile-sidebar-toggled' event
    $eventBus.on('mobile-sidebar-toggled', (val) =>
      mobileSidebarOpen.value == val ? null : (mobileSidebarOpen.value = val),
    );

    // listen to 'minimize-sidebar' and 'expand-sidebar' events
    $eventBus.on('minimize-sidebar', () => (sidebarMinimized.value = true));
    $eventBus.on('expand-sidebar', () => (sidebarMinimized.value = false));
    $eventBus.on('toggle-sidebar', () => (sidebarMinimized.value = !sidebarMinimized.value));
  });
</script>

<template>
  <nav
    v-bind="$attrs"
    v-on-click-outside="closeMobileSidebar"
    id="page-sidebar"
    class="flex flex-col min-h-screen transition-transform duration-500 ease-out transform"
    :class="{
      'bg-slate-100 dark:bg-primary-foreground dark:text-primary': !noBackground,
      'w-80 lg:w-64 overflow-hidden': !sidebarMinimized,
    }"
    aria-label="Main Sidebar Navigation"
  >
    <!-- Scroll Wrapper -->
    <div class="flex flex-col h-full overflow-auto relative">
      <!-- Sidebar Header -->
      <div
        class="w-full h-20 flex items-center flex-none"
        :class="{
          'px-2 justify-center': sidebarMinimized,
          '-ml-2 px-4 justify-between': !sidebarMinimized,
        }"
      >
        <!-- Companies Dropdown -->
        <UserCompaniesDropdown :sidebar-minimized="sidebarMinimized" />
        <!-- END Companies Dropdown -->

        <!-- Close Sidebar on Mobile -->
        <div
          v-if="!inline"
          class="lg:hidden"
        >
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
      <div
        :class="[sidebarMinimized ? '!-mx-1' : '!-ml-2']"
        class="w-full p-4 space-y-3 grow"
      >
        <template
          v-for="(section, index) in $page.props.tenant_routes['sidebar']"
          :key="index"
        >
          <!-- SidebarLink -->
          <SidebarLink
            v-if="section.children.length == 0"
            :minimized="sidebarMinimized"
            :href="section.url"
            :current="section.active"
            :native="section.attributes?.native"
          >
            <LucideIcon
              :name="section.attributes?.icon"
              :size="16"
              class="w-6 h-6 text-slate-400"
              :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            />
            <span v-if="!sidebarMinimized">{{ section.title }}</span>
          </SidebarLink>
          <!-- END SidebarLink -->

          <!-- SidebarDropdown -->
          <SidebarDropdown
            v-else
            :minimized="sidebarMinimized"
            :active="section.attributes?.active"
          >
            <template #label>
              <LucideIcon
                :name="section.attributes?.icon"
                :size="16"
                class="w-6 h-6 text-slate-400"
                :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
              />
              <span v-if="!sidebarMinimized">{{ section.title }}</span>
            </template>

            <!-- Dropdown menu items -->
            <template
              v-if="!sidebarMinimized"
              #default
            >
              <SidebarLink
                v-for="(dropdownItem, idx) in section.children"
                :key="idx"
                theme="simple"
                :href="dropdownItem.url"
                :current="dropdownItem.active"
                :native="dropdownItem.attributes?.native"
                :active="dropdownItem.attributes?.active"
                >{{ dropdownItem.title }}</SidebarLink
              >
            </template>
          </SidebarDropdown>
          <!-- END SidebarDropdown -->
        </template>
      </div>
      <!-- END Main Navigation -->

      <!-- Sub Navigation -->
      <div class="flex-none w-full p-4 space-y-3">
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
              :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
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
            <span v-if="!sidebarMinimized">Language</span>
          </SidebarLink>
        </AppLanguageSelector>

        <!-- Tenant Routes -->
        <template v-if="!route().current('companies.*')">
          <!-- add secondary tenant links here -->
        </template>
        <!-- END Tenant Routes -->

        <!-- Company Overview Link -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="route('companies.show', $page.props.tenant)"
          native
        >
          <svg
            class="inline-block w-4 h-4 bi bi-gear-fill text-slate-400"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
          >
            <path
              d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Settings</span>
        </SidebarLink>
        <!-- END Company Overview Link -->

        <template v-if="route().current('companies.*')">
          <!-- Users Management -->
          <SidebarLink
            :minimized="sidebarMinimized"
            :href="route('companies.show', $page.props.tenant)"
            native
          >
            <svg
              class="inline-block w-5 h-4 bi bi-gear-fill text-slate-400"
              :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
            >
              <path
                d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zM1.49 15.326a.78.78 0 01-.358-.442 3 3 0 014.308-3.516 6.484 6.484 0 00-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 01-2.07-.655zM16.44 15.98a4.97 4.97 0 002.07-.654.78.78 0 00.357-.442 3 3 0 00-4.308-3.517 6.484 6.484 0 011.907 3.96 2.32 2.32 0 01-.026.654zM18 8a2 2 0 11-4 0 2 2 0 014 0zM5.304 16.19a.844.844 0 01-.277-.71 5 5 0 019.947 0 .843.843 0 01-.277.71A6.975 6.975 0 0110 18a6.974 6.974 0 01-4.696-1.81z"
              />
            </svg>
            <span v-if="!sidebarMinimized">Settings</span>
          </SidebarLink>
          <!-- END Users Management -->
        </template>
        <!-- END Company Routes -->

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
              :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
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
    </div>
    <!-- END Scroll Wrapper -->
  </nav>

  <!-- Minimize Sidebar Toggler -->
  <div
    v-if="!sidebarMinimized"
    class="hidden lg:block ml-auto fixed top-2 z-[99999]"
    :class="{
      'left-18': sidebarMinimized,
      'left-[14.5rem]': !sidebarMinimized,
    }"
  >
    <a
      v-if="sidebarMinimized"
      href="#"
      class="block p-1 rounded-full bg-slate-200 dark:bg-primary-foreground dark:text-primary text-lg"
      @click.prevent="sidebarMinimized = false"
    >
      <LucideIcon
        class="size-6"
        name="chevron-right"
      />
    </a>
    <a
      v-else
      href="#"
      class="block p-1 rounded-full bg-slate-200 dark:bg-primary-foreground dark:text-primary text-lg"
      @click.prevent="sidebarMinimized = true"
    >
      <LucideIcon
        class="size-6"
        name="chevron-left"
      />
    </a>
  </div>
  <!-- END Minimize Sidebar Toggler -->
</template>

<style lang="scss"></style>
