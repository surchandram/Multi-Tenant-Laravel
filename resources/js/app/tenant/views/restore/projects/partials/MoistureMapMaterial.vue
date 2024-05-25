<script setup>
  import { size } from 'lodash';
  import MoistureMapMaterialReading from './MoistureMapMaterialReading.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import LucideIcon from '@/components/LucideIcon.vue';

  const props = defineProps({
    material: {
      type: Object,
      required: true,
    },
  });

  const emit = defineEmits(['moisture-map::fill-readings-form']);
</script>

<template>
  <div class="flex flex-col md:flex-row gap-8 py-5 first:pt-0 mt-8 first:mt-0">
    <div class="space-y-4">
      <!-- Material -->
      <p class="text-base leading-none font-medium text-slate-600 dark:text-indigo-300">
        {{ material.material }}
      </p>

      <!-- Empty -->
      <div
        v-if="size(material.readings) < 1"
        class="flex items-center flex-col gap-2 self-end text-xs text-slate-400 font-medium"
      >
        {{ __('tenant.project.moisture_map.material_readings_empty') }}
        <AppSuccessButton
          type="button"
          class="inline-flex items-center gap-2"
          @click="$eventBus.emit('moisture-map::fill-readings-form', material)"
        >
          <LucideIcon
            name="circle-plus"
            size="16"
            class="h-6 w-6"
          />
          {{ __('tenant.labels.add_readings') }}
        </AppSuccessButton>
      </div>
      <!-- END Empty -->

      <!-- Adjust Readings Button -->
      <div v-else>
        <AppSuccessButton
          type="button"
          class="inline-flex items-center gap-2"
          @click="$eventBus.emit('moisture-map::fill-readings-form', material)"
        >
          <LucideIcon
            name="notebook-pen"
            size="16"
            class="h-6 w-6"
          />
          {{ __('tenant.labels.adjust_readings') }}
        </AppSuccessButton>
      </div>
      <!-- END Adjust Readings Button -->
    </div>

    <div class="md:flex-1 flex flex-col gap-3">
      <!-- Material Readings -->
      <MoistureMapMaterialReading
        v-for="(value, recordedAt) in material.readings"
        :key="recordedAt"
        :model="{
          recordedAt,
          value,
          material,
        }"
      />
      <!-- END Material Readings -->
    </div>
  </div>
</template>
