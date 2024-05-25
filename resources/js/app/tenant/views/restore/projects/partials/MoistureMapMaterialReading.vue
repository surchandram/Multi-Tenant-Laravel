<script setup>
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import LucideIcon from '@/components/LucideIcon.vue';

  const props = defineProps({
    modelValue: {
      type: Array,
      default: function () {
        return [];
      },
    },
    affectedArea: {
      type: Object,
      default: function () {
        return {};
      },
    },
    project: {
      type: Object,
      default: function () {
        return {};
      },
    },
    model: {
      type: Object,
      default: function () {
        return {};
      },
    },
  });

  const emit = defineEmits(['removed']);

  const form = useForm({});

  const confirmDelete = () => {
    const { material, recordedAt } = props.model;

    const area = `${material.affected_area} - ${material.structure} - ${material.material}`;

    if (!confirm(`Are you sure you want to remove the reading for: ${recordedAt} (${area}) from moisture map?`)) {
      return;
    }

    const readingId = material.readings_by_id[recordedAt];

    form.delete(route('restore.moisture-map.readings.destroy', [material.id, readingId]), {
      onSuccess: () => {
        const data = {
          reading_id: readingId,
          ...props.model,
        };

        // emit 'removed' event
        emit('removed', data);

        // emit global 'moisture-map::removed-reading' event
        $eventBus.emit('moisture-map::removed-reading', data);
      },
    });
  };
</script>

<template>
  <div
    class="flex flex-col md:flex-row md:items-center gap-2 rounded-sm md:rounded-none font-medium text-slate-700 dark:text-indigo-200 md:odd:bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-950 dark:odd:hover:bg-slate-950 dark:md:odd:bg-slate-900"
  >
    <!-- Date Recorded -->
    <div class="px-2 py-3 flex-1">{{ model.recordedAt }}</div>

    <!-- Value -->
    <div class="px-2 py-3 flex-[2_2_0%] font-semibold">{{ model.value }}%</div>

    <div class="md:ml-auto px-2 md:px-2 py-2">
      <AppButton
        class="inline-flex items-center gap-3"
        theme="danger"
        @click="confirmDelete"
      >
        <span class="md:hidden">{{ __('app.labels.remove') }}</span>
        <LucideIcon
          name="x"
          class="size-5"
        />
      </AppButton>
    </div>
  </div>
</template>
