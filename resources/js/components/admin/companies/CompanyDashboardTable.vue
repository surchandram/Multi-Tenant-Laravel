<script setup>
  import AppButton from "@/components/AppButton.vue";

  defineProps({
    companies: {
      type: Array,
      required: true,
    },
  });
</script>

<template>
  <div class="flex flex-col">
    <div
      v-for="company in companies"
      :key="company.id"
      class="grid grid-cols-1 md:grid-cols-4 items-center justify-start px-2 md:px-0 py-2 gap-6 text-slate-600 hover:bg-slate-50"
    >
      <h4 class="md:px-4 py-2 text-indigo-600 font-medium">{{ company.name }}</h4>

      <h4 class="md:px-4 py-2 text-sm text-slate-600 font-medium">{{ company.address?.formattedAddress }}</h4>

      <p class="font-medium">
        <span
          :class="[company.has_subscription ? 'bg-indigo-200' : 'bg-slate-200']"
          class="px-4 py-2 rounded-full text-indigo-600"
        >{{ company.has_subscription ? __('app.labels.subscribed') : __('app.labels.not_subscribed') }}</span>
      </p>

      <aside class="flex items-center justify-end md:justify-start gap-3 px-4">
        <AppButton :href="route('admin.companies.show', company)" theme="info" class="text-xs">
          {{ __('app.labels.view') }}
          <i class="bi bi-arrow-right ml-1"></i>
        </AppButton>
        <!-- END View Link -->
      </aside>
    </div>
  </div>
</template>
