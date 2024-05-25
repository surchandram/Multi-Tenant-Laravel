<script setup>
  import { reactive, onMounted } from 'vue';
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: String,
    active: String,
    native: Boolean,
    isAction: {
      type: Boolean,
      default: false,
    },
    altStyles: {
      type: Boolean,
      default: false,
    },
  });

  const state = reactive({
    defaultStyles: "text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700",
    altStyles: "text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold",
    activeStyles: "text-pink-500 hover:text-pink-600",
    disabledStyles: "text-slate-300",
    iconStyles: "text-slate-400 mr-2 text-sm",
    iconAltStyles: "text-slate-400 mr-2 text-base",
    iconActiveStyles: "opacity-75 mr-2 text-sm",
    iconDisabledStyles: "text-slate-300 mr-2 text-sm",
    isActive: false
  });

  onMounted(() => {
    state.isActive = props.active ? window.route().current(props.active) : false;
    
    $eventBus.on('route::changed', () => {
      state.isActive = props.active ? window.route().current(props.active) : false;
    });

    if (props.altStyles) {
      state.defaultStyles = state.altStyles;
      state.iconStyles = state.iconAltStyles;
    }
  });
</script>

<template>
  <a
    v-if="native"
    :class="state.defaultStyles"
    :href="props.href"
  >
    <slot name="icon" :icon-styles="[state.isActive ? state.iconActiveStyles : state.iconStyles]"></slot>
    <slot></slot>
  </a>
  <Link
    v-else
    :class="state.defaultStyles"
    :href="props.href"
  >
    <slot name="icon" :icon-styles="[state.isActive ? state.iconActiveStyles : state.iconStyles]"></slot>
    <slot></slot>
  </Link>
</template>
