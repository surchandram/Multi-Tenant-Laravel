<script setup>
  import { Link } from "@inertiajs/vue3";
  import NavbarLink from './NavbarLink.vue';
</script>

<template>
  <nav
    x-data="{
      showMenu: false,
      toggleNavbar() {
        this.showMenu = !this.showMenu;
      }
    }"
    class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 "
  >
    <div
      class="container px-4 mx-auto flex flex-wrap items-center justify-between"
    >
      <div
        class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start"
      >
        <Link
          class="flex items-center gap-2 text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white"
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
        <!-- Navbar Toggler -->
        <button
          class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
          type="button"
          x-on:click="toggleNavbar()"
        >
          <i class="text-white bi bi-list"></i>
        </button>
      </div>
      <div
        class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none"
        x-bind:class="{'hidden': !showMenu, 'block': showMenu}"
      >
        <ul class="flex flex-col lg:flex-row list-none mr-auto">
        </ul>
        <ul class="flex flex-col gap-2 lg:flex-row list-none lg:ml-auto">
          <!-- Apps -->
          <NavbarLink :href="route('apps.index')" current="apps.index">
            Apps
          </NavbarLink>

          <!-- Docs -->
          <NavbarLink native :href="route('docs.index')" current="docs.index" target="_blank">
            Docs
          </NavbarLink>

          <!-- Auth Links -->
          <template v-if="$page.props.auth.loggedIn">
            <!-- Dashboard -->
            <NavbarLink
              native
              :href="route('dashboard')"
              current="dashboard"
            >
              <i class="bi bi-speedometer mr-2 text-lg"></i> Dashboard
            </NavbarLink>
          </template>

          <!-- Guest Links -->
          <template v-else>
            <li class="flex items-center">
              <button
                class="flex items-center gap-1 bg-teal-600 text-gray-100 active:bg-teal-800 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                style="transition: all 0.15s ease 0s;"
                :href="route('register')"
              >
                <i class="bi bi-person-plus text-lg"></i> Get Started
              </button>
            </li>
            <li class="flex items-center">
              <Link
                class="flex items-center gap-1 bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                style="transition: all 0.15s ease 0s;"
                :href="route('login')"
              >
                <i class="bi bi-fingerprint text-lg"></i> Login
              </Link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>
