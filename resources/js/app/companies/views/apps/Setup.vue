<script setup>
  import { onMounted, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppInput from '@/components/AppInput.vue';
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

  const handleSetup = () => {
    form.post(
      route('companies.apps.setup.index', {
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
  <div>
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

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-8">
        <!-- App Summary -->
        <div class="col-span-1">
          <div class="border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
            <!-- App Logo -->
            <img
              class="lg:h-48 md:h-36 w-full object-cover object-center"
              :src="model.app.logo"
              alt="blog"
            />

            <div class="flex flex-col p-6">
              <!-- App Description -->
              <div class="flex items-center gap-2 py-4 mb-3">
                <p class="leading-relaxed">
                  {{ model.app.description }}
                </p>
              </div>

              <!-- Meta | Actions -->
              <div class="flex items-center flex-wrap mt-auto">
                <!-- Subscribers -->
                <span
                  v-if="model.app.subscribers_count"
                  class="text-slate-600 mr-3 inline-flex items-center leading-none text-sm pr-3 py-1 border-r-2 border-gray-200"
                >
                  <AppSvgIcon
                    name="download"
                    class="w-4 h-4 mr-1"
                  />
                  {{ model.app.subscribers_count }}
                </span>

                <!-- Reviews -->
                <span
                  v-if="model.app.reviews_count"
                  class="inline-flex items-center lg:mr-auto md:mr-0 mr-auto text-slate-600 leading-none text-sm"
                >
                  <AppSvgIcon
                    name="chat-right-text"
                    class="w-4 h-4 mr-1"
                  />{{ model.app.reviews_count }}
                </span>
              </div>
              <!-- END Meta | Actions -->

              <!-- Features -->
              <div
                v-if="model.app.features.length > 0"
                class="space-y-2"
              >
                <h3 class="font-semibold text-sm text-slate-600">{{ __('app.labels.features') }}</h3>

                <div
                  v-for="feature in model.app.features"
                  :key="feature.id"
                >
                  <h4 class="text-sm font-medium">
                    {{ feature.name }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END App Summary -->

        <div class="col-span-2">
          <div class="py-8 px-8 space-y-6 sm:py-4">
            <!-- App Name -->
            <h1 class="title-font text-lg font-medium text-slate-700">
              {{ model.app.name }} | {{ __('app.labels.setup') }}
            </h1>

            <form
              class="space-y-8"
              action="#"
              @submit.prevent="handleSetup"
            >
              <component
                v-if="model.settings && settings[model.app.key]"
                :is="settings[model.app.key]"
                :settings="model.settings"
              />

              <div v-else>{{ __('app.labels.nothing_to_configure') }}</div>

              <div class="flex items-center justify-end">
                <!-- Setup Link -->
                <AppButton
                  type="submit"
                  class="w-full inline-flex items-center justify-center md:mb-2 lg:mb-0"
                  >{{ __('app.labels.setup') }}
                  <AppSvgIcon
                    name="arrow-right"
                    class="w-4 h-4 ml-2"
                  />
                </AppButton>
                <!-- END Setup Link -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
