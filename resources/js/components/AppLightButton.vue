<script setup>
  import { computed } from 'vue';
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    href: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'button',
    },
    active: {
      type: Boolean,
      default: false,
    },
    outline: {
      type: Boolean,
      default: false,
    },
  });

  const classes = computed(() => {
    let styles = [
      'text-slate-800',
      'hover:bg-slate-200',
      'active:bg-slate-200',
      'text-sm',
      'font-semibold',
      'px-3',
      'py-2',
      'rounded',
      'outline-none',
      'focus:outline-none',
      'disabled:opacity-25',
      'dark:text-slate-600',
      'dark:hover:bg-slate-300',
      'dark:hover:text-slate-800',
      'dark:active:text-slate-800',
    ];

    if ([props.outline, props.active].filter((f) => f === false).length === 0) {
      styles.push('bg-slate-100');
    }

    if (props.active) {
      styles.push('bg-slate-200');
    }

    return styles;
  });
</script>

<template>
  <Link
    v-if="href"
    :href="href"
    :class="classes"
    style="transition: all 0.15s ease"
  >
    <slot></slot>
  </Link>
  <button
    v-else
    :class="classes"
    :type="props.type"
    style="transition: all 0.15s ease"
  >
    <slot></slot>
  </button>
</template>
