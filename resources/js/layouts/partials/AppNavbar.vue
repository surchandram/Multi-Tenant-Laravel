<script setup>
  import { Link } from '@inertiajs/vue3';
  import AccountDropdown from '../../components/account/AccountDropdown.vue';
  import AppColorModeSwitcher from '@/components/AppColorModeSwitcher.vue';
</script>

<template>
  <div class="hidden lg:block">
    <div class="container mx-auto">
      <div class="flex items-center py-6">
        <div class="grow">
          <div class="flex items-center">
            <Link
              :href="route('home')"
              class="mr-10.5 dark:bg-primary"
            >
              <img
                :alt="$page.props.appName"
                class
                src="/logos/cyber_hawk_logo.svg"
              />
            </Link>

            <div class="flex">&nbsp;</div>
          </div>
        </div>

        <div class="flex items-center">
          <template v-if="!$page.props.auth.loggedIn">
            <!-- Login Link -->
            <Link
              class="mr-4 font-medium text-sm text-indigo-600 focus:text-indigo-700"
              :href="route('login')"
              >{{ __('app.labels.login') }}</Link
            >
            <!-- END Login Link -->

            <!-- Register Link -->
            <Link
              class="bg-purple-600 text-white rounded-lg font-medium py-2 px-3"
              :href="route('register')"
              >{{ __('app.labels.register_alt') }}</Link
            >
            <!-- END Register Link -->
          </template>

          <template v-else>
            <!-- Account Dropdown -->
            <AccountDropdown />
            <!-- END Account Dropdown -->

            <!-- Dark Mode Switcher -->
            <AppColorModeSwitcher />
            <!-- END Dark Mode Switcher -->
          </template>
        </div>
      </div>
    </div>
  </div>

  <div class="block mb-2 lg:mb-0 lg:hidden">
    <div v-if="!isMenuOpen">
      <div class="container mx-auto">
        <div class="py-6 px-4">
          <div class="flex items-center">
            <Link
              class="mr-auto dark:bg-primary"
              :href="route('home')"
            >
              <img
                :alt="$page.props.appName"
                class="mr-auto"
                src="/logos/cyber_hawk_logo.svg"
              />
            </Link>

            <!-- Dark Mode Switcher -->
            <div class="mx-4">
              <AppColorModeSwitcher size="icon" />
            </div>
            <!-- END Dark Mode Switcher -->

            <button
              class="text-white bg-purple-600 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center"
              @click="openMenu"
            >
              <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <div
        class="w-full min-h-content sticky z-50 bg-slate-100 dark:bg-slate-900 shadow-sm transition ease-in duration-300"
      >
        <div class="container mx-auto">
          <div class="py-6 px-4">
            <div class="flex items-center">
              <div class="mr-auto dark:bg-primary">
                <img
                  :alt="$page.props.appName"
                  src="/logos/cyber_hawk_logo.svg"
                />
              </div>

              <!-- Dark Mode Switcher -->
              <div class="mx-4">
                <AppColorModeSwitcher size="icon" />
              </div>
              <!-- END Dark Mode Switcher -->

              <button
                class="text-white bg-purple-600 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center"
                @click="openMenu"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M6 18L18 6M6 6l12 12"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </button>
            </div>

            <div class="px-4 mt-6 text-center">
              <p class="text-gray-400 text-sm font-medium mb-10 uppercase">Menu</p>

              <template v-if="$page.props.auth.loggedIn">
                <!-- Account Dropdown -->
                <AccountDropdown />
                <!-- END Account Dropdown -->
              </template>

              <template v-else>
                <!-- Login Link -->
                <Link
                  class="block px-4 py-4 mb-6 text-lg font-semibold text-indigo-600 hover:bg-indigo-100 focus:text-indigo-700 focus:ring"
                  :href="route('login')"
                  >{{ __('app.labels.login') }}</Link
                >
                <!-- END Login Link -->

                <!-- Register Link -->
                <Link
                  class="w-2/3 block px-3 py-5 mx-auto rounded-lg text-lg font-medium text-white uppercase bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 focus:ring"
                  :href="route('register')"
                  >{{ __('app.labels.register_alt') }}</Link
                >
                <!-- END Register Link -->
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        isMenuOpen: false,
      };
    },

    methods: {
      openMenu() {
        this.isMenuOpen = !this.isMenuOpen;
      },
    },
  };
</script>
