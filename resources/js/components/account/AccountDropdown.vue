<script setup>
  import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
  import { Link } from '@inertiajs/vue3';

  defineProps({
    native: {
      type: Boolean,
      default: false,
    },
    hideSmall: {
      type: Boolean,
      default: false,
    },
    right: {
      type: Boolean,
      default: false,
    },
  });
</script>

<template>
  <Menu
    v-slot="{ close }"
    as="div"
    class="relative inline-block text-left dark:text-muted"
  >
    <div>
      <MenuButton
        class="w-full inline-flex items-center justify-center gap-2 rounded-md px-4 py-2 font-medium hover:bg-indigo-600 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 dark:text-primary"
      >
        <img
          :src="$page.props.auth.user.avatar"
          alt
          class="w-8 h-8 rounded-full"
        />
        <span :class="{ 'hidden sm:inline': hideSmall }">{{ __('app.labels.account') }}</span>
        <i class="bi bi-chevron-down text-sm leading-none"></i>
      </MenuButton>
    </div>

    <!-- Transition -->
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        :class="{ 'right-0': right, '-left-10': !right }"
        class="w-60 md:w-56 mt-2 absolute md:left-auto md:right-0 md:origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <div class="py-1">
          <!-- Greetings -->
          <MenuItem as="div">
            <div class="px-3 py-2 font-medium text-sm text-slate-600">
              {{ __('app.labels.greetings', { name: $page.props.auth.user.first_name }) }}
            </div>
          </MenuItem>
          <!-- END Greetings -->

          <!-- Dashboard -->
          <MenuItem as="div">
            <component
              :is="native ? 'a' : Link"
              class="block py-2 px-3 text-indigo-400 hover:bg-indigo-100 hover:text-slate-600 focus:text-slate-600 font-medium"
              :href="route('dashboard')"
              @click="close"
              >{{ __('app.labels.my_dashboard') }}</component
            >
          </MenuItem>
          <!-- END Dashboard -->

          <!-- Account -->
          <MenuItem as="div">
            <component
              :is="native ? 'a' : Link"
              class="block py-2 px-3 text-indigo-400 hover:bg-indigo-100 hover:text-slate-600 focus:text-slate-600 font-medium"
              :href="route('account.index')"
              @click="close"
              >{{ __('app.labels.manage_account') }}</component
            >
          </MenuItem>
          <!-- END Account -->

          <div v-permission="'browse-admin'">
            <div class="my-2 border-t-2 border-indigo-200"></div>

            <!-- Admin Items -->

            <!-- Admin -->
            <MenuItem as="div">
              <div class="px-3 py-2 font-medium text-sm text-slate-600">{{ __('app.labels.admin_options') }}</div>
            </MenuItem>
            <!-- END Admin -->

            <!-- Admin Dashboard -->
            <MenuItem as="div">
              <component
                :is="native ? 'a' : Link"
                class="block py-2 px-3 text-indigo-400 hover:bg-indigo-100 hover:text-slate-600 focus:text-slate-600 font-medium"
                :href="route('admin.dashboard')"
                @click="close"
                >{{ __('app.labels.admin_dashboard') }}</component
              >
            </MenuItem>
            <!-- END Admin Dashboard -->
          </div>
          <!-- END Admin Items -->

          <MenuItem
            as="div"
            class="border-t border-slate-100"
          >
            <!-- Logout Form -->
            <form
              method="POST"
              :action="route('logout')"
              class="block"
            >
              <input
                type="hidden"
                name="_token"
                :value="$page.props.csrf_token"
              />

              <button
                type="submit"
                class="w-full inline-flex gap-2 items-center px-3 py-2 hover:text-slate-600 text-slate-600 font-medium"
              >
                <!-- <i class="bi bi-unlock"></i> -->
                {{ __('app.labels.logout') }}
              </button>
            </form>
            <!-- END Logout Form -->
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
    <!-- END Transition -->
  </Menu>
</template>
