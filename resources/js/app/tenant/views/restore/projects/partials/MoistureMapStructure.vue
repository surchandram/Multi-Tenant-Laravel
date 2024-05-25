<script setup>
  import MoistureMapMaterial from './MoistureMapMaterial.vue';

  const props = defineProps({
    materials: {
      type: Object,
      required: true,
    },
    structure: {
      type: String,
      required: true,
    },
  });

  const emit = defineEmits(['moisture-map::fill-form']);
</script>

<template>
  <div
    class="flex flex-col md:flex-row gap-4 px-4 py-5 mt-8 first:mt-0 border border-dotted border-blue-500 dark:bg-slate-900"
  >
    <div>
      <h4 class="text-base leading-none font-semibold">{{ structure }}</h4>
    </div>

    <div class="md:flex-1">
      <!-- Materials -->
      <MoistureMapMaterial
        v-for="(material, index) in materials"
        :key="`moisture-map-structure-${index}-${material.id}`"
        :material="material"
      />
      <!-- Materials -->
    </div>
  </div>
</template>
