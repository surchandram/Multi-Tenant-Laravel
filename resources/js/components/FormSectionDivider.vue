<script setup>
  const props = defineProps({
    value: String,
  });
</script>

<template>
  <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
    <div class="w-12">
      <div class="w-full h-0 border-t-2 border-blue-600">&nbsp;</div>
    </div>
    <p class="text-lg font-semibold"><slot>{{ props.value }}</slot></p>
  </div>
</template>
