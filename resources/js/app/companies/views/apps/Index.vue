<script setup>
  import AppButton from '@/components/AppButton.vue';
  import LucideIcon from '@/components/LucideIcon.vue';

  defineOptions({
    pageLayout: 'plain',
  });

  defineProps(['model']);
</script>

<template>
  <div>
    <div class="container">
      <div class="flex items-center gap-2 text-sm">
        <a
          :href="route('tenant.switch', model.company)"
          class="font-medium text-indigo-400 hover:text-slate-600 focus:text-slate-600"
        >
          <LucideIcon
            name="arrow-left"
            class="w-8 h-8"
          />
        </a>

        <span>|</span>

        <h1 class="inline-flex items-center gap-2 font-medium text-slate-700">
          <LucideIcon
            name="layout-grid"
            class="w-8 h-8"
          />
          {{ __('app.labels.manage_apps') }} | {{ model.company.name }}
        </h1>
      </div>

      <div class="py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="app in model.apps"
            :key="app.id"
            class="p-4"
          >
            <div class="h-full rounded-lg shadow overflow-hidden">
              <div class="flex gap-2 px-4 py-6 bg-slate-50">
                <!-- App Logo -->
                <img
                  class="w-24 h-24 object-cover object-center"
                  :src="app.logo"
                  alt="blog"
                />

                <!-- App Name -->
                <h1 class="my-auto text-lg font-medium text-slate-600">
                  {{ app.name }}
                </h1>
              </div>

              <div class="flex flex-col p-6 bg-white">
                <!-- App Description -->
                <div class="flex items-center gap-2 py-4 mb-3">
                  <p class="leading-relaxed truncate">
                    {{ app.description }}
                  </p>
                </div>

                <!-- Meta | Actions -->
                <div class="flex items-center flex-wrap mt-auto">
                  <!-- Subscribers -->
                  <span
                    v-if="app.subscribers_count"
                    class="text-slate-600 mr-3 inline-flex items-center leading-none text-sm pr-3 py-1 border-r-2 border-gray-200"
                  >
                    <LucideIcon
                      name="download"
                      class="w-4 h-4 mr-1"
                    />
                    {{ app.subscribers_count }}
                  </span>

                  <!-- Reviews -->
                  <span
                    v-if="app.reviews_count"
                    class="inline-flex items-center mr-auto text-slate-600 leading-none text-sm"
                  >
                    <LucideIcon
                      name="message-square-text"
                      class="w-4 h-4 mr-1"
                    />{{ app.subscribers_count }}
                  </span>

                  <!-- Manage Link -->
                  <AppButton
                    v-if="model.company.apps.find((capp) => capp.app.key == app.key)"
                    :href="route('companies.apps.settings.index', { company: model.company, app: app })"
                    class="inline-flex items-center gap-2 ml-auto"
                  >
                    <LucideIcon
                      name="settings"
                      class="w-5 h-5"
                    />
                    {{ __('app.labels.settings') }}
                  </AppButton>

                  <!-- Setup Link -->
                  <AppButton
                    v-else
                    :href="route('companies.apps.setup.index', { company: model.company, app: app })"
                    :title="`${__('app.labels.setup')} ${app.name}`"
                    class="inline-flex items-center gap-2 ml-auto md:mb-2 lg:mb-0"
                    theme="success"
                  >
                    <span>{{ __('app.labels.setup') }}</span>
                    <LucideIcon
                      name="download"
                      class="w-5 h-5"
                    />
                  </AppButton>
                  <!-- END Setup Link -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
