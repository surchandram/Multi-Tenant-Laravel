<script setup>
  import { computed } from 'vue';
  import { usePage } from "@inertiajs/vue3";
  import SidebarLink from '@/components/tailadmin/SidebarLink.vue';
  import SidebarDropdownLink from '@/components/tailadmin/SidebarDropdownLink.vue';
  import SidebarDropdown from '@/components/tailadmin/SidebarDropdown.vue';

  const resolvedTenantParam = computed(() =>  {
    if (route().current('companies.*')) {
      return usePage().props.model?.company || usePage().props.company;
    }

    return usePage().props.tenant;
  });

  const resolveTenantRoute = (routeName, routeParams = null) => {
    if (!route().current('tenant.*')) {
      return route('tenant.switch', {
        tenant: resolvedTenantParam.value,
        redirect_to: routeName,
        redirect_params: routeParams
      });
    } else {
      return routeParams ? route(routeName, routeParams) : route(routeName);
    }
  }
</script>

<template>
  <aside
    x-data="{
      init() {
        $watch('sidebarMinimized', (minimized) => {
          var menuGroup = document.querySelector('#adminSidebarMenu').querySelectorAll('nav > ul');
          if (minimized) {
            [].forEach.call(menuGroup, function($el) {
              console.log($el);
            })
          } else {
            [].forEach.call(menuGroup, function($el) {
              console.log($el.classList);
            })
          }
        })
      }
    }"
    x-bind:class="{
      'translate-x-0': sidebarToggle,
      '-translate-x-full': !sidebarToggle,
      'lg:w-20 lg:overflow-x-hidden hover:w-72.5 sidebar-minimized': sidebarMinimized
    }"
    id="adminSidebarMenu"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    x-on:click.outside="sidebarToggle = false"
  >
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
      <a
        :href="route('home')"
        class="flex items-center gap-1 text-xl font-semibold text-white"
      >
        <template v-if="$page.props.logoData.has_logo">
          <div
            v-if="$page.props.logoData.logo_html"
            class="w-14"
            v-html="$page.props.logoData.logo_html"
          ></div>
          <img v-else :src="$page.props.logoData.logo" class="w-14" alt="" />
        </template>
        <img v-else :src="`http://${$page.props.appDomain}/logos/cyber_hawk_logo.svg`" class="w-14 bg-slate-50" alt="" />
      </a>

      <button
        class="block lg:hidden"
        x-on:click.stop="sidebarToggle = !sidebarToggle"
      >
        <svg
          class="fill-current"
          width="20"
          height="18"
          viewBox="0 0 20 18"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
            fill=""
          />
        </svg>
      </button>

      <!-- Minimizer -->
      <button
        class="hidden lg:block text-white rounded-full px-2 py-1 hover:bg-slate-100 shadow hover:text-teal-600 focus:ring font-semibold"
        x-on:click.stop="sidebarMinimized = !sidebarMinimized"
      >
        <div>
          <i
            class="text-xl p-0 bi"
            x-bind:class="{ 'bi-arrow-bar-left': !sidebarMinimized, 'bi-arrow-bar-right': sidebarMinimized }"
          ></i>
        </div>
      </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div
      class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear"
    >
      <!-- Sidebar Menu -->
      <nav
        class="mt-5 py-4 px-4 lg:mt-9 lg:px-6"
        x-data="{selected: 'Dashboard'}"
        x-init="
          selected = JSON.parse(localStorage.getItem('selected'));
          $watch('selected', value => localStorage.setItem('selected', JSON.stringify(value)))"
      >
        <!-- Menu Group -->
        <div>
          <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MENU</h3>

          <ul class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item Dashboard -->
            <SidebarLink
              active="tenant.home"
              :plain="!route().current('tenant.*')"
              :href="!route().current('tenant.*') ? route('tenant.switch', resolvedTenantParam) : route('tenant.home')"
            >
              <i class="w-6 h-full bi bi-grid text-2xl"></i> Dashboard
            </SidebarLink>
            <!-- Menu Item Dashboard -->

            <!-- Tenant Routes -->
            <template v-if="!route().current('companies.*')">
              <SidebarDropdown active="restore.projects.*">
                <template #label>
                  <i class="w-6 h-full bi bi-kanban text-2xl"></i>
                  Projects
                </template>

                <!-- Dropdown menu items -->
                <SidebarDropdownLink
                  :href="route('restore.projects.create')"
                  :native="!route().current('restore.*')"
                  active="restore.projects.create"
                >
                  Add Project
                </SidebarDropdownLink>
                <SidebarDropdownLink
                  :href="route('restore.projects.index')"
                  :native="!route().current('restore.*')"
                  active="restore.projects.index"
                >
                  Manage Projects
                </SidebarDropdownLink>
              </SidebarDropdown>
              <!-- Menu Item Restore -->

              <!-- Menu Item Pages -->
              <SidebarLink
                active="restore.schedules.*"
                :href="route('restore.home')"
              >
                <i class="w-6 h-full bi bi-calendar3 text-2xl"></i> Scheduling
              </SidebarLink>

              <!-- Documents Dropdown -->
              <SidebarDropdown active="tenant.documents.*">
                <template #label>
                  <i class="w-6 h-full bi bi-kanban text-2xl"></i>
                  Documents
                </template>

                <!-- Dropdown menu items -->
                <SidebarDropdownLink
                  :href="resolveTenantRoute('tenant.documents.create')"
                  :native="!route().current('tenant.*')"
                  active="tenant.documents.create"
                >
                  Add Document
                </SidebarDropdownLink>
                <SidebarDropdownLink
                  :href="resolveTenantRoute('tenant.documents.index')"
                  :native="!route().current('tenant.*')"
                  active="tenant.documents.index"
                >
                  Manage Documents
                </SidebarDropdownLink>
              </SidebarDropdown>
              <!-- Documents Dropdown -->
            </template>
            <!-- Tenant Routes -->
          </ul>
        </div>

        <!-- Company Settings Group -->
        <div v-if="!route().current('companies.index')">
          <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2 uppercase">Settings</h3>

          <ul class="mb-6 flex flex-col gap-1.5">
            <!-- Menu Item -->
            <SidebarLink
              active="companies.users.*"
              :native="!route().current('companies.*')"
              :href="route('companies.users.index', resolvedTenantParam)"
            >
              <i class="w-6 h-full bi bi-people text-2xl"></i>
              Users Management
            </SidebarLink>
            <!-- Menu Item -->

            <!-- Menu Item -->
            <SidebarLink
              active="companies.show"
              :native="!route().current('companies.*')"
              :href="route('companies.show', resolvedTenantParam)"
            >
              <i class="w-6 h-full bi bi-gear text-2xl"></i>
              Company Settings
            </SidebarLink>
            <!-- Menu Item -->
          </ul>
        </div>
        <!-- /Company Settings Group -->
      </nav>
      <!-- Sidebar Menu -->
    </div>
  </aside>
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
