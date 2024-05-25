<script setup>
  defineProps({
    label: { 
      type: String,
      required: true
    },
    value: { 
      required: true
    }
  });
</script>

<template>
  <div
    class="
      px-4
      py-2
      inline-flex
      justify-between
      md:block
      even:bg-slate-200
    "
  >
    <span class="md:hidden">{{ label }}</span>
    <span>{{ value }}</span>
  </div>
</template>
