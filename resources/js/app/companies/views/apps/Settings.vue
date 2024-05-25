<script setup>
  import { onMounted, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppSvgIcon from '@/components/AppSvgIcon.vue';
  import RestoreSettings from '@/components/apps/RestoreSettings.vue';
  import useAppSettings from '@/composables/useAppSettings';

  defineOptions({
    pageLayout: 'plain',
  });

  const props = defineProps(['model']);

  const appSetings = useAppSettings();

  appSetings.settings = props.model.settings;

  const form = useForm({
    app_id: props.model.app.id,
    company_id: props.model.company.id,
    options: props.model.settings.map,
  });

  const updateSettings = () => {
    form.post(
      route('companies.apps.settings.store', {
        company: props.model.company,
        app: props.model.app,
      }),
    );
  };

  const settings = {
    restore: RestoreSettings,
  };

  onMounted(() => {
    watch(appSetings.settings, (val) => {
      form.options = val;
    });
  });
</script>

<template>
  <div class="container">
    <!-- Header -->
    <header class="flex items-center gap-2 text-sm">
      <a
        :href="route('companies.apps.index', model.company)"
        class="inline-flex items-center gap-2 font-medium text-indigo-400 hover:text-slate-600 focus:text-slate-600"
      >
        <AppSvgIcon name="arrow-left" />
        {{ __('app.labels.manage_apps') }}
      </a>
      <span>|</span>
      <div class="font-medium">{{ model.company.name }}</div>
    </header>

    <div class="container">
      <div class="py-8 px-8 space-y-6 sm:py-4">
        <div class="flex items-center justify-between">
          <!-- App Name -->
          <h1 class="title-font text-base font-medium text-slate-600">
            {{ model.app.name }} | {{ __('app.labels.settings') }}
          </h1>
          <!-- END App Name -->

          <!-- Update Button -->
          <AppButton
            class="inline-flex items-center justify-center"
            :disabled="form.processing"
            @click.prevent="updateSettings"
          >
            {{ __('app.labels.update') }}
          </AppButton>
          <!-- END Update Button -->
        </div>

        <!-- form -->
        <form
          class="space-y-8"
          action="#"
          @submit.prevent="updateSettings"
        >
          <AppValidationErrors :errors="form.errors" />

          <component
            v-if="model.settings && settings[model.app.key]"
            :is="settings[model.app.key]"
            :settings="model.settings"
          />

          <div v-else>{{ __('app.labels.nothing_to_configure') }}</div>

          <!-- Update Button -->
          <div class="flex items-center justify-end">
            <AppButton
              type="submit"
              class="inline-flex items-center justify-center"
              :disabled="form.processing"
              >{{ __('app.labels.update') }}
            </AppButton>
          </div>
          <!-- END Update Button -->
        </form>
        <!-- END Form -->
      </div>
      <!-- END -->
    </div>
    <!-- END container -->
  </div>
  <!-- END container -->
</template>
