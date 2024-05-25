<script setup>
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: {
      type: String,
      default: "",
    },
    type: {
      type: String,
      default: "button",
    },
    theme: {
      type: String,
      default: "default",
    },
    plain: {
      type: Boolean,
      default: false,
    },
    rounded: {
      type: Boolean,
      default: true,
    },
    native: {
      type: Boolean,
      default: false,
    },
  });

  const plainClasses =
    "text-slate-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:outline-none disabled:opacity-25";

  const themes = {
    default:
      "bg-indigo-500 text-white active:bg-indigo-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    success:
      "bg-teal-500 text-white hover:bg-teal-600 active:bg-teal-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    info:
      "bg-blue-500 text-white hover:bg-blue-600 active:bg-blue-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    secondary: "bg-gray-500 text-white hover:bg-gray-600 active:bg-gray-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    danger: "bg-rose-500 text-white hover:bg-rose-600 active:bg-rose-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    warning: "bg-yellow-500 text-white hover:bg-yellow-600 active:bg-yellow-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    outline:
      "text-indigo-500 hover:text-white hover:bg-indigo-600 active:bg-indigo-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    "outline-success":
      "text-teal-500 hover:text-white hover:bg-teal-600 active:bg-teal-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    "outline-info":
      "text-blue-500 hover:text-white hover:bg-blue-600 active:bg-blue-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    "outline-secondary": "text-gray-500 hover:text-white hover:bg-gray-600 active:bg-gray-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    "outline-danger": "text-rose-500 hover:text-white hover:bg-rose-600 active:bg-rose-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
    "outline-warning": "text-yellow-500 hover:text-white hover:bg-yellow-600 active:bg-yellow-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:ring focus:outline-none disabled:opacity-25",
  };
</script>

<template>
  <component
    :is="native ? 'a' : Link"
    v-if="href"
    :href="href"
    :class="[plain ? plainClasses : themes[theme] || themes['default'], rounded ? '' : '!rounded-none']"
    style="transition:all .15s ease"
  >
    <slot></slot>
  </component>
  <button
    v-else
    :class="[plain ? plainClasses : themes[theme] || themes['default'], rounded ? '' : '!rounded-none']"
    :type="props.type"
    style="transition:all .15s ease"
  >
    <slot></slot>
  </button>
</template>
