<script>
  export default {
    pageLayout: 'company_project',
  };
</script>

<script setup>
  import { inject, onMounted, computed, reactive } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import PsychrometricReportEditor from './partials/PsychrometricReportEditor.vue';
  import PsychrometricReportDeviceSetupTab from './partials/PsychrometricReportDeviceSetupTab.vue';
  import PsychrometricReportInspectionDateTab from './partials/PsychrometricReportInspectionDateTab.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppTabs from '@/components/AppTabs.vue';
  import { useMomentJS } from '@/composables/momentjs.js';

  const props = defineProps(['model']);

  const { dateFormat } = useMomentJS();

  const state = reactive({
    device_map: props.model.device_map,
  });

  const form = useForm({
    psychrometric_report: _.merge(props.model.psychrometric_report_skeleton, props.model.psychrometric_report),
  });

  const projectName = computed(() => props.model.project.name || 'Untitled Project');

  const hasNoAffectedAreas = computed(() => props.model.project.affectedAreas < 1);

  const reviewButtonLink = computed(() => (form.processing ? '' : route('restore.projects.show', props.model.project)));

  const editButtonLink = computed(() => (form.processing ? '' : route('restore.projects.edit', props.model.project)));

  const buttonsDisabled = computed(() => hasNoAffectedAreas.value || tabs.value.length < 1 || form.processing);

  onMounted(() => {
    $eventBus.on('psychrometric-report-map::updated', () => {
      state.device_map = props.model.device_map;
    });

    // emit 'setup-project-sidebar'
    $eventBus.emit('setup-project-sidebar', props.model.project);
  });

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body', options = {}) => {
    $scrollTo(el, Object.assign({}, { container: 'body' }, options));
  };

  const tabs = computed(() =>
    _.merge(
      { 'Device Setup': 'Device Setup' },
      _.keyBy(_.keys(form.psychrometric_report), (v) => v),
    ),
  );

  const store = () => {
    scrollTo();
    form.clearErrors();

    form.get(route('restore.projects.psychrometric-report.index', props.model.project), {
      onSuccess: () => {
        form.defaults('psychrometric_report', props.model.psychrometric_report);
        form.reset();
      },
    });
  };

  const resetForm = () => {
    form.defaults(
      'psychrometric_report',
      _.merge(props.model.psychrometric_report_skeleton, props.model.psychrometric_report),
    );

    form.reset();
  };
</script>

<template>
  <Head :title="`${__('tenant.labels.psychrometric_report')} | ${projectName} | Restore`" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-3">
      <!-- Heading -->
      <div class="flex flex-col gap-3 mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
          <span class="font-semibold"> {{ projectName }} - {{ __('tenant.labels.psychrometric_report') }} </span>
        </h1>

        <p class="text-sm font-medium text-slate-700">
          {{ __('tenant.labels.project_schedule') }}:
          <span class="font-semibold">
            {{ dateFormat(model.project.starts_at) }} - {{ dateFormat(model.project.ends_at) }}
          </span>
        </p>
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3"></div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Validation Errors -->
      <AppValidationErrors
        :errors="form.errors"
        :class="{ 'mb-5': form.errors }"
      />

      <!-- Psychrometric Report -->
      <div v-if="!tabs.length">
        <AppTabs
          :tabs="tabs"
          index-as-label
        >
          <template #content="{ currentTab }">
            <!-- PsychrometricReportDeviceSetupTab -->
            <PsychrometricReportDeviceSetupTab
              v-if="currentTab == 'Device Setup'"
              :data="state.device_map"
              :project="model.project"
            />
            <!-- END PsychrometricReportDeviceSetupTab -->

            <PsychrometricReportInspectionDateTab
              v-else
              :affected-areas="form.psychrometric_report[currentTab]"
              :recording-date="currentTab"
            />
          </template>
        </AppTabs>
      </div>

      <!-- Empty -->
      <p
        v-else
        class="inline-flex items-center gap-2 text-sm font-medium text-slate-400"
      >
        No report found for project.
      </p>
      <!-- END Psychrometric Report -->

      <!-- Buttons -->
      <div class="flex items-center justify-end gap-3 mt-8">
        <!-- Save Button -->
        <AppButton
          class="inline-flex items-center gap-2"
          :disabled="buttonsDisabled"
          @click="store"
        >
          <AppSpinner
            v-if="form.processing"
            :size="4"
          />
          <span
            v-else
            class="text-sm leading-none"
          >
            <i class="bi bi-check"></i>
          </span>
          {{ __('app.labels.save') }}
        </AppButton>

        <!-- Review -->
        <AppSuccessButton
          :href="reviewButtonLink"
          :disabled="buttonsDisabled"
          class="inline-flex items-center gap-2"
        >
          <span class="text-sm leading-none"><i class="bi bi-eye"></i></span> {{ __('app.labels.review') }}
        </AppSuccessButton>
      </div>
      <!-- END Buttons -->
    </div>
    <!-- END Content Area -->

    <PsychrometricReportEditor
      :model="model"
      @psychrometric-report::updated="resetForm"
    />
  </div>
</template>

<style lang="scss" scoped>
  .accordion-collapse {
    &.collapse {
      visibility: visible !important;

      &:not(.show) {
        display: none;
      }
    }

    .collapsing {
      height: 0;
      overflow: hidden;

      &.collapse-horizontal {
        width: 0;
        height: auto;
      }
    }
  }

  .accordion-button {
    &[aria-expanded='true'] {
      & > i.opened {
        display: block;
      }

      & > i.closed {
        display: none;
      }
    }

    &[aria-expanded='false'] {
      & > i.opened {
        display: none;
      }

      & > i.closed {
        display: block;
      }
    }
  }
</style>
