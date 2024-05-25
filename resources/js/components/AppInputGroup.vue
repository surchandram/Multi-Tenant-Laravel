<script setup>
  import { computed, ref, useSlots, onMounted } from 'vue';

  const props = defineProps({
    start: String,
    end: String,
    textBg: String,
    custom: {
      type: [Boolean, String],
      default: false,
    },
  });

  const slots = useSlots();

  const hasStartSlot = typeof slots.start !== 'undefined' || typeof props.start === 'string';
  const hasEndSlot = typeof slots.end !== 'undefined' || typeof props.end === 'string';

  const defaultTextStyles = ref([
    'input-group-text',
    'block',
    'px-3',
    'py-1.5',
    'border',
    'border-gray-300',
    'rounded',
    'text-slate-600',
    'font-semibold',
    'text-base',
    'dark:text-white',
  ]);

  const setBg = (bg) => {
    defaultTextStyles.value.push(bg);
  };

  const inputStyles = computed(() => {
    if (hasStartSlot) {
      return 'bg-clip-padding focus:z-[3] rounded-l-none';
    }
    return 'bg-clip-padding focus:z-[3] rounded-r-none';
  });

  onMounted(() => {
    if (typeof props.textBg !== 'undefined') {
      setBg(props.textBg);
    }
  });
</script>

<template>
  <div class="input-group flex items-stretch mb-2">
    <!-- Left most Slot -->
    <div
      v-if="hasStartSlot"
      :class="!props.custom ? defaultTextStyles : [custom]"
      class="rounded-r-none"
    >
      <slot name="start">
        {{ props.start }}
      </slot>
    </div>

    <!-- Default Slot -->
    <slot :input-styles="inputStyles"></slot>

    <!-- Right most Slot -->
    <div
      v-if="hasEndSlot"
      :class="!props.custom ? defaultTextStyles : [custom]"
      class="rounded-l-none"
    >
      <slot name="end">
        {{ props.end }}
      </slot>
    </div>
  </div>
</template>
