<script setup>
  import { useSlots, toRefs } from "vue";

  const props = defineProps(["app"]);

  const { app } = toRefs(props);

  const slots = useSlots();
</script>

<template>
  <!-- Card Item Start -->
  <div
    class="flex flex-col rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div
      class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
      v-if="slots.icon"
    >
      <slot name="icon"></slot>
    </div>

    <div class="mt-4 flex items-start justify-between">
      <div>
        <a href="#">
          <h4
            class="
              text-title-md
              font-bold
              text-black
              dark:text-white
              hover:text-teal-700
              focus:underline
            ">
            {{ app.name }}
          </h4>
        </a>

        <div class="mt-3">
          <span class="text-sm font-medium">{{ app.description }}</span>
        </div>
      </div>

      <div class="flex items-center gap-1 text-sm font-medium text-meta-3">
        <span class="text-sm font-medium">{{ app.usable ? 'Live' : 'Disabled' }}</span>
      </div>
    </div>

    <div class="flex items-center gap-3 py-3 mt-auto text-sm font-medium text-meta-3">
      <span class="text-sm font-medium">
        <i class="bi bi-plug mr-1"></i>
        {{ app.features_count }}
      </span>
      <span class="text-sm font-medium">
        <i class="bi bi-credit-card mr-1"></i>
        {{ app.plans_count }}
      </span>
      <span class="text-sm font-medium">
        <i class="bi bi-people mr-1"></i>
        {{ app.teams_count || 0 }}
      </span>
      <slot name="meta"></slot>
    </div>
  </div>
  <!-- Card Item End -->
</template>
