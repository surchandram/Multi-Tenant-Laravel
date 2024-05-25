<script setup>
  import { ref } from 'vue';
  import { vOnClickOutside } from '@vueuse/components';
  import ChevronDown from '@/components/ChevronDown.vue';

  const props = defineProps({
    id: {
      type: String,
      default: Date.now() + 'dropdownMenuButton',
    },
    label: {
      type: String,
      default: 'Actions',
    },
    positioned: {
      type: Boolean,
      default: true,
    },
    alignment: {
      type: String,
      default: 'dropdown',
    },
    contentWrapper: {
      type: String,
      default: 'ul',
    },
    contentClasses: {
      type: [Array, String],
      default: '',
    },
    triggerButton: {
      type: Boolean,
      default: false,
    },
  });

  const show = ref(false);

  const hideDropdown = () => (show.value = false);

  const toggleDropdown = () => (show.value = !show.value);
</script>

<template>
  <div
    v-on-click-outside="hideDropdown"
    :class="[positioned ? 'relative' : '', alignment]"
  >
    <slot
      name="trigger"
      :show-dropdown="show"
      :toggle-dropdown="toggleDropdown"
      :hide-dropdown="hideDropdown"
    >
      <button
        v-if="triggerButton"
        :id="props.id"
        class="dropdown-toggle px-2 py-2.5 bg-blue-600 text-white text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg active:text-white transition duration-150 ease-in-out flex items-center whitespace-nowrap"
        type="button"
        aria-expanded="false"
        @click="toggleDropdown"
      >
        <div class="flex-1">{{ props.label }}</div>
        <ChevronDown
          class="w-2 ml-2"
          :open="show"
        />
      </button>
      <a
        v-else
        :id="props.id"
        href="#"
        class="dropdown-toggle px-2 py-2.5 text-gray-600 leading-tight rounded hover:text-gray-700 focus:text-gray-700 focus:outline-none focus:ring-0 active:text-gray-800 transition duration-150 ease-in-out flex items-center whitespace-nowrap dark:text-slate-200"
        type="button"
        :aria-expanded="show"
        @click.prevent="toggleDropdown"
      >
        <div class="flex-1">{{ props.label }}</div>
        <ChevronDown
          class="w-2 ml-2"
          :open="show"
        />
      </a>
    </slot>

    <!-- Dropdown Content Wrapper -->
    <component
      :is="contentWrapper"
      class="dropdown-menu min-w-max py-2 mt-1 m-0 bg-white text-base text-left rounded-lg shadow-lg bg-clip-padding border-none absolute z-50 dark:bg-slate-800 dark:text-white"
      :class="[{ hidden: !show }, contentClasses]"
      :aria-labelledby="props.id"
    >
      <slot
        :show-dropdown="show"
        :toggle-dropdown="toggleDropdown"
        :hide-dropdown="hideDropdown"
      ></slot>
    </component>
    <!-- /Dropdown Content Wrapper -->
  </div>
</template>
