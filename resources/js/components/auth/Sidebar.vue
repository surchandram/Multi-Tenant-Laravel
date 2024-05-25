<script setup>
  import { ref } from "vue";
  import { Link } from "@inertiajs/vue3";
  import NotificationDropdown from "./NotificationDropdown.vue";
  import SidebarHeading from "./SidebarHeading.vue";
  import SidebarLink from "./SidebarLink.vue";
  import UserDropdown from "./UserDropdown.vue";

  const collapseShow = ref('hidden');

  const toggleCollapseShow = (classes) => {
    collapseShow.value = classes;
  };
</script>

<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
      >
        <i class="bi bi-list"></i>
      </button>
      <!-- Brand -->
      <Link
        class="flex items-center text-left md:pb-2 text-slate-600 mr-0 whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
        :href="route('home')"
      >
        <template v-if="$page.props.logoData.has_logo">
          <div
            v-if="$page.props.logoData.logo_html"
            v-html="$page.props.logoData.logo_html"
          ></div>
          <img v-else :src="$page.props.logoData.logo" alt="" />
        </template>
        {{ $page.props.appName }}
      </Link>
      <!-- /Brand -->

      <!-- User + Notifications -->
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <NotificationDropdown />
        </li>
        <li class="inline-block relative">
          <UserDropdown />
        </li>
      </ul>
      <!-- /User + Notifications -->

      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow"
      >
        <!-- Collapse header -->
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-slate-200"
        >
          <div class="flex flex-wrap">
            <!-- Brand -->
            <div class="w-6/12">
              <a
                class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
                href="javascript:void(0)"
              >
                {{ $page.props.appName }}
              </a>
            </div>
            <!-- /Brand -->

            <!-- Sidebar Toggler -->
            <div class="w-6/12 flex justify-end">
              <button
                type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')"
              >
                <i class="bi bi-x"></i>
              </button>
            </div>
            <!-- /Sidebar Toggler -->
          </div>
        </div>
        <!-- /Collapse header -->

        <!-- Search Form -->
        <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input
              type="text"
              placeholder="Search"
              class="border-0 px-3 py-2 h-12 border border-solid  border-slate-500 placeholder-slate-300 text-slate-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal"
            />
          </div>
        </form>
        <!-- /Search Form -->

        <!-- Navigation -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <SidebarLink :href="route('dashboard')" active="dashboard">
            <template #icon="{ iconStyles }">
              <i class="bi bi-speedometer" :class="iconStyles"></i>
            </template>
            Dashboard
          </SidebarLink>

          <SidebarLink :href="route('teams.index')" active="teams.*">
            <template #icon="{ iconStyles }">
              <i class="bi bi-newspaper" :class="iconStyles"></i>
            </template>
            Teams
          </SidebarLink>

          <SidebarLink v-if="!$page.props.auth.user.has_avatar" :href="route('account.index')" is-action>
            <template #icon="{ iconStyles }">
              <i class="bi bi-person-circle" :class="iconStyles"></i>
            </template>
            Upload Profile Image
          </SidebarLink>
        </ul>
        <!-- /Navigation -->

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />

        <!-- Heading -->
        <SidebarHeading label="Other Resources" />
        <!-- /Heading -->

        <!-- Navigation -->
        <ul
          class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4"
        >
          <SidebarLink native :href="route('support.tickets.index')">
            <template #icon="{ iconStyles }">
              <i class="bi bi-tags" :class="iconStyles"></i>
            </template>
            Support Tickets
          </SidebarLink>
          <SidebarLink native :href="route('docs.index')" target="_blank">
            <template #icon="{ iconStyles }">
              <i class="bi bi-files" :class="iconStyles"></i>
            </template>
            Documentation
          </SidebarLink>
        </ul>
        <!-- /Navigation -->
      </div>
    </div>
  </nav>
</template>
