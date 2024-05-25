<script setup>
  import { computed } from 'vue';

  const props = defineProps({
    size: {
      type: Number,
      default: 6
    },
    color: {
      type: String,
      default: 'border-slate-100'
    },
  });

  const spinnerSize = computed(() => {
    return `w-${props.size} h-${props.size}`;
  });

  const spinnerColor = computed(() => {
    return props.color;
  });
</script>

<template>
  <span
    class="inline-flex animate-spin border border-t-0 rounded-full"
    :class="[spinnerSize, spinnerColor]"
    role="status"
    aria-hidden="true"
  ></span>
</template>
