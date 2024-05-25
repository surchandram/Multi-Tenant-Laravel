<script setup>
  import RestoreProjectNotificationSettings from './RestoreProjectStatusNotificationSettings.vue';

  const props = defineProps({
    section: {
      type: Object,
      required: true,
    },
    id: {
      type: String,
      required: true,
    },
  });

  const resolved = {
    project_status: RestoreProjectNotificationSettings,
  };
</script>

<template>
  <div
    v-for="(group, groupKey) in section"
    :key="groupKey"
    class="space-y-8"
  >
    <h3 class="text-base font-medium text-slate-500">{{ group.label }}</h3>

    <component
      :is="resolved[groupKey]"
      :section="group.collection"
      :id="groupKey"
    />
  </div>
</template>
