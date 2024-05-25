<script setup>
  import { computed, ref, onMounted } from 'vue';
  import { followCursor } from 'tippy.js';

  const props = defineProps({
    project: {
      type: Object,
      required: true,
    },
  });

  const projectTitle = ref(null);
  const projectType = ref(null);

  const address = computed(() => {
    if (!props.project.address) {
      return '';
    }

    return `${props.project.address.address_1}, ${props.project.address.city}, ${props.project.address.postal_code}, ${props.project.address.state}`;
  });

  onMounted(() => {
    tippy(projectTitle.value, {
      content: address.value,
      theme: 'light',
      followCursor: 'horizontal',
      plugins: [followCursor],
    });

    if (props.project.type) {
      tippy(projectType.value, {
        content: props.project.type.name,
        theme: 'light',
        followCursor: 'horizontal',
        plugins: [followCursor],
      });
    }
  });
</script>

<template>
  <div
    class="space-y-4 rounded-xl border border-slate-200 p-5 dark:bg-primary-foreground dark:border-secondary dark:text-slate-200"
  >
    <!-- Project Summary -->
    <div>
      <!-- Project Info -->
      <h4 class="mb-1 flex items-center space-x-2 font-semibold">
        <div
          v-if="project.type && $page.props.settings.restore_project_types_colors"
          ref="projectType"
          class="w-4 h-4 rounded-full"
          :style="{ backgroundColor: $page.props.settings.restore_project_types_colors[project.type.slug] }"
        ></div>
        <div
          class="flex-1"
          ref="projectTitle"
        >
          {{ project.name }}
        </div>
        <a
          :href="route('restore.projects.show', project)"
          class="text-sm font-medium text-blue-600 transition hover:text-blue-700"
        >
          <i class="bi bi-chevron-right leading-none"></i>
        </a>
      </h4>

      <p class="my-4 text-sm leading-none text-white font-semibold">
        <span class="px-2 py-1 rounded bg-blue-600">{{ project.status?.name }}</span>
      </p>

      <p class="text-sm font-medium my-2">
        {{ __('tenant.labels.assigned_to') }}&colon;
        <span class="font-semibold text-slate-600 dark:text-indigo-200">{{ project.team?.name || '-' }}</span>
      </p>
      <!-- Project Info -->

      <!-- Owner -->
      <h5 class="text-sm font-medium text-slate-600 dark:text-secondary-foreground mt-4">
        {{ __('tenant.labels.owner') }}&colon;
        <a
          href="javascript:void(0)"
          class="font-medium text-blue-600 transition hover:text-blue-700"
          >{{ project.owner?.name || '-' }}</a
        >
      </h5>
      <!-- END Owner -->
    </div>
    <!-- END Project Summary -->

    <!-- Project Log -->
    <div
      v-for="log in project.logs"
      :key="log.id"
      class="space-y-3"
    >
      <a
        href="javascript:void(0)"
        class="flex flex-col rounded bg-slate-50 hover:bg-slate-100 active:bg-slate-50"
      >
        <div class="space-y-2 p-3 text-sm">
          <div class="h-1.5 w-8 rounded bg-orange-400"></div>
          <p class="truncate">{{ log.body }}</p>
        </div>
      </a>
    </div>
    <!-- END Project Log -->
  </div>
</template>
