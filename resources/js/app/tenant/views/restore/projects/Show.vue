<script>
  export default {
    pageLayout: 'company_project',
  };
</script>

<script setup>
  import { inject, onMounted, reactive, watch, computed, ref } from 'vue';
  import { Head, useForm, Link, router } from '@inertiajs/vue3';
  import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
  import { useToast } from 'vue-toastification';
  import { omitBy, isEmpty, cloneDeep, map } from 'lodash';
  import tippy from 'tippy.js';
  import { useMomentJS } from '@/composables/momentjs';
  import ProjectClaimDetailsTabPanel from './partials/ProjectClaimDetailsTabPanel.vue';
  import ProjectOwnerDetailsTabPanel from './partials/ProjectOwnerDetailsTabPanel.vue';
  import ProjectInsuranceDetailsTabPanel from './partials/ProjectInsuranceDetailsTabPanel.vue';
  import ProjectLogsTabPanel from './partials/ProjectLogsTabPanel.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppConfirmationDialogModal from '@/components/AppConfirmationDialogModal.vue';
  import AppModal from '@/components/AppModal.vue';
  import ChevronDown from '@/components/ChevronDown.vue';

  const props = defineProps(['model']);

  const { dateFormat } = useMomentJS();

  const toast = useToast();

  const promptSignatureBtnRef = ref(null);

  const state = reactive({
    use_property_address: true,
    features: [],
    plans: [],
    tabs: ['Claim Details', 'Owner Details', 'Insurance', 'Daily Logs'],
  });

  const __ = inject('$translate');

  const form = useForm({
    name: props.model.project.name,
    type_id: props.model.project.type_id,
    description: props.model.project.description,
    contacted_at: props.model.project.contacted_at,
    loss_occurred_at: props.model.project.loss_occurred_at,
    point_of_loss: props.model.project.point_of_loss,
    category_id: props.model.project.category_id,
    class_id: props.model.project.class_id,
    affected_areas: [],
    starts_at: props.model.project.starts_at,
    ends_at: props.model.project.ends_at,
    overview: props.model.project.overview,
    address: {
      name: props.model.project.address?.name,
      address_1: props.model.project.address?.address_1,
      address_2: props.model.project.address?.address_2,
      state: props.model.project.address?.state,
      city: props.model.project.address?.city,
      postal_code: props.model.project.address?.postal_code,
      country_id: props.model.project.address?.country_id,
    },
    owner: {
      name: props.model.project.owner?.name,
      email: props.model.project.owner?.email,
      phone: props.model.project.owner?.phone,
      address: props.model.project.owner?.address || {},
    },
    insurance: {
      id: props.model.project.insurance?.id,
      claim_no: props.model.project.insurance?.claim_no,
      policy_no: props.model.project.insurance?.policy_no,
      deductible: props.model.project.insurance?.deductible,
      company: {
        id: props.model.project.insurance?.company?.id,
        name: props.model.project.insurance?.company?.name,
        email: props.model.project.insurance?.company?.email,
        phone: props.model.project.insurance?.company?.phone,
      },
      agent: {
        id: props.model.project.insurance?.agent?.id,
        name: props.model.project.insurance?.agent?.name,
        email: props.model.project.insurance?.agent?.email,
        phone: props.model.project.insurance?.agent?.phone,
      },
      adjuster: {
        id: props.model.project.insurance?.adjuster?.id,
        name: props.model.project.insurance?.adjuster?.name,
        email: props.model.project.insurance?.adjuster?.email,
        phone: props.model.project.insurance?.adjuster?.phone,
      },
    },
  });

  const projectName = computed(() => props.model.project.name || 'Untitled Project');

  const moistureMapLink = computed(() =>
    props.model.project.affectedAreas?.length < 1
      ? ''
      : window.route('restore.projects.moisture-map.index', props.model.project),
  );

  const psychrometricReportLink = computed(() =>
    props.model.project.affectedAreas?.length < 1
      ? ''
      : window.route('restore.projects.psychrometric-report.index', props.model.project),
  );

  const allowedProjectStatuses = computed(() => {
    return omitBy(
      props.model.statuses,
      (s) => s.priority_level <= props.model.statuses[props.model.project.status?.slug]?.priority_level,
    );
  });

  const statusConfirmationMessage = ref(null);

  const openStatusConfirmationDialog = async (statusData, status, close) => {
    statusConfirmationMessage.value = __('tenant.project.status_change_prompt', { status: statusData.label });

    $eventBus.emit('show-confirmation-dialog-modal', {
      title: __('app.labels.change_status'),
      message: statusConfirmationMessage.value,
      callback: () => handleStatusUpdate(status, close),
    });
  };

  const handleStatusUpdate = (status, close) => {
    router.post(
      route('restore.projects.status.update', props.model.project),
      { status: status },
      {
        onSuccess: () => {
          $eventBus.emit('hide-confirmation-dialog-modal');
          close();
        },
        onError: (errors) => {
          handleStatusUpdateError(errors);
          close();
        },
      },
    );
  };

  const handleStatusUpdateError = (errors) => {
    if (errors.status) {
      toast.error(errors?.status);
    } else {
      toast.error(__('tenant.project.status_update_failed'));
    }
  };

  onMounted(() => {
    $eventBus.emit('setup-project-sidebar', props.model.project);

    tippy(promptSignatureBtnRef.value, {
      content: 'Collect Signature',
      theme: 'light',
    });
  });

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body') => {
    $scrollTo(el, { container: 'body' });
  };
</script>

<template>
  <Head title="Project Overview | Restore" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-start">
      <div class="space-y-3 mr-auto">
        <!-- Project name -->
        <h1 class="text-slate-800 dark:text-indigo-200 text-2xl font-medium">
          {{ projectName }}
        </h1>
        <!-- END Project name -->

        <!-- Description -->
        <div class="flex items-baseline flex-wrap gap-2">
          <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ model.project.description }}</p>

          <a
            href="#"
            class="inline-flex items-center gap-2 px-2 py-1 rounded-md text-sm font-semibold bg-blue-200 text-blue-600 hover:bg-blue-400 hover:text-white transition ease-in duration-200 focus:ring"
            @click="$eventBus.emit('open-modal', 'projectAssessmentModal')"
          >
            <i class="bi bi-journal-medical"></i>
            {{ __('tenant.project.view_assessment_button') }}
          </a>
        </div>

        <!-- Project Schedule -->
        <div class="flex items-baseline flex-wrap gap-y-2 py-2 text-sm">
          <h4 class="text-sm font-semibold">{{ __('tenant.labels.project_schedule') }}&colon;&nbsp;</h4>

          <p class="text-slate-600 dark:text-indigo-200">
            {{ dateFormat(model.project.starts_at) }} - {{ dateFormat(model.project.ends_at) }}
          </p>
        </div>

        <!-- Status Badge -->
        <p class="inline-flex items-center flex-wrap gap-2 text-sm font-semibold mb-6">
          {{ __('tenant.labels.status') }}&colon;
          <span class="px-1 py-1 rounded-md bg-blue-200 text-blue-600">{{ model.project.status?.name }}</span>
        </p>
        <!-- END Status Badge -->
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <!-- Actions -->
        <Menu
          v-slot="{ open }"
          as="div"
          class="relative inline-block text-left"
        >
          <div class="inline-flex items-center rounded-l-md">
            <!-- Signature Button -->
            <div
              ref="promptSignatureBtnRef"
              class="rounded-l-md"
            >
              <AppButton
                class="flex items-center gap-2 rounded-r-none"
                theme="info"
                :href="route('restore.projects.authorization.index', model.project)"
              >
                <i class="bi bi-pen"></i>
              </AppButton>
            </div>
            <!-- /Signature Button -->

            <!-- Edit Button -->
            <AppButton class="flex items-center gap-2 rounded-none">
              <i class="bi bi-bell"></i>
            </AppButton>
            <!-- /Edit Button -->

            <!-- MenuButton -->
            <MenuButton
              class="w-full inline-flex items-center justify-center gap-1 rounded-r-md bg-teal-500 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            >
              <ChevronDown :open="open" />
            </MenuButton>
          </div>

          <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
          >
            <MenuItems
              class="w-56 flex flex-col px-1 py-1 mt-2 rounded-md absolute shadow-lg right-0 origin-top-right bg-white ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-secondary"
            >
              <div
                v-if="Object.keys(allowedProjectStatuses).length > 1"
                class="px-1 mb-2 text-sm text-slate-400 font-semibold"
              >
                {{ __('app.labels.change_status') }}
              </div>

              <!-- Statuses -->
              <MenuItem
                v-for="(data, status) in allowedProjectStatuses"
                :key="status"
                v-slot="{ active, close }"
              >
                <a
                  class="inline-flex items-center gap-2 px-1 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-200 dark:text-indigo-100 dark:hover:bg-slate-950"
                  :class="{ 'bg-indigo-200 dark:bg-slate-900': active }"
                  href="#"
                  plain
                  as="button"
                  method="post"
                  @error="handleStatusUpdateError"
                  @click.prevent="openStatusConfirmationDialog(data, status, close)"
                  >{{ data.label }}</a
                >
              </MenuItem>
              <!-- END Statuses -->

              <div class="border-t-2 border-indigo-200"></div>

              <!-- Send for Approval -->
              <MenuItem
                v-if="model.project_not_approved"
                v-slot="{ active }"
              >
                <Link
                  class="inline-flex items-center gap-2 px-1 py-2 rounded-none text-sm font-medium text-indigo-600 hover:bg-indigo-200 dark:text-indigo-100 dark:hover:bg-slate-950"
                  :class="{ 'bg-indigo-200 dark:bg-slate-900': active }"
                  :href="route('restore.projects.invitations.customer.store', model.project)"
                  plain
                  as="button"
                  method="post"
                >
                  <i class="bi bi-send"></i>
                  {{ __('tenant.project.customer_invite_button') }}
                </Link>
              </MenuItem>

              <template v-else>
                <!-- Moisture Map -->
                <MenuItem v-slot="{ active }">
                  <Link
                    class="inline-flex items-center gap-2 px-1 py-2 rounded-none text-sm font-medium text-indigo-600 hover:bg-indigo-200 dark:text-indigo-100 dark:hover:bg-slate-950"
                    :class="{ 'bg-indigo-200 dark:bg-slate-900': active }"
                    :href="moistureMapLink"
                    >{{ __('tenant.labels.moisture_map') }}</Link
                  >
                </MenuItem>

                <!-- Psychrometric Report -->
                <MenuItem v-slot="{ active }">
                  <Link
                    class="inline-flex items-center gap-2 px-1 py-2 rounded-none text-sm font-medium text-indigo-600 hover:bg-indigo-200 dark:text-indigo-100 dark:hover:bg-slate-950"
                    :class="{ 'bg-indigo-200 dark:bg-slate-900': active }"
                    :href="psychrometricReportLink"
                    >{{ __('tenant.labels.psychrometric_report') }}</Link
                  >
                </MenuItem>
              </template>

              <div
                v-if="model.project.affectedAreas.length > 0"
                class="border-t-2 border-indigo-200"
              ></div>

              <!-- Work Report -->
              <MenuItem
                v-if="model.project.affectedAreas.length > 0"
                v-slot="{ active }"
              >
                <Link
                  class="inline-flex items-center gap-2 px-1 py-2 rounded-none text-sm font-medium text-indigo-600 hover:bg-indigo-200 dark:text-indigo-100 dark:hover:bg-slate-900"
                  :class="{ 'bg-indigo-200 dark:bg-slate-900': active }"
                  target="_blank"
                  :href="route('restore.projects.reports.setup', model.project)"
                  >{{ __('tenant.labels.work_report') }}</Link
                >
              </MenuItem>
              <!-- END Work Report -->
            </MenuItems>
          </transition>
        </Menu>
        <!-- /Actions -->
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full pb-6 mt-2">
      <TabGroup>
        <!-- Tablist -->
        <TabList class="flex space-x-1">
          <Tab
            v-for="(tab, idx) in state.tabs"
            :key="idx"
            v-slot="{ selected }"
            as="template"
          >
            <button
              :class="[
                'w-full py-2.5 text-sm font-medium leading-5 text-blue-700 focus:outline-none dark:text-indigo-200',
                selected
                  ? 'bg-white border-t-2 border-blue-500 dark:bg-slate-800 dark:border-0'
                  : 'text-blue-100 hover:bg-white/[0.12] hover:text-slate-600 dark:hover:text-slate-200 dark:hover:bg-slate-800',
              ]"
            >
              {{ tab }}
            </button>
          </Tab>
        </TabList>
        <!-- END Tablist -->

        <!-- TabPanels -->
        <TabPanels class="px-2 mt-2 bg-white dark:bg-secondary">
          <!-- Claim Details TabPanel -->
          <ProjectClaimDetailsTabPanel :project="model.project" />
          <!-- END Claim Details TabPanel -->

          <!-- Owner Details TabPanel -->
          <ProjectOwnerDetailsTabPanel :project="model.project" />
          <!-- END Owner Details TabPanel -->

          <!-- Insurance TabPanel -->
          <ProjectInsuranceDetailsTabPanel :project="model.project" />
          <!-- END Insurance TabPanel -->

          <!-- Daily Logs TabPanel -->
          <ProjectLogsTabPanel :project="model.project" />
          <!-- END Daily Logs TabPanel -->
        </TabPanels>
        <!-- END TabPanels -->
      </TabGroup>
    </div>
    <!-- /Content Area -->

    <!-- Change Status Confirmation Modal -->
    <AppConfirmationDialogModal
      id="projectStatusUpdateModal"
      size="sm"
      confirm-theme="info"
      :confirm-label="__('app.labels.update')"
    />
    <!-- END Change Status Confirmation Modal -->

    <!-- Project Overview Modal -->
    <AppModal id="projectAssessmentModal">
      <template #header>
        <div>{{ __('tenant.labels.project_assessment') }}</div>
      </template>
      <div
        class="text-gray-700 dark:text-slate-200 prose prose-sm lg:prose"
        v-html="model.project.overview"
      />
    </AppModal>
    <!-- END Project Overview Modal -->
  </div>
</template>
