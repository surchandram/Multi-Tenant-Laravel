<script setup>
  import { ref } from 'vue';
  import { vOnClickOutside } from '@vueuse/components';
  import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
  import LucideIcon from '../LucideIcon.vue';

  defineProps({
    sidebarMinimized: {
      type: Boolean,
      default: false,
    },
  });

  const toggleCompanyPopover = ref(false);
</script>

<template>
  <Popover
    class="w-full"
    :default-value="$page.props.tenant"
  >
    <div
      v-on-click-outside="() => (toggleCompanyPopover = false)"
      class="min-w-full mt-1 px-px relative"
    >
      <!-- Current Company -->
      <PopoverButton
        class="w-full flex items-center px-1 py-2 space-x-2 bg-indigo-50 ring-2 ring-indigo-100 rounded-lg relative text-left focus:outline-none focus-visible:ring-indigo-500 focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300 sm:text-sm font-medium cursor-pointer dark:bg-slate-800 dark:ring-slate-900"
        as="div"
        @click="toggleCompanyPopover = !toggleCompanyPopover"
      >
        <!-- Company Logo -->
        <img
          :src="$page.props.tenant?.logo"
          alt
          class="w-8 h-8"
        />
        <!-- END Company Logo -->

        <span v-if="!sidebarMinimized">{{ $page.props.tenant.name }}</span>

        <div class="absolute right-3">
          <LucideIcon
            name="chevrons-up-down"
            class="h-4 w-4"
          />
        </div>
      </PopoverButton>
      <!-- END Current Company -->

      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="translate-y-1 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-1 opacity-0"
      >
        <div v-show="toggleCompanyPopover">
          <!-- Popover: Companies List -->
          <PopoverPanel
            static
            :class="[sidebarMinimized ? 'fixed' : 'absolute']"
            class="w-full md:w-52 flex flex-col -space-y-px mt-1 overflow-auto rounded-md bg-slate-50 px-1 py-1 text-base shadow-lg ring-1 ring-indigo-100/5 focus:outline-none sm:text-sm z-[99] dark:bg-secondary dark:text-primary"
          >
            <!-- Company Link -->
            <a
              v-for="company in $page.props.auth.user.companies"
              :key="company.id"
              :href="route('tenant.switch', company)"
              :title="company.name"
              :class="[
                $page.props.tenant.id == company.id
                  ? 'bg-slate-100 text-indigo-600 font-medium cursor-default dark:bg-primary-foreground dark:text-primary'
                  : 'text-slate-600 hover:bg-indigo-200 active:bg-indigo-200 dark:text-primary',
                'relative',
              ]"
              class="inline-flex items-center py-2 px-4 gap-2 truncate"
            >
              <!-- Company Logo -->
              <img
                :src="company?.logo"
                alt
                class="w-6 h-6"
              />
              <!-- END Company Logo -->

              <!-- Company Name -->
              <span>{{ company.name }}</span>
              <!-- END Company Name -->

              <span
                v-if="$page.props.tenant.id == company.id"
                class="flex items-center ml-auto text-indigo-600"
              >
                <LucideIcon
                  name="check"
                  class="h-5 w-5"
                  aria-hidden="true"
                />
              </span>
            </a>
            <!-- END Company Link -->
          </PopoverPanel>
          <!-- END Popover: Companies List -->
        </div>
      </transition>
    </div>
  </Popover>
</template>
