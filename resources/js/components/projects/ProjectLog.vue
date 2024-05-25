<script setup>
  import { inject } from 'vue';
  import { router } from '@inertiajs/vue3';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { useMomentJS } from '@/composables/momentjs';

  const props = defineProps({
    log: {
      required: true,
      type: Object,
    },
    project: {
      required: true,
      type: Object,
    },
  });

  const { dateFormat } = useMomentJS();

  const __ = inject('$translate');

  const confirmLogDelete = (log) => {
    if (!window.confirm(__('tenant.project.log_delete_confirm'))) {
      return;
    }

    router.delete(
      route('restore.projects.logs.destroy', {
        project: props.project,
        projectLog: log,
      }),
      {
        onError: () => {
          //
        },
      },
    );
  };
</script>

<template>
  <div class="px-4 py-2 space-y-2 rounded-sm bg-slate-50 dark:bg-slate-900">
    <div class="flex items-center gap-2">
      <!-- Log meta -->
      <span class="font-medium text-xs">{{ log.user.name }}</span>
      <span class="font-medium text-xs">&bullet;</span>
      <span class="font-medium text-xs">{{ dateFormat(log.created_at, 'hh:mm A') }}</span>
      <!-- END Log meta -->

      <!-- Delete Button -->
      <button
        class="inline-flex items-center gap-1 px-4 py-2 ml-auto rounded-md font-medium text-sm text-red-500 hover:bg-red-200 focus:bg-red-200 transition ease-in-out duration-200"
        href="#"
        @click.prevent="confirmLogDelete(log)"
      >
        <LucideIcon
          name="trash"
          class="size-4"
        />
        {{ __('app.labels.delete') }}
      </button>
      <!-- END Delete Button -->
    </div>

    <article
      v-html="log.body"
      class="text-gray-700 prose prose-sm lg:prose dark:text-slate-200"
    />
  </div>
</template>
