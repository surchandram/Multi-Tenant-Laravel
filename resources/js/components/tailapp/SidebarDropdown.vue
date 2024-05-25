<script setup>
  import { reactive, ref, watch, onMounted } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { Menu, MenuButton, MenuItems } from '@headlessui/vue';
  import SidebarLink from './SidebarLink.vue';

  const props = defineProps({
    href: String,
    active: String,
    plain: Boolean,
    minimized: Boolean,
  });

  const opened = ref(false);

  const state = reactive({
    defaultStyles:
      'group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4',
    activeStyles: 'bg-graydark dark:bg-meta-4',
    isActive: false,
  });

  onMounted(() => {
    router.on('navigate', () => {
      const isCurrent = route().current(props.active);

      state.isActive = isCurrent;
      opened.value = isCurrent;
    });

    watch(
      () => props.minimized,
      (val) => {
        opened.value = val === true ? false : opened.value;
      },
    );
  });
</script>

<template>
  <Menu
    v-slot="{ open }"
    as="div"
    class="w-full flex flex-col relative text-left"
  >
    <MenuButton
      as="template"
      @click="$eventBus.emit('expand-sidebar', $attrs.id)"
    >
      <SidebarLink
        as="div"
        href="#"
        class="cursor-pointer"
        @click.prevent="opened = !opened"
      >
        <slot name="label" />

        <div
          v-if="!minimized"
          class="!ml-auto justify-self-end"
        >
          <svg
            class="fill-current"
            :class="{ 'rotate-180': open }"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
              fill
            />
          </svg>
        </div>
      </SidebarLink>
    </MenuButton>

    <!-- Dropdown Menu Start -->
    <MenuItems
      static
      class="w-full static z-50"
    >
      <div
        v-if="opened || (state.isActive && !minimized)"
        class="sidebar-dropdown-menu mt-4 mb-5.5 flex flex-col gap-2.5 pl-6"
      >
        <slot></slot>
      </div>
    </MenuItems>
    <!-- Dropdown Menu End -->
  </Menu>
</template>
