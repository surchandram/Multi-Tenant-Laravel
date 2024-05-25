<script setup>
  import { reactive, onMounted } from 'vue';
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    href: String,
    active: String,
    current: {
      type: Boolean,
      default: false,
    },
    plain: {
      type: Boolean,
      default: false,
    },
    native: {
      type: Boolean,
      default: false,
    },
    minimized: {
      type: Boolean,
      default: false,
    },
    as: {
      type: String,
      default: '',
    },
    theme: {
      type: String,
      default: '',
    },
  });

  const state = reactive({
    defaultStyles:
      'flex items-center rounded-lg px-4 py-2.5 font-semibold text-slate-600 hover:bg-white hover:shadow-sm hover:shadow-slate-300/50 active:bg-white/75 active:text-slate-800 active:shadow-slate-300/10 dark:text-indigo-200 dark:hover:bg-secondary hover:shadow-none active:bg-secondary',
    activeStyles:
      'flex items-center rounded-lg bg-white px-4 py-2.5 font-semibold text-slate-600 shadow-sm shadow-slate-300/50 dark:bg-secondary dark:shadow-none dark:text-primary',
    adminThemeStyles:
      'group flex items-center justify-between rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-900 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 dark:text-indigo-200 dark:hover:text-primary dark:hover:bg-primary-foreground',
    adminThemeActiveStyles:
      'group flex items-center justify-between rounded-md border border-transparent bg-indigo-100 px-2.5 py-2 text-sm font-semibold text-indigo-500 active:border-indigo-200 dark:bg-slate-900 dark:text-indigo-200',
    adminThemeIconStyles: 'text-slate-300 group-hover:text-indigo-500',
    adminThemeBadgeStyles:
      'inline-flex items-center justify-center rounded-full border border-indigo-200 bg-indigo-50 px-1 text-xs text-indigo-900',
    simpleThemeStyles:
      'inline-flex items-center space-x-2 rounded-lg px-2 py-1 text-sm font-semibold text-slate-600 transition hover:bg-indigo-100 hover:text-indigo-900 dark:hover:bg-secondary dark:hover:text-indigo-200',
    simpleThemeActiveStyles:
      'inline-flex items-center space-x-2 rounded-lg bg-indigo-100 px-2 py-1 text-sm font-semibold text-indigo-900 transition dark:bg-secondary dark:text-indigo-200',
    isActive: false,
  });

  onMounted(() => {
    $eventBus.on('route::changed', () => {
      state.isActive = props.current ? true : !props.active ? false : window.route().current(props.active);
    });

    state.isActive = props.current ? true : !props.active ? false : window.route().current(props.active);
  });
</script>

<template>
  <component
    :is="as ? as : plain || native ? 'a' : Link"
    v-if="theme == 'admin'"
    :href="href"
    :class="[
      { [state.adminThemeStyles]: !state.isActive },
      { [state.adminThemeActiveStyles]: state.isActive },
      { 'space-x-2': !minimized },
      { 'justify-between': minimized },
    ]"
  >
    <slot
      :is-active="state.isActive"
      :icon-styles="state.adminThemeIconStyles"
      :badge-styles="state.adminThemeBadgeStyles"
      :is-minimized="minimized"
    ></slot>
  </component>

  <component
    :is="as ? as : plain || native ? 'a' : Link"
    v-else-if="theme == 'simple'"
    :href="href"
    :class="[
      { [state.simpleThemeStyles]: !state.isActive },
      { [state.simpleThemeActiveStyles]: state.isActive },
      { 'space-x-2': !minimized },
      { 'justify-between': minimized },
    ]"
  >
    <slot
      :is-active="state.isActive"
      :icon-styles="state.adminThemeIconStyles"
      :badge-styles="state.adminThemeBadgeStyles"
      :is-minimized="minimized"
    ></slot>
  </component>

  <component
    :is="as ? as : plain || native ? 'a' : Link"
    v-else
    :href="href"
    :class="[
      { [state.defaultStyles]: !state.isActive },
      { [state.activeStyles]: state.isActive },
      { 'space-x-3': !minimized },
      { 'justify-between': minimized },
    ]"
  >
    <slot></slot>
  </component>
</template>
