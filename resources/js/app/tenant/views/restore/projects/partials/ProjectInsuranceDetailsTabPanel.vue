<script setup>
  import { computed } from 'vue';
  import { TabPanel } from '@headlessui/vue';
  import { useMomentJS } from '@/composables/momentjs';
  import { has, isEmpty } from 'lodash';
  import parsePhoneNumber from 'libphonenumber-js';

  const props = defineProps({
    project: {
      required: true,
      type: Object,
    },
  });

  const companyPhoneNumber = computed(() =>
    parsePhoneNumber(`+${props.project.insurance.company.phone}`)?.formatInternational(),
  );

  const agentPhoneNumber = computed(() =>
    parsePhoneNumber(`+${props.project.insurance.agent.phone}`)?.formatInternational(),
  );

  const adjusterPhoneNumber = computed(() =>
    parsePhoneNumber(`+${props.project.insurance.adjuster.phone}`)?.formatInternational(),
  );

  const insurance = computed(() => (has(props.project, 'insurance') ? props.project.insurance : {}));
</script>

<template>
  <TabPanel class="p-3">
    <!-- Overview -->
    <div
      v-if="!isEmpty(insurance)"
      class="mb-6 space-y-2"
    >
      <!-- Deductible -->
      <div class="grid gap-2 md:grid-cols-4">
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.insurance_deductible') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.formatted_deductible }}</p>
        </div>
      </div>
      <!-- END Deductible -->

      <!-- Claim no/Policy -->
      <div class="grid gap-2 mt-6 md:grid-cols-4">
        <!-- claim no -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.claim_no') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.claim_no }}</p>
        </div>

        <!-- Policy no -->
        <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.policy_no') }}</h4>

          <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.policy_no }}</p>
        </div>
      </div>
      <!-- END claim_no/Policy no -->
    </div>

    <p
      v-else
      class="font-medium text-slate-500"
    >
      {{ __('app.labels.no_data_found') }}
    </p>
    <!-- END Overview -->

    <!-- Company -->
    <div
      v-if="insurance?.company"
      class="mb-6 space-y-2"
    >
      <h3 class="text-lg text-slate-700 dark:text-slate-200">{{ __('app.labels.company') }}</h3>

      <template v-if="insurance.company">
        <!-- Name -->
        <div class="grid gap-2 md:grid-cols-4">
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <h4 class="text-sm font-semibold">{{ __('app.labels.name') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.company.name }}</p>
          </div>
        </div>
        <!-- END Name -->

        <!-- Phone/Email -->
        <div class="grid gap-2 mt-6 md:grid-cols-4">
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <!-- Phone -->
            <h4 class="text-sm font-semibold">{{ __('app.labels.phone') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ companyPhoneNumber }}</p>
          </div>
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <!-- Email -->
            <h4 class="text-sm font-semibold">{{ __('app.labels.email') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.company.email }}</p>
          </div>
        </div>
        <!-- END Phone/Email -->
      </template>

      <p
        v-else
        class="font-medium text-slate-600 dark:text-indigo-200"
      >
        {{ __('app.labels.no_data_found') }}
      </p>
    </div>
    <!-- END Company -->

    <!-- Insurance Agent -->
    <div
      v-if="insurance?.agent"
      class="mb-6 space-y-2"
    >
      <h3 class="text-lg text-slate-700 dark:text-slate-200">{{ __('tenant.labels.insurance_agent') }}</h3>

      <template v-if="insurance.agent">
        <!-- Name -->
        <div class="grid gap-2 md:grid-cols-4">
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <h4 class="text-sm font-semibold">{{ __('app.labels.name') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.agent.name }}</p>
          </div>
        </div>
        <!-- END Name -->

        <!-- Phone/Email -->
        <div class="grid gap-2 mt-6 md:grid-cols-4">
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <!-- Phone -->
            <h4 class="text-sm font-semibold">{{ __('app.labels.phone') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ agentPhoneNumber }}</p>
          </div>
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <!-- Email -->
            <h4 class="text-sm font-semibold">{{ __('app.labels.email') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.agent.email }}</p>
          </div>
        </div>
        <!-- END Phone/Email -->
      </template>

      <p
        v-else
        class="font-medium text-slate-600 dark:text-indigo-200"
      >
        {{ __('app.labels.no_data_found') }}
      </p>
    </div>
    <!-- END Insurance Agent -->

    <!-- Insurance Adjuster -->
    <div
      v-if="insurance?.adjuster"
      class="mb-6 space-y-2"
    >
      <h3 class="text-lg text-slate-700 dark:text-slate-200">{{ __('tenant.labels.insurance_adjuster') }}</h3>

      <template v-if="insurance.adjuster">
        <!-- Name -->
        <div class="grid gap-2 md:grid-cols-4">
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <h4 class="text-sm font-semibold">{{ __('app.labels.name') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.adjuster.name }}</p>
          </div>
        </div>
        <!-- END Name -->

        <!-- Phone/Email -->
        <div class="grid gap-2 mt-6 md:grid-cols-4">
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <!-- Phone -->
            <h4 class="text-sm font-semibold">{{ __('app.labels.phone') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ adjusterPhoneNumber }}</p>
          </div>
          <div class="py-2 space-y-2 text-base col-span-full md:col-span-1">
            <!-- Email -->
            <h4 class="text-sm font-semibold">{{ __('app.labels.email') }}</h4>

            <p class="font-medium text-slate-600 dark:text-indigo-200">{{ insurance.adjuster.email }}</p>
          </div>
        </div>
        <!-- END Phone/Email -->
      </template>

      <p
        v-else
        class="font-medium text-slate-600 dark:text-indigo-200"
      >
        {{ __('app.labels.no_data_found') }}
      </p>
    </div>
    <!-- END Insurance Adjuster -->
  </TabPanel>
</template>
