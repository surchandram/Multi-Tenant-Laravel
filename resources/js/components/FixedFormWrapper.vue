<script setup>
  import { onMounted, computed } from 'vue';
  import useFixedFormPopover from '@/composables/useFixedFormPopover';

  const props = defineProps({
    minimized: {
      type: Boolean,
      default: false,
    },
    as: {
      type: String,
      default: 'div',
    },
  });

  const { visible } = useFixedFormPopover();

  const isMinimized = computed(() => props.minimized);

  onMounted(() => {
    $eventBus.on('route::changed', () => {});

    visible.value = !props.minimized;
  });
</script>

<template>
  <component
    :is="as"
    class="space-y-3 border-slate-50 fixed right-8 bottom-20"
    :class="{
      'md:w-[480px] py-6 border-t-4 bg-white dark:bg-indigo-600': !isMinimized,
      'md:w-auto py-2 rounded-full bg-slate-100 dark:bg-indigo-600': isMinimized,
    }"
  >
    <div class="px-6 lg:px-8 overflow-hidden">
      <slot></slot>
    </div>
  </component>
</template>
