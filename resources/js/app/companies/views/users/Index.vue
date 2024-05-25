<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { ref } from 'vue';
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import CompanyUsersDataTable from '../../partials/CompanyUsersDataTable.vue';
  import AppButton from '@/components/AppButton.vue';

  defineProps(['model']);

  const showFilters = ref(false);

  const toggleFilters = (value) => {
    showFilters.value = value;
  };
</script>

<template>
  <Head :title="`Users | ${model.company.name}`" />

  <div class="px-6 md:px-8">
    <!-- heading area -->
    <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-3">
      <!-- Heading -->
      <div class="flex flex-col gap-3 mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
          <span class="font-semibold"> {{ model.company.name }} - Users </span>
        </h1>

        <p class="text-sm text-slate-700">Manage company users from here.</p>
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <!-- Edit Button -->
        <AppButton
          class="flex items-center gap-2"
          :href="route('companies.users.create', model.company)"
        >
          <span class="text-sm lg:text-2xl">
            <i class="bi bi-person-plus"></i>
          </span>
          Add User
        </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full py-6">
      <!-- Filters -->
      <div
        v-if="showFilters"
        class="w-full flex mb-3"
      >
        <!-- todo: filters map goes here -->
      </div>
      <!-- /Filters -->

      <CompanyUsersDataTable
        :model="model"
        @toggle-filters="toggleFilters"
      />
    </div>
  </div>
</template>
