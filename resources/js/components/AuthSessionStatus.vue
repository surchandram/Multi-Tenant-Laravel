<script setup>
  const props = defineProps({
    status: String,
  });
</script>

<template>
  <div>
    <p class="font-medium text-sm bg-green-100 p-2 rounded-md text-green-600">
      <slot>
        <div v-if="status">{{ status }}</div>
        <div v-else>{{ $page.props.flash.status }}</div>
      </slot>
    </p>
  </div>
</template>
