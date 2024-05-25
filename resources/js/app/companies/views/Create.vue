<script>
  export default {
    pageLayout: 'plain',
  };
</script>

<script setup>
  import { Head } from '@inertiajs/vue3';
  import UpsertCompanyForm from '../partials/UpsertCompanyForm.vue';

  defineProps(['model']);
</script>

<template>
  <Head :title="__('app.labels.add_new_company')" />

  <div class="min-h-screen flex flex-col bg-slate-100">
    <!-- Site Logo -->
    <div class="mx-auto">
      <a
        :href="route('home')"
        class="w-24 block"
      >
        <img
          v-if="$page.props.logoData['small']"
          :src="$page.props.logoData['small']"
          alt
        />
        <span
          v-else
          class="text-xl text-slate-600 leading-none font-semibold"
          >{{ $page.props.appName }}</span
        >
      </a>
    </div>
    <!-- END Site Logo -->

    <div class="flex flex-wrap py-12">
      <div class="w-full xl:w-8/12 px-4 mx-auto mb-12 xl:mb-0 space-y-6 relative z-50">
        <div class="w-full min-w-0 flex flex-col p-7 mb-6 space-y-4 rounded-md break-words bg-white shadow-sm">
          <!-- Header -->
          <div class="flex flex-wrap items-start">
            <!-- Title -->
            <div class="w-full max-w-full flex-1">
              <h3 class="text-xl font-medium text-slate-500">{{ __('app.labels.add_new_company') }}</h3>

              <p class="mt-2 mb-4 text-sm font-medium text-slate-500">
                {{ __('app.labels.add_company_form_details') }}
              </p>
            </div>
            <!-- END Title -->

            <div class="relative flex-1 flex-grow w-full max-w-full px-4 text-right">
              <a
                :href="route('dashboard')"
                class="px-3 py-2 rounded-md font-semibold focus:outline-none focus:ring transition ease-linear duration-150"
              >
                <i class="bi bi-x-lg"></i>
              </a>
            </div>
          </div>
          <!-- /Header -->

          <!-- Form -->
          <UpsertCompanyForm :model="model || {}" />
          <!-- /Form -->
        </div>
      </div>
    </div>
  </div>
</template>
