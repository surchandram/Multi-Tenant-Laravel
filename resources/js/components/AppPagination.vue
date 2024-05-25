<script setup>
  import { computed } from "vue";
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    meta: {
      type: Object,
      required: true,
    },
  });

  const pageIsOutOfBounds = computed(() => {
    return props.meta.current_page + 1 > props.meta.last_page;
  });
</script>

<template>
  <div v-if="meta.last_page > 1" class="flex items-center">
    <!-- Previous Page Link -->
    <a
      v-if="meta.current_page == 1"
      class="block px-4 py-2 mr-1 rounded-md cursor-not-allowed"
      :class="[
      'text-indigo-500 bg-slate-100 opacity-25'
    ]"
      @click.prevent
    >&lsaquo;</a>

    <Link
      v-else
      :href="route(route().current(), { ...route().params, page: meta.current_page - 1 })"
      class="block px-4 py-2 mr-1 rounded-md text-indigo-600 font-medium hover:bg-indigo-200 focus:bg-indigo-200"
    >&lsaquo;</Link>
    <!-- Previous Page Link -->

    <Link
      v-for="page in meta.last_page"
      :key="page"
      :href="route(route().current(), { ...route().params, page: page })"
      class="block px-4 py-2 mr-1 rounded-md text-indigo-600 font-medium"
      :class="[
        page == meta.current_page ?
        'bg-indigo-200' :
        'text-indigo-600 hover:bg-indigo-200 focus:bg-indigo-200'
    ]"
    >{{ page }}</Link>

    <!-- Next Page Link -->
    <a
      v-if="pageIsOutOfBounds"
      class="block px-4 py-2 mr-1 rounded-md text-indigo-600 cursor-not-allowed"
      :class="[
        'text-indigo-500 bg-slate-100 opacity-25'
      ]"
      @click.prevent
    >&rsaquo;</a>

    <Link
      v-else
      :href="route(route().current(), { ...route().params, page: meta.current_page + 1 })"
      class="block px-4 py-2 mr-1 rounded-md text-indigo-600 font-medium hover:bg-indigo-200 focus:bg-indigo-200"
    >&rsaquo;</Link>
    <!-- Next Page Link -->
  </div>
</template>
