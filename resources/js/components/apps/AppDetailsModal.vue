<script setup>
  import { inject, onMounted, ref } from 'vue';
  import AppModal from '../AppModal.vue';

  const app = ref(null);

  const $eventBus = inject('$eventBus');

  onMounted(() => {
    $eventBus.on('show-app-details', (appData) => {
      app.value = appData;

      $eventBus.emit('open-modal', 'appDetailsModal');
    });
  });
</script>

<template>
  <AppModal
    id="appDetailsModal"
    header-as="div"
  >
    <template
      v-if="app"
      #header
      class="flex items-start"
    >
      <div class="flex items-center gap-2">
        <img
          class="w-12 inline-block mr-2"
          :src="app.logo"
          alt="app logo"
        />

        <div class="inline-flex flex-col">
          <div class="w-full">{{ app.name }}</div>
          <div class="text-sm text-slate-500">Showing app details.</div>
        </div>
      </div>
    </template>

    <div
      v-if="app"
      class="space-y-4"
    >
      <section
        v-html="app.description"
        class="text-slate-600 prose-sm md:prose-lg"
      ></section>

      <!-- Features Section -->
      <h3 class="font-medium text-lg text-slate-700">{{ __('app.labels.features') }}</h3>

      <ul
        role="list"
        class="grid grid-cols-3 pl-5 list-disc text-slate-500"
      >
        <li
          v-for="feature in app.features"
          :key="feature.id"
          class="px-2 py-2"
        >
          <h4 class="text-sm font-medium text-slate-600">{{ feature.name }}</h4>
        </li>
      </ul>

      <!-- Plans Section -->
      <div class="w-full border-t-2 border-indigo-200"></div>

      <h3 class="font-medium text-lg text-slate-700">{{ __('app.labels.plans') }}</h3>

      <ul
        role="list"
        class="rounded divide-y-2 divide-indigo-300 text-slate-500 bg-blue-50"
      >
        <li
          v-for="plan in app.plans"
          :key="plan.id"
          class="px-4 py-3 space-y-2"
        >
          <h4 class="text-lg font-medium text-slate-600">
            {{ plan.name }} ({{ plan.formatted_price }} / {{ plan.plan.formatted_interval }})
          </h4>

          <p class="text-sm font-medium">
            <span v-if="plan.plan.per_seat">Per seat</span>

            <span v-else-if="plan.is_unlimited">Unlimited Users</span>

            <span v-else>{{ plan.limit }} Users</span>
          </p>
        </li>
      </ul>
    </div>
  </AppModal>
</template>
