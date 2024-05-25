<script setup>
  import { computed } from 'vue';
  import { Head, Link } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { Button } from '@/components/ui/button';

  const props = defineProps(['model']);

  const hasCompanies = computed(() => _.size(props.model?.companies) > 0);
</script>

<template>
  <Head :title="__('app.labels.dashboard')" />

  <div class="min-h-screen dark:bg-slate-900 pb-12">
    <div class="py-4 border-t-2 border-slate-200 bg-white shadow-sm dark:bg-slate-950 dark:border-slate-700">
      <div class="container">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-slate-600 dark:text-primary">{{ __('app.labels.dashboard') }}</h3>

          <AppButton
            v-if="hasCompanies"
            :href="route('companies.create')"
            >{{ __('app.buttons.new_company') }}</AppButton
          >
        </div>
      </div>
    </div>

    <!-- Companies Section -->
    <div class="container py-4 mt-8">
      <div class="space-y-4">
        <h3
          v-if="hasCompanies"
          class="text-lg text-slate-600 dark:text-primary font-medium"
        >
          {{ __('app.labels.your_companies') }}
        </h3>

        <div
          v-else
          class="flex flex-col space-x-2 space-y-6 text-center text-sm font-medium text-slate-500"
        >
          <p>{{ __('app.labels.no_companies') }}</p>

          <div class="mx-auto">
            <AppButton
              theme="info"
              :href="route('companies.create')"
              >{{ __('app.buttons.start_here') }}</AppButton
            >
          </div>
        </div>

        <div class="flex flex-col -py-1 divide-y-2 divide-indigo-200 rounded-md bg-white shadow dark:bg-slate-900">
          <div
            v-for="company in model.companies"
            :key="company.id"
            class="flex flex-col md:flex-row items-baseline justify-between py-2 first:rounded-t-md last:rounded-b-md text-slate-600 bg-white hover:bg-indigo-100 dark:bg-slate-950 dark:hover:bg-slate-900 transition-all"
          >
            <h4 class="px-4 py-2 text-secondary-foreground dark:text-primary font-medium">{{ company.name }}</h4>

            <aside class="flex items-center gap-3 px-4">
              <Button
                as="a"
                :href="route('tenant.switch', company)"
                size="sm"
                class="gap-2"
                variant="primary"
              >
                {{ __('app.labels.dashboard') }}

                <LucideIcon
                  name="arrow-right"
                  class="h-4 w-4"
                />
              </Button>
              <!-- END Tenant Switch Link -->

              <!-- Company Settings Link -->
              <Button
                :href="route('companies.show', company)"
                :as="Link"
                variant="success"
                size="sm"
                class="gap-2"
              >
                <LucideIcon
                  name="settings"
                  class="h-4 w-4"
                />
                {{ __('app.labels.settings') }}
              </Button>
              <!-- END Company Settings Link -->
            </aside>
          </div>
        </div>
      </div>
    </div>
    <!-- END Companies Section -->
  </div>
</template>
