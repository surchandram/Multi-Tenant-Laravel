<script setup>
  import { useSlots } from "vue";

  defineProps(["feature"]);

  const slots = useSlots();
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
          {{ feature.name }}
        </h4>
        <p class="text-sm font-medium mt-3">{{ feature.is_unlimited ? 'Unlimited' : `Limit: ${feature.limit}` }}</p>
        <p class="text-sm font-medium mt-3">{{ feature.usable ? 'Live' : 'Disabled' }}</p>
      </div>

      <div class="flex items-center gap-1 text-sm font-medium text-meta-3" v-if="slots.meta">

        <!-- extra meta -->
        <slot name="meta"></slot>
      </div>
    </div>

    <div class="mt-5" v-if="slots.footer">
      <slot name="footer">
      </slot>
    </div>
  </div>
  <!-- Card Item End -->
</template>
