<script setup>
  import { computed } from "vue";

  const props = defineProps({
    errors: [Object, Array],
  });

  const hasErrors = computed(() => _.size(props.errors));
</script>

<template>
  <div v-show="hasErrors" class="flex flex-col px-4 py-3 rounded text-red-600 bg-red-200">
    <ul
      class="px-2 space-y-2 list-disc text-sm font-semibold"
    >
      <li v-for="(message, index) in errors" :key="index">{{ message }}</li>
    </ul>
  </div>
</template>
