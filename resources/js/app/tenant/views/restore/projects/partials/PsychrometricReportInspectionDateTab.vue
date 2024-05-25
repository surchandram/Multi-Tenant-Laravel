<script setup>
  import { computed } from 'vue';
  import PsychrometricReportAffectedAreaTab from "./PsychrometricReportAffectedAreaTab.vue";
  import AppTabs from "@/components/AppTabs.vue";
  import AppButton from "@/components/AppButton.vue";

  const props = defineProps({
    affectedAreas: { 
      type: Object,
      require: true
    },
    recordingDate: { 
      type: String,
      require: true
    },
  });

  const tabs = computed(() => _.keyBy(
      _.keys(props.affectedAreas),
      (v) => v
    )
  );
</script>

<template>
  <div>
    <AppTabs
      :tabs="tabs"
      index-as-label
    >
      <template #content="{ currentTab }">
        <!-- Edit Button -->
        <div class="inline-flex items-center gap-2 mb-4">
          <AppButton
            class="inline-flex items-center gap-3"
            @click="$eventBus.emit('psychrometric-report::edit', {
              affectedArea: affectedAreas[currentTab],
              key: currentTab,
              recordingDate
            })"
          >
            <i class="bi bi-pencil"></i> Adjust readings
          </AppButton>
          <p>for <span class="text-sm font-semibold text-slate-600">{{ currentTab }}</span></p>
        </div>

        <!-- Header -->
        <div
          class="hidden md:grid md:grid-cols-5 gap-2 mb-4 text-sm font-semibold bg-slate-200/80"
        >
          <div class="md:col-start-2 px-4 py-2">
            Temp
          </div>
          <div class="px-4 py-2">
            RH
          </div>
          <div class="px-4 py-2">
            GPP
          </div>
          <div class="px-4 py-2">
            Dew
          </div>
        </div>
        <!-- /Header -->

        <PsychrometricReportAffectedAreaTab
          v-if="currentTab"
          :affected-area="affectedAreas[currentTab]"
          :recording-date="recordingDate"
        />
      </template>
    </AppTabs>
  </div>
</template>
