<script setup>
  import { reactive, onMounted } from 'vue';
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: String,
    active: String,
    plain: {
      type: Boolean,
      default: false
    },
    native: {
      type: Boolean,
      default: false
    }
  });

  const state = reactive({
    defaultStyles: "sidebar-link group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4",
    activeStyles: "bg-graydark dark:bg-meta-4",
    isActive: false
  });

  onMounted(() => {
    $eventBus.on('route::changed', () => {
      state.isActive = window.route().current(props.active)
    });

    state.isActive = window.route().current(props.active);
  });

</script>

<template>
  <li>
    <component
      :is="plain || native ? 'a' : Link"
      :href="href"
      :class="[state.defaultStyles, { [state.activeStyles]: state.isActive }]"
    >
      <slot></slot>
    </component>
  </li>
</template>