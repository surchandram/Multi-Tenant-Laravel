<script>
  export default {
    pageLayout: "landing",
  };
</script>

<script setup>
  import { watch } from "vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import LayoutSlot from "@/components/LayoutSlot.vue";

  defineProps([
    'model'
  ]);
</script>

<template>
  <Head :title="`Restore`" />
  
  <div class="min-h-full py-24">
    {{ model }}
  </div>  
</template>
