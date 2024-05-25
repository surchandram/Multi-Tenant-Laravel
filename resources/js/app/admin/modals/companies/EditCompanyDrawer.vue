<script setup>
  import Drawer from "@/components/modals/Drawer.vue";
  import CompanyProfileForm from "../../../../components/companies/CompanyProfileForm.vue";

  defineProps(["model"]);
</script>

<template>
  <div>
    <Drawer v-slot="{ close }" size="max-w-2xl" :title="__('app.labels.company_settings')">
      <CompanyProfileForm
        :model="model"
        :action="route('admin.companies.update', model.company)"
        :editing="true"
        @close="close"
      />
    </Drawer>
  </div>
</template>
