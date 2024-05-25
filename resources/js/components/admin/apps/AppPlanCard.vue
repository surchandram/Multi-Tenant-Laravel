<script setup>
  import { useSlots, computed, toRefs } from "vue";

  const props = defineProps(["plan"]);

  const { plan } = toRefs(props);

  const slots = useSlots();

  const planIsEditable = computed(() => _.startsWith(plan.value.id, '_'));

  const formatted_price = computed(() => currencyFormatter(plan.value.price, { fromCents: true }).format()
  );
</script>

<template>
  <!-- Card Item Start -->
  <div
    class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div
      class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
      v-if="slots.icon"
    >
      <slot name="icon"></slot>
    </div>

    <div class="mt-4 flex items-end justify-between">
      <div>
        <h4 class="text-title-md font-bold text-black dark:text-white">
          {{ plan.name }}
        </h4>

        <!-- Seat|Limit -->
        <p class="text-sm font-medium mt-3">{{ plan.per_seat ? 'Per Person' : `Limit: ${plan.limit}` }}</p>

        <!-- Price -->
        <p class="text-sm font-medium mt-3">
          {{ planIsEditable ? formatted_price : plan.formatted_price }}
        </p>
      </div>

      <span class="flex items-center gap-1 text-sm font-medium text-meta-3" v-if="slots.meta">
        <span>{{ plan.usable ? 'Live' : 'Disabled' }}</span>

        <!-- extra meta -->
        <slot name="meta"></slot>
      </span>
    </div>

    <div class="mt-5" v-if="slots.footer">
      <slot name="footer">
      </slot>
    </div>
  </div>
  <!-- Card Item End -->
</template>
