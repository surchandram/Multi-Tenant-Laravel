<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import AppPagination from "@/components/AppPagination.vue";
  import CompaniesIndexTable from "@/components/admin/companies/CompaniesIndexTable.vue";

  defineProps(["model"]);
</script>

<template>
  <Head :title="`${__('admin.labels.companies')} | ${__('admin.labels.dashboard_title')}`" />

  <div class="min-h-screen">
    <div class="space-y-6">
      <h3
        class="text-sm text-slate-700 font-semibold dark:text-slate-200"
      >{{ __('admin.labels.companies') }}</h3>

      <div class="rounded-md shadow-sm bg-white">
        <p v-if="model.companies.length < 0" class="px-2 text-sm text-center font-medium text-slate-600">
          {{ __('admin.labels.no_companies_found') }}
        </p>

        <!-- Companies -->
        <CompaniesIndexTable :companies="model.companies.data" />
        <!-- End Companies -->
      </div>

      <div class="p-7">
        <AppPagination :meta="model.companies.meta" />
      </div>
    </div>
  </div>
</template>
