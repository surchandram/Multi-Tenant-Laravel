<script setup>
  import { computed } from 'vue';
  import FormFieldSummary from './FormFieldSummary.vue';
  import FormSectionDivider from "@/components/FormSectionDivider.vue";

  const props = defineProps([
    'id',
    'value',
    'labels'
  ]);

  const getLabel = (key) => _.get(props.labels, key, _.startCase(key));

  const isGrouped = (fieldKey) => _.includes(['company', 'agent', 'adjuster'], fieldKey);

  const transformData = (data, keys) => {
    return _.omit(data, keys);
  };
</script>

<template>
  <div class="py-2">
    <FormSectionDivider :value="getLabel('insurance')" class="mb-3" />

    <div
      v-for="(fieldValue, fieldKey) in transformData(value, 'id')"
      :key="fieldKey"
    >
      <!-- company, agent, adjuster -->
      <template v-if="isGrouped(fieldKey)">
        <div class="mt-4">
          <p class="text-sm font-semibold mb-3">{{ getLabel(fieldKey) }}</p>
          
          <FormFieldSummary
            v-for="(data, dataKey) in transformData(fieldValue, ['id'])"
            :id="dataKey"
            :key="dataKey"
            :labels="labels"
            :value="data"
            class="space-y-2"
          />
        </div>
      </template>

      <FormFieldSummary
        v-else
        :id="fieldKey"
        :labels="labels"
        :value="fieldValue"
        class="space-y-2"
      />
    </div>
  </div>
</template>
