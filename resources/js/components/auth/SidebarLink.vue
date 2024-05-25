<script setup>
  import { useAttrs, reactive, onMounted } from 'vue';
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

  const attrs = useAttrs();

  const state = reactive({
    defaultStyles: "text-slate-700 hover:text-slate-500",
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
  <li class="items-center">
    <!-- Native Link -->
    <a
      v-if="native && !isAction"
      class="text-xs uppercase py-3 font-bold block"
      :class="[state.isActive ? state.activeStyles : state.defaultStyles]"
      :href="props.href"
      v-bind="attrs"
    >
      <slot name="icon" :icon-styles="[state.isActive ? state.iconActiveStyles : state.iconStyles]"></slot>
      <slot></slot>
    </a>

    <!-- CTA Link -->
    <template v-else-if="isAction">
      <a
        v-if="native"
        class="px-2 py-3 text-slate-700 hover:text-slate-500 bg-teal-200 text-xs uppercase font-bold block rounded shadow"
        :href="props.href"
      >
        <slot name="icon" :icon-styles="[state.isActive ? state.iconActiveStyles : state.iconStyles]"></slot>
        <slot></slot>
      </a>
      <Link
        v-else
        class="px-2 py-3 text-slate-700 hover:text-slate-500 bg-teal-200 text-xs uppercase font-bold block rounded shadow"
        :href="props.href"
      >
        <slot name="icon" :icon-styles="[state.isActive ? state.iconActiveStyles : state.iconStyles]"></slot>
        <slot></slot>
      </Link>
    </template>

    <!-- Inertia Link -->
    <Link
      v-else
      class="text-xs uppercase py-3 font-bold block"
      :class="[state.isActive ? state.activeStyles : state.defaultStyles]"
      :href="props.href"
    >
      <slot name="icon" :icon-styles="[state.isActive ? state.iconActiveStyles : state.iconStyles]"></slot>
      <slot></slot>
    </Link>
  </li>
</template>
