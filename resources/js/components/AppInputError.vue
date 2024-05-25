<script setup>
  import { computed } from "vue";

  const props = defineProps({
    message: String,
  });
</script>

<template>
  <div v-show="message">
    <p
      class="mt-2 text-sm text-red-600 font-semibold"
    >
      {{ message }}
    </p>
  </div>
</template>
