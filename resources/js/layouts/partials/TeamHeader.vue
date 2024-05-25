<script setup>
  import HeaderUserDropdown from "@/components/team/HeaderUserDropdown.vue";
</script>

<template>
  <header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1 dark:bg-boxdark dark:drop-shadow-none">
    <div class="flex flex-grow items-center justify-between py-4 px-4 shadow-2 md:px-6 2xl:px-11">
      <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
        <!-- Hamburger Toggle BTN -->
        <button
          class="z-99999 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden"
          x-on:click.stop="sidebarToggle = !sidebarToggle"
        >
          <span class="relative block h-5.5 w-5.5 cursor-pointer">
            <span class="du-block absolute right-0 h-full w-full">
              <span
                class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out dark:bg-white"
                x-bind:class="{ '!w-full delay-300': !sidebarToggle }"></span>
              <span
                class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white"
                x-bind:class="{ '!w-full delay-400': !sidebarToggle }"></span>
              <span
                class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white"
                x-bind:class="{ '!w-full delay-500': !sidebarToggle }"></span>
            </span>
            <span class="du-block absolute right-0 h-full w-full rotate-45">
              <span
                class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out dark:bg-white"
                x-bind:class="{ 'h-0 delay-[0]': !sidebarToggle }"></span>
              <span
                class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out dark:bg-white"
                x-bind:class="{ 'h-0 dealy-200': !sidebarToggle }"></span>
            </span>
          </span>
        </button>      
        <!-- Hamburger Toggle BTN -->
      </div>
      <div class="hidden sm:block">
        <!-- <x-header-search-form /> -->
      </div>

      <div class="flex items-center gap-3 2xsm:gap-7">
        <ul class="flex items-center gap-2 2xsm:gap-4">
          <li>
            <!-- Dark Mode Toggler -->
            <!-- <x-dark-mode-toggler /> -->
            <!-- Dark Mode Toggler -->
          </li>

          <!-- Notification Menu Area -->
          <template v-if="$page.props.settings.in_app_notifications">
            <!-- <x-header-notification-dropdown /> -->
          </template>
          <!-- Notification Menu Area -->

          <!-- Chat Notification Area -->
          <template v-if="$page.props.settings['chat.enabled']">
            <!-- <x-header-chat-dropdown /> -->
          </template>
          <!-- Chat Notification Area -->
        </ul>

        <!-- User Area -->
        <HeaderUserDropdown />
        <!-- User Area -->
      </div>
    </div>
  </header>
</template>
