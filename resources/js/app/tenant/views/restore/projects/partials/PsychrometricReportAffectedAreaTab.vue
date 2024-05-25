<script setup>
  import { ref, computed } from 'vue';
  import { useForm } from "@inertiajs/vue3";
  import PsychrometricReportGridColumn from "./PsychrometricReportGridColumn.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppLightButton from "@/components/AppLightButton.vue";

  const props = defineProps({
    affectedArea: { 
      type: Object,
      require: true,
      default: function () {
        return {};
      }
    },
    recordingDate: { 
      type: String,
      require: true,
      default: ''
    },
  });
</script>

<template>
  <div class="flex flex-col gap-6">
    <div
      v-for="(measurePoint, index) in affectedArea"
      :key="index"
      class="
        grid
        grid-cols-1
        md:grid-cols-5
        gap-2
        text-sm
        hover:bg-slate-200
      "
    >
      <!-- Measure Point Label -->
      <div class="col-span-full md:col-auto">
        <PsychrometricReportGridColumn
          label="Area"
          :value="index"
          class="w-full text-slate-600 font-semibold bg-slate-200/80"
        />
      </div>
      <!-- /Measure Point Label -->

      <!-- Values -->
      <div class="col-span-full md:col-span-4">
        <div
          class="
            grid
            md:grid-cols-4
            gap-2
            font-semibold
          "
        >
          <!-- Temp -->
          <PsychrometricReportGridColumn
            label="Temp"
            :value="measurePoint.temperature"
          />

          <!-- RH -->
          <PsychrometricReportGridColumn
            label="RH"
            :value="measurePoint.relative_humidity"
          />

          <!-- GPP -->
          <PsychrometricReportGridColumn
            label="GPP"
            :value="measurePoint.grain_per_pound"
          />

          <!-- Dew -->
          <PsychrometricReportGridColumn
            label="Dew"
            :value="measurePoint.dew_point"
          />
        </div>
      </div>
      <!-- /Values -->
    </div>
  </div>
</template>
