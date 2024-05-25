<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { watch } from 'vue';
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import { useMomentJS } from '@/composables/momentjs';

  const { dateFormat } = useMomentJS();

  defineProps(['model']);
</script>

<template>
  <Head :title="`${model.company.name} | Company Settings`" />

  <div class="flex flex-col min-h-screen">
    <div class="relative flex flex-wrap py-12">
      <div class="w-full mx-auto mb-12 xl:mb-0 px-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center mb-5">
          <div class="relative w-full px-4 max-w-full flex-grow flex-1">
            <h3 class="font-semibold text-xl text-slate-700">Team Overview</h3>
          </div>

          <aside class="flex items-center gap-2">
            <AppLightButton
              :href="route('tenant.switch', model.company.id)"
              class="flex items-center gap-2"
            >
              <i class="bi bi-arrow-left text-xl"></i> Back to Dashboard
            </AppLightButton>

            <AppButton
              :href="route('companies.edit', model.company.id)"
              class="flex items-center gap-2"
            >
              <i class="bi bi-building-gear text-xl"></i>
              Edit
            </AppButton>
          </aside>
        </div>
        <!-- /Header -->

        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 pb-4 shadow-lg rounded">
          <div class="rounded-t mb-0 px-4 py-3 border-0">
            <p>Here you'll see general information about your company.</p>
          </div>

          <!-- Overview -->
          <div class="block w-full overflow-x-auto">
            <div class="px-4">
              <!-- logo -->
              <div class="flex flex-col md:flex-row md:items-center gap-4 py-2 mb-3">
                <img
                  class="w-48 h-48 rounded-full"
                  :src="model.company.logo"
                />

                <div class="flex-1">
                  <!-- Edit Link -->
                  <AppButton :href="route('companies.edit', model.company.id)">
                    {{ __('app.labels.choose_logo') }}
                  </AppButton>
                  <!-- END Edit Link -->
                </div>
              </div>

              <div class="flex flex-col divide-y divide-slate-300 gap-y-2">
                <!-- name -->
                <div class="py-2 space-y-1">
                  <h4 class="text-xs text-slate-600 font-semibold">{{ __('app.labels.company_name') }}</h4>
                  <p class="text-sm font-semibold">{{ model.company.name }}</p>
                </div>

                <!-- email -->
                <div class="py-2 space-y-1">
                  <h4 class="text-xs text-slate-600 font-semibold">{{ __('app.labels.email') }}</h4>
                  <p class="text-sm font-semibold">{{ model.company.email }}</p>
                </div>

                <!-- domain -->
                <div class="py-2 space-y-1">
                  <h4 class="text-xs text-slate-600 font-semibold">{{ __('app.labels.company_domain') }}</h4>
                  <p class="text-sm font-semibold">{{ model.company.domain }}.{{ $page.props.appDomain }}</p>
                </div>

                <!-- created_at -->
                <div class="py-2 space-y-1">
                  <h4 class="text-xs text-slate-600 font-semibold">{{ __('app.labels.joined_on') }}</h4>
                  <p class="text-sm font-semibold">
                    {{ dateFormat(model.company.created_at, 'MMM Do, YYYY') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- /Overview -->
        </div>
      </div>
    </div>
  </div>
</template>
