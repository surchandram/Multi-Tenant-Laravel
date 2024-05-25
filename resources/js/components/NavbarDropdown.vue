<script setup>
  // import DropdownLink from './DropdownLink.vue';

  const props = defineProps({
    id: {
      type: String,
      default: Date.now() + 'dropdownMenuButton'
    },
    label: {
      type: String,
      default: 'Actions'
    },
    alignment: {
      type: String,
      default: 'dropdown'
    },
    contentClasses: {
      type: [Array, String],
      default: ''
    },
    triggerButton: {
      type: Boolean,
      default: false
    }
  });
</script>

<template>
  <div class="relative" :class="[alignment]">
    <slot name="trigger">
      <button
        v-if="triggerButton"
        :id="props.id"
        class="
          dropdown-toggle
          px-2
          py-2.5
          bg-blue-600
          text-white
          text-xs
          leading-tight
          uppercase
          rounded
          shadow-md
          hover:bg-blue-700 hover:shadow-lg
          focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
          active:bg-blue-800 active:shadow-lg active:text-white
          transition
          duration-150
          ease-in-out
          flex
          items-center
          whitespace-nowrap
        "
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        {{ props.label }}
        <svg
          aria-hidden="true"
          focusable="false"
          data-prefix="fas"
          data-icon="caret-down"
          class="w-2 ml-2"
          role="img"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 320 512"
        >
          <path
            fill="currentColor"
            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
          ></path>
        </svg>
      </button>
      <a
        v-else
        :id="props.id"
        href="#"
        class="
          dropdown-toggle
          px-2
          py-2.5
          text-gray-600
          leading-tight
          rounded
          hover:text-gray-700
          focus:text-gray-700
          focus:outline-none
          focus:ring-0
          active:text-gray-800
          transition
          duration-150
          ease-in-out
          flex
          items-center
          whitespace-nowrap
        "
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        {{ props.label }}
        <svg
          aria-hidden="true"
          focusable="false"
          data-prefix="fas"
          data-icon="caret-down"
          class="w-2 ml-2"
          role="img"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 320 512"
        >
          <path
            fill="currentColor"
            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
          ></path>
        </svg>
      </a>
    </slot>
    <ul
      class="
        dropdown-menu min-w-max absolute hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none left-auto right-0
      "
      :class="contentClasses"
      :aria-labelledby="props.id"
    >
      <slot></slot>
    </ul>
  </div>
</template> 
