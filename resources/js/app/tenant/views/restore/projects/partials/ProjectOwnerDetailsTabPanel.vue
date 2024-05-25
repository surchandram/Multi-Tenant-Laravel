<script setup>
  import { computed } from 'vue';
  import { TabPanel } from '@headlessui/vue';
  import { useMomentJS } from '@/composables/momentjs';
  import { get } from 'lodash';
  import parsePhoneNumber from 'libphonenumber-js';

  const props = defineProps({
    project: {
      required: true,
      type: Object,
    },
  });

  const phoneNumber = computed(() => parsePhoneNumber(`+${props.project.owner?.phone}`)?.formatInternational());

  const ownerAddress = computed(() =>
    get(props.project.owner.address, 'address_1') ? props.project.owner.address : props.project.address,
  );
</script>

<template>
  <TabPanel class="p-3">
    <p
      v-if="!project.owner"
      class="text-slate-500 font-medium"
    >
      {{ __('app.labels.no_data_found') }}
    </p>

    <div
      v-else
      class="space-y-2 mb-6"
    >
      <!-- Name -->
      <div class="grid md:grid-cols-4 gap-2">
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <h4 class="text-sm font-semibold">{{ __('app.labels.name') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ project.owner.name }}</p>
        </div>
      </div>
      <!-- END Name -->

      <!-- Phone/Email -->
      <div class="grid md:grid-cols-4 gap-2 mt-6">
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <!-- Phone -->
          <h4 class="text-sm font-semibold">{{ __('app.labels.phone') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ phoneNumber }}</p>
        </div>
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <!-- Email -->
          <h4 class="text-sm font-semibold">{{ __('app.labels.email') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ project.owner.email }}</p>
        </div>
      </div>
      <!-- END Phone/Email -->

      <!-- Property Address -->
      <div
        v-if="ownerAddress"
        class="grid md:grid-cols-4 gap-2 mt-6"
      >
        <!-- Street Address -->
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <h4 class="text-sm font-semibold">{{ __('app.labels.address') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ ownerAddress.address_1 }}</p>
        </div>

        <!-- City -->
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <h4 class="text-sm font-semibold">{{ __('app.labels.city') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ ownerAddress.city }}</p>
        </div>

        <!-- State -->
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <h4 class="text-sm font-semibold">{{ __('app.labels.state') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ ownerAddress.state }}</p>
        </div>

        <!-- Postal code -->
        <div class="col-span-full md:col-span-1 space-y-2 py-2 text-base">
          <h4 class="text-sm font-semibold">{{ __('app.labels.postal_code') }}</h4>

          <p class="text-slate-600 dark:text-indigo-200 font-medium">{{ ownerAddress.postal_code }}</p>
        </div>
      </div>
      <!-- END Property Address -->
    </div>
  </TabPanel>
</template>
