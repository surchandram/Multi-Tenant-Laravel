<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import CompanyDashboardTable from "@/components/admin/companies/CompanyDashboardTable.vue";
  import StatCard from "@/components/stats/StatCard.vue";

  defineProps(["model"]);

  const titleCase = (value) => _.startCase(value);
</script>

<template>
  <Head :title="__('admin.labels.dashboard_alt')" />

  <div class="min-h-screen pb-12">
    <!-- Revenue -->
    <div>
      <h3
        class="mb-4 text-sm text-slate-700 font-semibold dark:text-slate-200"
      >{{ __('admin.labels.revenue') }}</h3>

      <div class="flex flex-col md:flex-row gap-4 justify-evenly">
        <!-- Card Item Start -->
        <StatCard
          v-for="(value, key) in model.revenue"
          :key="key"
          :label="titleCase(key)"
          :value="value"
          class="grow"
          theme="admin"
        />
        <!-- Card Item End -->
      </div>
    </div>
    <!-- /Revenue -->

    <div class="mt-6">
      <!-- Companies -->
      <div class>
        <div class="flex item-center justify-between py-3">
          <h3
            class="mb-4 text-sm text-slate-700 font-semibold dark:text-slate-200"
          >{{ __('admin.labels.companies') }}</h3>

          <AppButton theme="success" :href="route('admin.companies.index')">
            {{ __('app.labels.view_all') }}
            <i class="bi bi-arrow-right ml-2"></i>
          </AppButton>
        </div>

        <div class="p-7 rounded-md shadow-sm bg-white">
          <p
            v-if="model.companies.length < 0"
            class="text-sm text-center font-medium text-slate-600"
          >{{ __('admin.labels.no_companies_found') }}</p>

          <CompanyDashboardTable :companies="model.companies" />
        </div>
      </div>
      <!-- End Companies -->
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-6 mt-6">
      <!-- Users -->
      <div class="md:col-span-1 mt-4 md:mt-6 2xl:mt-7.5">
        <h3
          class="mb-4 text-sm text-slate-700 font-semibold dark:text-slate-200"
        >{{ __('admin.labels.users') }}</h3>

        <!-- Cards -->
        <div class="flex flex-col gap-4 justify-evenly">
          <StatCard
            v-for="(value, key) in model.new_users_count"
            :key="key"
            :label="titleCase(key)"
            :value="value"
            theme="admin"
            class="grow"
          />
        </div>
      </div>
      <!-- /Users -->

      <!-- Companies -->
      <div class="md:col-span-1 mt-4 md:mt-6 2xl:mt-7.5">
        <h3
          class="mb-4 text-sm text-slate-700 font-semibold dark:text-slate-200"
        >{{ __('admin.labels.companies') }}</h3>

        <!-- Cards -->
        <div class="flex flex-col gap-4 justify-evenly">
          <StatCard
            v-for="(value, key) in model.new_companies_count"
            :key="key"
            :label="titleCase(key)"
            :value="value"
            theme="admin"
            class="grow"
          />
        </div>
      </div>
      <!-- /Companies -->
    </div>

    <!-- Apps -->
    <div class="mt-4 md:mt-6 2xl:mt-7.5">
      <h3
        class="mb-4 text-sm text-slate-700 font-semibold dark:text-slate-200"
      >{{ __('admin.labels.apps') }}</h3>

      <!-- Cards -->
      <div class="flex flex-col md:flex-row gap-4 justify-evenly">
        <StatCard
          v-for="(value, key) in model.apps_count"
          :key="key"
          :label="titleCase(key)"
          :value="value"
          theme="admin"
          class="grow"
        />
      </div>
    </div>
    <!-- /Apps -->
  </div>
</template>
