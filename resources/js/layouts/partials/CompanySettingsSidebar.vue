<script setup>
  import { watch, ref, onMounted } from 'vue';
  import { vOnClickOutside } from '@vueuse/components';
  import { router } from '@inertiajs/vue3';
  import SidebarLink from '@/components/tailapp/SidebarLink.vue';
  import AppLanguageSelector from '@/components/AppLanguageSelector.vue';

  const props = defineProps({
    minimized: {
      type: Boolean,
      default: false,
    },
  });

  const logoutForm = ref(null);
  const isOnTenantRoute = ref(route().current('tenant.*'));
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

    router.on('finish', () => {
      isOnTenantRoute.value = route().current('tenant.*');
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
          :href="route('tenant.switch', $page.props.model.company || $page.props.tenant)"
          class="inline-flex items-center space-x-2 text-lg leading-none font-bold tracking-wide transition text-slate-800 hover:opacity-75 active:opacity-100"
          :class="{
            'ml-1': sidebarMinimized,
          }"
        >
          <img
            v-if="$page.props.model.company?.logo"
            :src="$page.props.model.company?.logo"
            alt
            class="w-16 h-16"
          />
          <img
            v-else
            :src="$page.props.logoData['small']"
            alt
            class="w-16 h-16"
          />
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
        v-on-click-outside="closeMobileSidebar"
        class="w-full p-4 space-y-3 grow"
      >
        <!-- Dashboard -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="
            route().current('tenant.*')
              ? route('tenant.home')
              : route('tenant.switch', $page.props.model.company || $page.props.tenant)
          "
          :native="!isOnTenantRoute"
          active="tenant.switch"
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

        <!-- Company Overview -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="route('companies.show', $page.props.model.company || $page.props.tenant)"
          :native="isOnTenantRoute"
          active="companies.show"
        >
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
          <span v-if="!sidebarMinimized">Overview</span>
        </SidebarLink>
        <!-- END Company Overview -->

        <!-- Update Company Domain -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="route('companies.domain.index', $page.props.model.company || $page.props.tenant)"
          :native="isOnTenantRoute"
          active="companies.domain.index"
        >
          <svg
            class="inline-block w-4 h-4 bi bi-globe text-slate-400"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Change Domain</span>
        </SidebarLink>
        <!-- END Update Company Domain -->

        <!-- Users Management -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="route('companies.users.index', $page.props.model.company || $page.props.tenant)"
          :native="isOnTenantRoute"
          active="companies.users.*"
        >
          <svg
            class="inline-block w-5 h-4 bi bi-gear-fill text-slate-400"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zM1.49 15.326a.78.78 0 01-.358-.442 3 3 0 014.308-3.516 6.484 6.484 0 00-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 01-2.07-.655zM16.44 15.98a4.97 4.97 0 002.07-.654.78.78 0 00.357-.442 3 3 0 00-4.308-3.517 6.484 6.484 0 011.907 3.96 2.32 2.32 0 01-.026.654zM18 8a2 2 0 11-4 0 2 2 0 014 0zM5.304 16.19a.844.844 0 01-.277-.71 5 5 0 019.947 0 .843.843 0 01-.277.71A6.975 6.975 0 0110 18a6.974 6.974 0 01-4.696-1.81z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Users</span>
        </SidebarLink>
        <!-- END Users Management -->

        <!-- Billing Link -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="route('companies.subscriptions.index', $page.props.model.company || $page.props.tenant)"
          :native="isOnTenantRoute"
          active="companies.subscriptions.index,companies.subscriptions.swap.index"
        >
          <svg
            class="inline-block w-4 h-4 bi bi-file-earmark-text-fill text-slate-400"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Billing</span>
        </SidebarLink>
        <!-- END Billing Link -->

        <!-- Update Card Link -->
        <SidebarLink
          v-if="$page.props.model.company || $page.props.tenant.has_subscription"
          :minimized="sidebarMinimized"
          :href="
            route('companies.subscriptions.payment-methods.index', $page.props.model.company || $page.props.tenant)
          "
          :native="isOnTenantRoute"
          active="companies.subscriptions.payment-methods.*"
        >
          <svg
            class="inline-block w-4 h-4 bi bi-credit-card-2-front text-slate-400"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"
            />
            <path
              d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Update Card</span>
        </SidebarLink>
        <!-- END Update Card Link -->

        <!-- Documents -->
        <SidebarLink
          :minimized="sidebarMinimized"
          :href="
            route().current('tenant.*')
              ? route('tenant.documents.index')
              : route('tenant.switch', {
                  tenant: $page.props.model.company || $page.props.tenant,
                  redirect_to: 'tenant.documents.index',
                })
          "
          :native="!isOnTenantRoute"
          active="tenant.documents.*"
          class="min-w-full cursor-pointer relative"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="inline-block w-4 h-4 text-slate-400 bi bi-file-doc"
            :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
            viewBox="0 0 16 16"
          >
            <path
              fill-rule="evenodd"
              d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5Zm-7.839 9.166v.522c0 .256-.039.47-.117.641a.861.861 0 0 1-.322.387.877.877 0 0 1-.469.126.883.883 0 0 1-.471-.126.868.868 0 0 1-.32-.386 1.55 1.55 0 0 1-.117-.642v-.522c0-.257.04-.471.117-.641a.868.868 0 0 1 .32-.387.868.868 0 0 1 .471-.129c.176 0 .332.043.469.13a.861.861 0 0 1 .322.386c.078.17.117.384.117.641Zm.803.519v-.513c0-.377-.068-.7-.205-.972a1.46 1.46 0 0 0-.589-.63c-.254-.147-.56-.22-.917-.22-.355 0-.662.073-.92.22a1.441 1.441 0 0 0-.589.627c-.136.271-.205.596-.205.975v.513c0 .375.069.7.205.973.137.271.333.48.59.627.257.144.564.216.92.216.357 0 .662-.072.916-.216.256-.147.452-.356.59-.627.136-.274.204-.598.204-.973ZM0 11.926v4h1.459c.402 0 .735-.08.999-.238a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.59-.68c-.263-.156-.598-.234-1.004-.234H0Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.141 1.141 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082H.79V12.57Zm7.422.483a1.732 1.732 0 0 0-.103.633v.495c0 .246.034.455.103.627a.834.834 0 0 0 .298.393.845.845 0 0 0 .478.131.868.868 0 0 0 .401-.088.699.699 0 0 0 .273-.248.8.8 0 0 0 .117-.364h.765v.076a1.268 1.268 0 0 1-.226.674c-.137.194-.32.345-.55.454a1.81 1.81 0 0 1-.786.164c-.36 0-.664-.072-.914-.216a1.424 1.424 0 0 1-.571-.627c-.13-.272-.194-.597-.194-.976v-.498c0-.379.066-.705.197-.978.13-.274.321-.485.571-.633.252-.149.556-.223.911-.223.219 0 .421.032.607.097.187.062.35.153.489.272a1.326 1.326 0 0 1 .466.964v.073H9.78a.85.85 0 0 0-.12-.38.7.7 0 0 0-.273-.261.802.802 0 0 0-.398-.097.814.814 0 0 0-.475.138.868.868 0 0 0-.301.398Z"
            />
          </svg>
          <span v-if="!sidebarMinimized">Documents</span>
        </SidebarLink>
        <!-- END Documents -->
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
              :class="{ 'w-5 h-5 mx-auto': sidebarMinimized }"
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
            <span v-if="!sidebarMinimized">Language</span>
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
