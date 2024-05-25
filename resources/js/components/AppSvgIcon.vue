<script setup>
  import LucideIcon from './LucideIcon.vue';

  const props = defineProps({
    name: {
      required: true,
      type: String,
    },
    size: {
      required: false,
      type: [Number, String],
      default: 24,
    },
    variant: {
      required: false,
      type: String,
      default: '',
    },
    fill: {
      type: String,
      default: 'currentColor',
    },
  });
</script>

<template>
  <LucideIcon
    v-bind="$attrs"
    :name="name"
    :width="size"
    :height="size"
  />
</template>
./LucideIcon.vue
