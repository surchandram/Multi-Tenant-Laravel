<script setup>
  const props = defineProps({
    value: String,
  });
</script>

<template>
  <label class="text-sm text-slate-600 dark:text-slate-100 font-semibold">
    <slot>{{ props.value }}</slot>
  </label>
</template>
