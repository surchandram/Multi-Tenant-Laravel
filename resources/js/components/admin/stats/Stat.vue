<script setup>
  const props = defineProps([
    'label',
    'value',
    'meta',
  ]);
</script>

<template>
  <slot :data="props"></slot>
</template>
