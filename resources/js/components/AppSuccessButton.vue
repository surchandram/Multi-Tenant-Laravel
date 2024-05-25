<script setup>
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'button'
    },
  });

  const classes = "bg-teal-500 text-white hover:bg-teal-600 active:bg-teal-600 text-sm font-semibold px-3 py-2 rounded outline-none focus:outline-none disabled:opacity-25";
</script>

<template>
  <Link
    v-if="href"
    :href="href"
    :class="classes"
    style="transition:all .15s ease"
  >
    <slot></slot>
  </Link>
  <button
    v-else
    :class="classes"
    :type="props.type"
    style="transition:all .15s ease"
  >
    <slot></slot>
  </button>
</template>
