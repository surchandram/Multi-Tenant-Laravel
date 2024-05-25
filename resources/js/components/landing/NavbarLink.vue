<script setup>
  import { computed, onMounted, ref, useAttrs } from "vue";
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: String,
    current: String,
    native: {
      type: Boolean,
      default: false,
    },
  });

  const attrs = useAttrs();

  const isActive = ref(false);
  const iconStyles = ref("lg:text-gray-300 text-gray-500 text-lg leading-lg");

  onMounted(() => {
    isActive.value = window.route().current(props.current);

    $eventBus.on('route::changed', () => {
      isActive.value = route().current(props.current);
    });
  });
</script>

<template>
  <li class="flex items-center">
    <a
      v-if="native"
      v-bind="attrs"
      class="w-full inline-flex items-center gap-1 px-3 py-4 lg:py-2 lg:hover:text-gray-300 text-xs uppercase"
      :class="{ 'font-bold text-gray-300': isActive, 'font-medium text-gray-800 lg:text-white': !isActive }"
      :href="href"
    >
      <slot name="icon" :icon-styles="iconStyles"></slot>
      <slot></slot>
    </a>
    <Link
      v-else
      v-bind="attrs"
      class="w-full inline-flex items-center gap-1 px-3 py-4 lg:py-2 lg:hover:text-gray-300 text-xs uppercase"
      :class="{ 'font-bold text-gray-300': isActive, 'font-medium text-gray-800 lg:text-white': !isActive }"
      :href="href"
    >
      <slot name="icon" :icon-styles="iconStyles"></slot>
      <slot></slot>
    </Link>
  </li>
</template>
