<script setup>
  const props = defineProps([
    'label',
  ]);
  
</script>

<template>
  <!-- Heading -->
  <h6
    class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
  >
    <slot>{{ props.label }}</slot>
  </h6>
  <!-- /Heading -->
</template>
