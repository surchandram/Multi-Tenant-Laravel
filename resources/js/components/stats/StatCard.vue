<script setup>
  import { useSlots } from 'vue';

  const props = defineProps(['label', 'value', 'meta', 'theme']);

  const slots = useSlots();
</script>

<template>
  <!-- Admin Theme Card -->
  <div
    v-if="theme == 'admin'"
    class="rounded-lg border border-slate-200 bg-white p-6 sm:col-span-6 xl:col-span-3 dark:border-primary-foreground dark:bg-slate-900"
  >
    <dl>
      <dt class="text-2xl font-bold">{{ value }}</dt>
      <dd class="text-sm font-medium text-slate-500">
        {{ label }}
      </dd>
    </dl>
  </div>
  <!-- END Admin Theme Card -->

  <!-- Default Stat Card -->
  <div
    v-else
    class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-primary dark:bg-secondary"
  >
    <div
      v-if="slots.icon"
      class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
    >
      <slot name="icon"></slot>
    </div>

    <div class="mt-4 flex items-end justify-between">
      <div>
        <h4 class="text-title-md font-bold text-black dark:text-white">
          {{ value }}
        </h4>
        <span class="text-sm font-medium">{{ label }}</span>
      </div>

      <span
        v-if="slots.meta"
        class="flex items-center gap-1 text-sm font-medium text-meta-3"
      >
        <slot name="meta"></slot>
      </span>
    </div>
  </div>
  <!-- Default Stat Card -->
</template>
