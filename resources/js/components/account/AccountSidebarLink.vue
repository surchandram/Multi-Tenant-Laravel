<script setup>
  import { ref, onMounted, watch } from 'vue';
  import { Link, router } from '@inertiajs/vue3';

  const props = defineProps({
    as: {
      type: [String, Object],
      default: Link,
    },
    active: {
      type: String,
      default: '',
    },
    href: {
      type: String,
      default: '#',
    },
  });

  const isActive = ref(false);

  onMounted(() => {
    if (props.active) {
      isActive.value = route().current(props.active);

      router.on('finish', () => {
        isActive.value = route().current(props.active);
      });
    }
  });
</script>

<template>
  <component
    :is="!href ? 'a' : as"
    :href="href"
    :class="[
      isActive
        ? 'text-indigo-600 bg-indigo-200 font-semibold dark:bg-slate-950 dark:text-primary'
        : 'text-indigo-400 hover:text-indigo-600 focus:text-indigo-600 hover:bg-indigo-200 focus:bg-indigo-200 dark:text-blue-200 dark:hover:bg-indigo-950 dark:focus:bg-indigo-950',
    ]"
    class="block px-4 py-2 text-sm font-medium"
  >
    <slot></slot>
  </component>
</template>
