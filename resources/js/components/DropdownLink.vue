<script>
export default {
  inheritAttrs: false
};
</script>

<script setup>
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    type: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: 'Dropdown Action'
    },
    img: {
      type: String,
      default: ''
    },
    linkStyles: {
      type: [Array, String],
      default: [
        'dropdown-item',
        'text-sm',
        'py-2',
        'px-4',
        'font-normal',
        'block',
        'w-full',
        'whitespace-nowrap',
        'bg-transparent',
        'text-gray-700',
        'hover:bg-gray-100',
        'transition',
        'duration-150',
        'ease-in-out',
      ]
    },
    href: String
  });
</script>

<template>
  <Link
    v-if="type == 'link'"
    v-bind="$attrs"
    aria-current="true"
    :class="linkStyles"
    :href="props.href"
  >
    <!-- Icon -->
    <slot name="icon" />
    <slot>
      {{ props.label }}
    </slot>
  </Link>

  <template v-if="type == 'plain'">
    <slot></slot>
  </template>

  <a
    v-else
    v-bind="$attrs"
    aria-current="true"
    :class="linkStyles"
    :href="props.href"
    data-mdb-ripple="true"
    data-mdb-ripple-color="light"
  >
    <!-- Icon -->
    <slot name="icon" />
    <slot>
      {{ props.label }}
    </slot>
  </a>
</template>
