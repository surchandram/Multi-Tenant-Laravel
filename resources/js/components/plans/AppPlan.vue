<script setup>
  const props = defineProps({
    plan: {
      type: Object,
      required: true,
    },
  });
</script>

<template>
  <div class="flex items-center justify-between px-6 py-4 border-2 border-slate-200 rounded-lg">
    <div class="flex items-center">
      <h2 class="text-lg font-semibold text-indigo-500 mr-4">{{ plan.name }}</h2>

      <span class="text-sm text-slate-800">{{ plan.per_seat ? 'Per User' : plan.team_limit + ' users' }}</span>
    </div>

    <p class="font-medium">
      <span>{{ plan.formatted_price }} / {{ plan.formatted_interval }}</span>
    </p>
  </div>
</template>
