<script setup>
  const props = defineProps({
    label: {
      type: String,
      default: 'Dropdown Header'
    }
  });
</script>

<template>
  <h6
    class="
      text-gray-500
      font-semibold
      text-sm
      py-2
      px-4
      block
      w-full
      whitespace-nowrap
      bg-transparent
    "
  >
    <slot>{{ props.label }}</slot>
  </h6>
</template>
