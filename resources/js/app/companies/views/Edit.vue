<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { ref } from 'vue';
  import { Head } from '@inertiajs/vue3';
  import AppTabs from '@/components/AppTabs.vue';
  import ManageAddresses from '../partials/ManageAddresses.vue';
  import ManageTeams from '../partials/ManageTeams.vue';
  import UpsertCompanyForm from '../partials/UpsertCompanyForm.vue';
  import ManageRoles from '../partials/ManageRoles.vue';

  const props = defineProps(['model']);

  const address = ref({
    id: props.model.company.address?.id,
    name: props.model.company.address?.name,
    address_1: props.model.company.address?.address_1,
    address_2: props.model.company.address?.address_2,
    state: props.model.company.address?.state,
    city: props.model.company.address?.city,
    postal_code: props.model.company.address?.postal_code,
    country_id: props.model.company.address?.country_id,
  });

  const tabs = {
    profile: {
      name: 'Company Info',
    },
    address: {
      name: 'Business Address',
    },
    teams: {
      name: 'Teams',
    },
    roles: {
      name: 'Roles',
    },
  };
</script>

<template>
  <Head :title="`Company Settings - ${model.company.name}`" />

  <div class="flex flex-col min-h-screen pb-12">
    <div class="flex flex-wrap py-6 lg:pb-2 rounded shadow-lg bg-white">
      <div class="w-full mx-auto mb-12 xl:mb-0 px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-center gap-y-3 mb-5">
          <h3 class="font-semibold text-xl text-slate-700">{{ __('app.labels.company_settings') }}</h3>
        </div>
        <!-- /Header -->

        <AppTabs :tabs="tabs">
          <template #content="{ isCurrentTab }">
            <div class="flex flex-col min-w-0 break-words w-full pb-2">
              <!-- Company Profile Form -->
              <div v-if="isCurrentTab('profile')">
                <UpsertCompanyForm
                  :model="model"
                  :editing="true"
                />
              </div>
              <!-- /Company Profile Form -->

              <!-- Address Tab -->
              <div v-if="isCurrentTab('address')">
                <ManageAddresses
                  v-model="address"
                  :company="model.company"
                  :addresses="model.addresses"
                  :countries="model.countries"
                />
              </div>
              <!-- /Address Tab -->

              <!-- Team Tab -->
              <div v-if="isCurrentTab('teams')">
                <ManageTeams
                  :company="model.company"
                  :teams="model.teams"
                />
              </div>
              <!-- /Team Tab -->

              <!-- Roles Tab -->
              <div v-if="isCurrentTab('roles')">
                <ManageRoles
                  :model="model"
                  :company="model.company"
                  :permissions="model.permissions || []"
                  :roles="model.editable_roles || []"
                />
              </div>
              <!-- /Roles Tab -->
            </div>
          </template>
        </AppTabs>
      </div>
    </div>
  </div>
</template>
