<script setup>
  import { computed } from 'vue';
  import { TabPanel } from '@headlessui/vue';
  import { useMomentJS } from '@/composables/momentjs';
  import { groupBy } from 'lodash';
  import ProjectLog from '@/components/projects/ProjectLog.vue';
  import Badge from '@/components/ui/badge/Badge.vue';

  const props = defineProps({
    project: {
      required: true,
      type: Object,
    },
  });

  const { dateFormat } = useMomentJS();

  const logs = computed(() => groupBy(props.project.logs, (l) => dateFormat(l.created_at, 'YYYY-MM-DD')));
</script>

<template>
  <TabPanel class="p-3">
    <div class="flex flex-col gap-4">
      <!-- Empty Logs Alert -->
      <p
        v-if="project.logs?.length < 1"
        class="text-slate-500 font-medium dark:text-slate-300"
      >
        {{ __('tenant.project.no_logs_found') }}
      </p>
      <!-- END Empty Logs Alert -->

      <div
        v-for="(rows, date) in logs"
        :key="date"
        class="flex flex-col space-y-4"
      >
        <div class="py-px shrink text-center">
          <Badge
            variant="outline"
            class="text-base bg-teal-200 dark:bg-indigo-400"
          >
            {{ dateFormat(date, 'MM/DD/YYYY') }}
          </Badge>
        </div>

        <div class="flex flex-col space-y-8 py-4 rounded-sm">
          <!-- Log -->
          <ProjectLog
            v-for="log in rows"
            :key="log.id"
            :log="log"
            :project="project"
          />
          <!-- END Log -->
        </div>
      </div>
    </div>
  </TabPanel>
</template>
