<script setup>
  import { computed } from 'vue';

  const props = defineProps([
    'id',
    'value',
    'labels'
  ]);

  const label = computed(() => _.get(props.labels, props.id, props.id));

  const formattedValue = computed(() => {
    const isDateTime = _.includes([
      'contacted_at',
      'loss_occurred_at',
      'starts_at',
      'ends_at',
    ], props.id);

    if (isDateTime) {
      return moment(props.value).format('MM/DD/YYYY');
    }

    const isMoney = _.includes([
      'deductible'
    ], props.id);

    if (isMoney) {
      return currencyFormatter(props.value, { fromCents: true }).format();
    }

    return props.value;
  });
</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <!-- Label -->
    <p class="text-sm font-medium mt-3">
      <slot name="label" :field-key="id">{{ label }}</slot>
    </p>

    <h4
      class="text-lg font-bold text-black dark:text-white"
    >
      <slot
        name="value"
        :field-key="id"
        :formatted-value="formattedValue"
      >
        {{ formattedValue }}
      </slot>
    </h4>
  </div>
</template>
