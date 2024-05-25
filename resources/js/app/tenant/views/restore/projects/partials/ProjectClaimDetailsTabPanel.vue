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

  const { dateFormat } = useMomentJS();

  const phoneNumber = computed(() => parsePhoneNumber(`+${props.project.owner?.phone}`)?.formatInternational());

  const propertyAddress = computed(() =>
    get(props.project.address, 'address_1') ? props.project.address : props.project.owner?.address,
  );
</script>

<template>
  <TabPanel class="p-3 focus:outline-none">
    <!-- Overview Section -->
    <div class="mb-6 space-y-2">
      <h3 class="text-lg text-slate-700 dark:text-slate-200">Overview</h3>

      <!-- Overview -->
      <div class="grid gap-2 md:grid-cols-4">
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.type') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ project.type.name }}</p>
        </div>
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.category') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ project.category.name }}</p>
        </div>
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.class') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ project.class.name }}</p>
        </div>
      </div>

      <!-- Point of Loss -->
      <div class="grid gap-2 mt-6 md:grid-cols-4">
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.point_of_loss') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ project.point_of_loss }}</p>
        </div>
      </div>

      <!-- Affected Areas -->
      <div class="grid gap-2 mt-6 md:grid-cols-2">
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.affected_areas') }}</h4>

          <div class="flex flex-wrap items-baseline w-full gap-3 py-2 text-slate-600">
            <div
              v-for="(affected_area, index) in project.affectedAreas"
              :key="index"
              class="px-2 py-1 text-sm text-blue-500 bg-blue-200 rounded-full"
            >
              {{ affected_area.name }}
            </div>

            <p
              v-if="project.affectedAreas?.length < 1"
              class="font-medium text-slate-500"
            >
              {{ __('app.labels.no_data_found') }}
            </p>
          </div>
        </div>
      </div>

      <!-- Loss/Contact Dates -->
      <div class="grid gap-2 mt-6 md:grid-cols-4">
        <!-- Date Loss Occurred -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.date_loss_occurred') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ dateFormat(project.loss_occurred_at) }}</p>
        </div>
        <!-- Date Contacted -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.date_contacted') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ dateFormat(project.contacted_at) }}</p>
        </div>
      </div>
    </div>
    <!-- END Overview Section -->

    <!-- Property Section -->
    <div class="mb-6 space-y-2">
      <h3 class="text-lg text-slate-700 dark:text-slate-200">Property Details</h3>

      <!-- Contact Name -->
      <div class="grid gap-2 md:grid-cols-4">
        <!-- Full name -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('app.labels.contact_name') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ project.owner?.name }}</p>
        </div>
      </div>
      <!-- END Contact Name -->

      <!-- Phone/Email -->
      <div class="grid gap-2 mt-6 md:grid-cols-4">
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <!-- Phone -->
          <h4 class="text-sm font-semibold">{{ __('app.labels.phone') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ phoneNumber }}</p>
        </div>
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <!-- Email -->
          <h4 class="text-sm font-semibold">{{ __('app.labels.email') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ project.owner?.email }}</p>
        </div>
      </div>
      <!-- END Phone/Email -->

      <!-- Property Address -->
      <div
        v-if="propertyAddress"
        class="grid gap-2 mt-6 md:grid-cols-4"
      >
        <!-- Street Address -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('app.labels.address') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ propertyAddress.address_1 }}</p>
        </div>

        <!-- City -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('app.labels.city') }}</h4>
          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ propertyAddress.city }}</p>
        </div>

        <!-- State -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('app.labels.state') }}</h4>
          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ propertyAddress.state }}</p>
        </div>

        <!-- Postal code -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('app.labels.postal_code') }}</h4>
          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ propertyAddress.postal_code }}</p>
        </div>
      </div>
      <!-- END Property Address -->
    </div>
    <!-- END Property Section -->
  </TabPanel>
</template>
