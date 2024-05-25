<script setup>
  import { reactive } from 'vue';
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: String,
    active: String,
    native: {
      type: Boolean,
      default: false
    }
  });

  const state = reactive({
    defaultStyles: "sidebar-link group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white",
    activeStyles: "bg-graydark dark:bg-meta-4",
    isActive: false
  });

  $eventBus.on('route::changed', () => {
    state.isActive = window.route().current(props.active)
  });
</script>

<template>
  <li>
    <Link v-if="native != true" :href="href" :class="[state.defaultStyles, { [state.activeStyles]: state.isActive }]">
      <slot></slot>
    </Link>
    <a v-else :href="href" :class="[state.defaultStyles, { [state.activeStyles]: state.isActive }]">
      <slot></slot>
    </a>
  </li>
</template>