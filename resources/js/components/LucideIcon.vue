<script setup>
  import { computed } from 'vue';
  import { kebabCase } from 'lodash';
  import icons from '@/lib/lucide-icons';

  const props = defineProps({
    name: {
      type: String,
      required: true,
    },
    size: [Number, String],
    color: String,
    strokeWidth: Number,
    defaultClass: String,
  });

  const icon = computed(() => icons[kebabCase(props.name)]);
</script>

<template>
  <component
    :is="icon"
    :size="size"
    :color="color"
    :stroke-width="strokeWidth"
    :default-class="defaultClass"
  />
</template>
@/lib/lucide-icons
