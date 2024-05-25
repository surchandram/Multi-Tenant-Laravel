<script>
  export default {
    pageLayout: 'company_project',
  };
</script>

<script setup>
  import { inject, onMounted, reactive, computed, ref } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import { useStepper } from '@vueuse/core';
  import { useMomentJS } from '@/composables/momentjs.js';
  import MoistureMapAffectedAreaSetupForm from './partials/MoistureMapAffectedAreaSetupForm.vue';
  import MoistureMapStructureSetupRow from './partials/MoistureMapStructureSetupRow.vue';
  import MoistureMapStructure from './partials/MoistureMapStructure.vue';
  import MoistureMapMaterialReadingsEditor from './partials/MoistureMapMaterialReadingsEditor.vue';
  import DropdownMenu from '@/components/DropdownMenu.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import FormSectionDivider from '@/components/FormSectionDivider.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppModal from '@/components/AppModal.vue';
  import AppQrCodeScanner from '@/components/AppQrCodeScanner.vue';
  import { Card, CardContent, CardDescription, CardHeader } from '@/components/ui/card';
  import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
  import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
  import LucideIcon from '@/components/LucideIcon.vue';

  const props = defineProps(['model']);

  const { getDatesBetween } = useMomentJS();

  const state = reactive({
    editableStructureData: null,
    deviceStructureData: null,
    readingsDates: [],
    qrDecodedText: null,
    qrDecodedResult: null,
  });

  const form = useForm({
    moisture_map: props.model.project.moisture_map,
  });

  const structureReadingsForm = useForm({
    readings: {},
  });

  const deviceLinkupForm = useForm({
    name: '',
  });

  // setup tabs
  let tabs = _.cloneDeep(props.model.project.affectedAreas);
  tabs.unshift(...[{ name: 'Summary', id: 'summary' }]);

  const { steps, goTo, isCurrent, current } = useStepper(_.keyBy(tabs, 'name'));

  const tabsRef = ref(tabs[0]?.id);

  const projectName = computed(() => props.model.project.name || 'Untitled Project');

  const hasNoAffectedAreas = computed(() => props.model.project.affectedAreas < 1);

  const hasNoDefinedStructures = computed(() => form.moisture_map.length < 1);

  const editableStructureAffectedArea = computed(() =>
    _.find(props.model.project.affectedAreas, ['id', state.editableStructureData?.affected_area_id]),
  );

  const deviceStructureAffectedArea = computed(() =>
    _.find(props.model.project.affectedAreas, ['id', state.deviceStructureData?.affected_area_id]),
  );

  const areaIsFirst = (key) => selectedAccordion.value == key;

  const selectedAccordion = ref(_.head(_.keys(props.model.project.moisture_summary)));

  const selectAccordion = (key) => {
    selectedAccordion.value = key;
    scrollTo(`#collapse${cleanUpKey(key)}`, { offset: -100 });
  };

  const cleanUpKey = (key) => window.slugify(key);

  const reviewButtonLink = computed(() => (form.processing ? '' : route('restore.projects.show', props.model.project)));

  const editButtonLink = computed(() => (form.processing ? '' : route('restore.projects.edit', props.model.project)));

  const buttonsDisabled = computed(() => hasNoDefinedStructures.value || form.processing);

  const dateFormat = (value, format = 'MM/DD/YYYY') => moment(value).format(format);

  const setupFormInitialState = () => {
    // setup affected areas form fields
    props.model.project.affectedAreas.forEach(function (affectedArea) {
      state[affectedArea.id] = _.cloneDeep(affectedAreaDefaultState());
    });

    // setup readings dates
    state.readingsDates = getDatesBetween(
      props.model.project.starts_at,
      moment.min(props.model.project.ends_at, moment()),
      'MM/DD/YYYY',
    );

    state.readingsDates.forEach((readingDate) => {
      structureReadingsForm.readings = Object.assign({}, structureReadingsForm.readings, { [readingDate]: null });
    });
  };

  const affectedAreaDefaultState = () => {
    return {
      structure: '',
      material: '',
    };
  };

  const appendToMoistureMap = function (data) {
    form.moisture_map.push(data);
  };

  const removeFromMoistureMap = function (data) {
    const index = _.findIndex(form.moisture_map, data);

    return _.pullAt(form.moisture_map, index);
  };

  const getAreaMap = function (affectedArea) {
    return _.filter(form.moisture_map, ['affected_area_id', affectedArea.id]);
  };

  const hasNoMapSetup = function (affectedArea) {
    return _.size(getAreaMap(affectedArea)) < 1;
  };

  const qrScannerModal = ref(null);

  onMounted(() => {
    // setup form initial state
    setupFormInitialState();

    // setup modal element
    setTimeout(() => {
      const el = document.querySelector('#structureReadingsInputModal');

      const deviceEl = document.querySelector('#structureDeviceSetupModal');
    }, 500);

    // listen to 'closed-modal'
    $eventBus.on('closed-modal', (modalId) => {
      setTimeout(() => {
        if (modalId == 'structureDeviceSetupModal') {
          state.editableStructureData = null;
        }

        if (modalId == 'structureReadingsInputModal') {
          state.editableStructureData = null;
        }
      }, 500);
    });

    // listen to 'moisture-map::fill-readings-form'
    $eventBus.on('moisture-map::fill-readings-form', (structureData) => {
      state.editableStructureData = structureData;
    });

    // listen to 'qrcode-scanner::result'
    $eventBus.on('qrcode-scanner::result', (scannerData) => {
      state.qrDecodedText = scannerData.decodedText;
      state.qrDecodedResult = scannerData.decodedResult;

      deviceLinkupForm.name = scannerData.decodedText;

      showQrScanner.value = false;
    });

    // listen to 'moisture-map::scan-device'
    $eventBus.on('moisture-map::scan-device', (structureData) => {
      state.deviceStructureData = structureData;

      showQrScanner.value = true;

      // show modal
      $eventBus.emit('open-modal', 'structureDeviceSetupModal');
    });

    // listen to 'moisture-map::removed-reading'
    $eventBus.on('moisture-map::removed-reading', (payload) => {
      // do something: scroll to affected area or flash a message
      // const { material } = payload;
    });

    // emit 'setup-project-sidebar'
    $eventBus.emit('setup-project-sidebar', props.model.project);
  });

  const showQrScanner = ref(false);

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body', options = {}) => {
    $scrollTo(el, Object.assign({}, { container: 'body' }, options));
  };

  const linkDevice = () => {
    deviceLinkupForm.processing = true;

    // send request to get device info here
    deviceLinkupForm.post(
      route('restore.projects.moisture-map.devices.store', [props.model.project, state.deviceStructureData.id]),
      {
        onSuccess: () => {
          state.qrDecodedText = null;
          state.qrDecodedResult = null;

          // hide modal
          qrScannerModal.value.hide();
        },
      },
    );
  };

  const store = () => {
    scrollTo();
    form.clearErrors();

    form.post(route('restore.projects.moisture-map.store', props.model.project), {
      onSuccess: () => {
        form.defaults('moisture_map', props.model.project.moisture_map);
        form.reset();
      },
    });
  };
</script>

<template>
  <Head :title="`Moisture Map | ${projectName} | Restore`" />

  <div class="flex flex-col gap-4 md:gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-3">
      <!-- Heading -->
      <div class="flex flex-col gap-3 mr-auto">
        <h1 class="text-primary text-xl font-medium">{{ projectName }} - {{ __('tenant.labels.moisture_map') }}</h1>

        <p class="text-sm font-medium text-slate-600 dark:text-secondary-foreground">
          {{ __('tenant.labels.project_timeline') }}:
          <span class="text-slate-600 dark:text-indigo-400">
            {{ dateFormat(model.project.starts_at) }} - {{ dateFormat(model.project.ends_at) }}
          </span>
        </p>
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <!-- View Link -->
        <AppButton
          :href="reviewButtonLink"
          :disabled="buttonsDisabled"
          theme="outline"
          class="inline-flex items-center gap-2"
        >
          <LucideIcon
            name="eye"
            class="size-5"
          />
          {{ __('app.labels.view') }}
        </AppButton>

        <!-- Edit Link -->
        <AppButton
          :href="editButtonLink"
          :disabled="buttonsDisabled"
          theme="info"
          class="inline-flex items-center gap-2"
        >
          <LucideIcon
            name="pencil"
            class="size-5"
          />
          {{ __('app.labels.edit') }}
        </AppButton>

        <!-- Save Button -->
        <AppButton
          class="flex items-center gap-2"
          :disabled="buttonsDisabled"
          theme="success"
          @click="store"
        >
          <AppSpinner
            v-if="form.processing"
            :size="8"
          />
          <LucideIcon
            v-else
            name="check"
            class="size-5"
          />
          {{ __('app.labels.save') }}
        </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-1 md:px-2 pt-2 pb-6 md:py-6">
      <!-- Validation Errors -->
      <AppValidationErrors
        :errors="form.errors"
        :class="{ 'mb-5': form.errors }"
      />

      <!-- Tabs -->
      <Tabs
        default-value="summary"
        v-model="tabsRef"
        class="w-full flex flex-col space-y-4"
      >
        <!-- Tab Navigation -->

        <!-- Tab Buttons for Medium to Large Screens -->
        <TabsList class="hidden sm:flex justify-start w-full !h-auto !bg-transparent">
          <TabsTrigger
            v-for="affectedArea in steps"
            :id="`affectedAreaTab{affectedArea.id}`"
            :key="affectedArea.id"
            :value="affectedArea.id.toString()"
          >
            <span
              href="#"
              class="block px-2 py-3 text-sm"
              :class="{
                'border-blue-500': tabsRef === affectedArea.name,
                'text-blue-500 font-semibold': tabsRef === affectedArea.name,
              }"
              @click.prevent="goTo(affectedArea.name)"
            >
              {{ affectedArea.name }}
            </span>
          </TabsTrigger>
        </TabsList>
        <!-- END Tab Buttons for Medium to Large Screens -->

        <!-- Dropdown for Small Screens -->
        <div class="w-full sm:hidden rounded-sm bg-slate-200 dark:bg-slate-800">
          <DropdownMenu
            v-slot="{ hideDropdown }"
            content-wrapper="div"
            class="w-full"
            :label="tabs.find((f) => f.id == tabsRef)?.name || 'Switch to'"
          >
            <div class="w-48 px-px flex flex-col space-y-1">
              <a
                v-for="affectedArea in steps"
                :key="`dropdownTab-${affectedArea.id}`"
                href="#"
                class="block px-2 py-3 text-sm"
                :class="{
                  'bg-blue-500 text-white dark:bg-slate-900': tabsRef == affectedArea.id,
                  'text-blue-500 font-semibold dark:text-blue-200 dark:active:bg-slate-900': tabsRef != affectedArea.id,
                }"
                @click.prevent="
                  () => {
                    tabsRef = affectedArea.id.toString();
                    hideDropdown();
                  }
                "
              >
                {{ affectedArea.name }}
              </a>
            </div>
          </DropdownMenu>
        </div>
        <!-- END Dropdown for Small Screens -->

        <!-- END Tab Navigation -->

        <!-- Tab Content -->
        <!-- Summary -->
        <TabsContent
          id="moistureMapSummaryAccordion"
          class="accordion w-full flex flex-col gap-8 gap-y-6 py-2"
          value="summary"
        >
          <Card>
            <CardHeader>
              <template v-if="hasNoDefinedStructures">
                <CardDescription class="font-medium">
                  {{ __('tenant.project.moisture_map.no_data_found') }}
                </CardDescription>

                <CardDescription v-if="hasNoAffectedAreas">
                  {{ __('tenant.project.moisture_map.setup_affected_areas') }}
                  <AppButton
                    theme="outline"
                    :href="route('restore.projects.edit', model.project)"
                    class="inline-flex items-center gap-2"
                  >
                    <span class="text-lg leading-none"><i class="bi bi-pencil"></i></span>
                    {{ 'tenant.labels.edit_project' }}
                  </AppButton>
                </CardDescription>

                <CardDescription v-else>{{ 'tenant.project.moisture_map.setup_structures' }}</CardDescription>
              </template>

              <CardDescription
                v-else
                class="font-medium"
              >
                {{ __('tenant.project.moisture_map.readings_summary') }}
              </CardDescription>
            </CardHeader>

            <CardContent>
              <Accordion
                type="single"
                class="w-full"
                collapsible
              >
                <!-- Affected Areas -->
                <AccordionItem
                  v-for="(area, key) in model.project.moisture_summary"
                  v-slot="{ open }"
                  :key="cleanUpKey(key)"
                  :value="cleanUpKey(key)"
                  class="space-y-4 last:border-b-0"
                >
                  <AccordionTrigger
                    class="!no-underline hover:text-indigo-400 focus:text-indigo-400"
                    :class="open ? 'font-semibold text-indigo-400' : 'font-medium'"
                  >
                    <span>{{ key }}</span>
                  </AccordionTrigger>

                  <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-out"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                  >
                    <AccordionContent class="pt-4 pb-2 text-sm">
                      <MoistureMapStructure
                        v-for="(materials, structure) in area"
                        :key="structure"
                        :structure="structure"
                        :materials="materials"
                      />
                    </AccordionContent>
                  </transition>
                </AccordionItem>
                <!-- /Affected Areas -->
              </Accordion>
            </CardContent>
          </Card>
        </TabsContent>
        <!-- /Summary -->

        <!-- Affected Areas Tabs -->
        <TabsContent
          v-for="affectedArea in model.project.affectedAreas"
          :id="`affectedAreaTabContent{affectedArea.id}`"
          :key="affectedArea.id"
          :value="affectedArea.id.toString()"
        >
          <!-- Tab -->
          <div class="px-2 py-2">
            <!-- Structure Form -->
            <div class="py-2 space-y-4">
              <MoistureMapAffectedAreaSetupForm
                v-if="state[affectedArea.id]"
                :key="`moisture_map_structure_form_${affectedArea.id}`"
                :affected-area="affectedArea"
                :data="model"
                @input="appendToMoistureMap"
              >
                <template #default="{ startOpened, showForm, toggleForm }">
                  <div
                    v-if="!showForm"
                    class="inline-flex items-center flex-wrap gap-2 mb-3"
                  >
                    <AppButton
                      type="button"
                      @click="toggleForm"
                    >
                      {{ __('tenant.project.moisture_map.add_new_structure') }}
                    </AppButton>
                    {{
                      __('tenant.project.moisture_map.structure_monitor_prompt', { affectedArea: affectedArea.name })
                    }}
                  </div>

                  <div
                    v-else
                    class="flex items-center justify-between gap-6 mb-4"
                  >
                    <AppInputLabel
                      :value="
                        __('tenant.project.moisture_map.add_structure_for_area', { affectedArea: affectedArea.name })
                      "
                    />

                    <aside>
                      <AppLightButton
                        v-if="!startOpened"
                        @click="toggleForm"
                      >
                        {{ __('app.labels.cancel') }}
                      </AppLightButton>
                    </aside>
                  </div>
                </template>
              </MoistureMapAffectedAreaSetupForm>
            </div>
            <!-- /Structure Form -->

            <FormSectionDivider :value="`${affectedArea.name} Sensors Map`" />

            <!-- Map Affected Areas -->
            <div class="w-full py-2 mt-3 space-y-6">
              <!-- Structure Setup Row -->
              <MoistureMapStructureSetupRow
                v-for="(map, index) in getAreaMap(affectedArea)"
                :key="index"
                :data="map"
                :affected-area="affectedArea"
                :project="model.project"
                @remove="removeFromMoistureMap(map)"
              />
              <!-- /Structure Setup Row -->

              <p
                v-if="hasNoMapSetup(affectedArea)"
                class="text-sm text-slate-400 font-semibold"
              >
                {{ __('tenant.project.moisture_map.no_map_found', { affectedArea: affectedArea.name }) }}
              </p>
            </div>
            <!-- /Map Affected Areas -->
          </div>
          <!-- /Tab -->
        </TabsContent>
        <!-- /Tab Content -->
      </Tabs>
      <!-- /Tabs -->

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
            :size="8"
          />
          <span
            v-else
            class="text-sm lg:text-2xl"
          >
            <i class="bi bi-check"></i>
          </span>
          Save
        </AppButton>

        <!-- Review -->
        <AppSuccessButton
          :href="reviewButtonLink"
          :disabled="buttonsDisabled"
          class="inline-flex items-center gap-2"
        >
          <span class="text-sm lg:text-2xl"><i class="bi bi-eye"></i></span> Review
        </AppSuccessButton>
      </div>
      <!--/ Buttons -->
    </div>
    <!-- /Content Area -->

    <!-- Material Readings Editor Modal -->
    <MoistureMapMaterialReadingsEditor
      :affected-area="editableStructureAffectedArea"
      :editable="state.editableStructureData"
      :model="model"
    />
    <!-- /Material Readings Editor Modal -->

    <!-- Device Setup Form -->
    <form
      action="#"
      @submit.prevent="linkDevice"
    >
      <AppModal
        id="structureDeviceSetupModal"
        ref="qrScannerModal"
        close-label="Cancel"
        submit
        submit-label="Link Device"
        :submit-callback="linkDevice"
        :disabled="deviceLinkupForm.processing"
      >
        <!-- Modal Header -->
        <template
          v-if="deviceStructureAffectedArea"
          #header
        >
          <h4 class="text-sm font-semibold mb-3">Setup monitoring device for:</h4>

          <div class="flex flex-row items-center flex-wrap gap-3 sm:gap-x-1 text-sm leading-none">
            <div class="space-x-1 font-medium">
              <span class="sm:hidden">Affected Area:</span>

              <span class="text-slate-600 font-semibold">
                {{ deviceStructureAffectedArea.name }}
              </span>

              <i class="bi bi-arrow-right hidden sm:inline"></i>
            </div>

            <div class="space-x-1 font-medium">
              <span class="sm:hidden">Structure:</span>

              <span class="text-slate-600 font-semibold">
                {{ state.deviceStructureData.structure }}
              </span>

              <i class="bi bi-arrow-right hidden sm:inline"></i>
            </div>

            <div class="space-x-1 font-medium">
              <span class="sm:hidden">Material:</span>

              <span class="text-slate-600 font-semibold">
                {{ state.deviceStructureData.material }}
              </span>

              <span></span>
            </div>
          </div>
        </template>

        <!-- QR Code Scanner -->
        <AppQrCodeScanner v-if="showQrScanner" />

        <!-- QR Code Result -->
        <div
          v-if="state.qrDecodedText"
          class="flex flex-col gap-4"
        >
          <!-- Callback Url -->
          <div x-data="">
            <AppInputLabel value="Device name" />

            <AppInputGroup class="mt-2">
              <template #default="{ inputStyles }">
                <AppInput
                  v-model="state.qrDecodedText"
                  :class="inputStyles"
                  class="w-full read-only:text-slate-700 read-only:bg-slate-200"
                  readonly
                  x-ref="qrDecodedTextInput"
                  x-on:click="window.navigator?.clipboard?.writeText($refs.qrDecodedTextInput.value)"
                />
              </template>

              <template #end>
                <AppButton
                  x-on:click="window.navigator?.clipboard?.writeText($refs.qrDecodedTextInput.value)"
                  class="flex-wrap text-sm"
                >
                  <i class="bi bi-clipboard"></i>
                </AppButton>
              </template>
            </AppInputGroup>
          </div>
        </div>

        <!-- Close Button -->
        <template #closeButton="{ modalDisabled }">
          <AppLightButton
            class="inline-flex items-center gap-2 ml-3"
            @click="qrScannerModal.close()"
            :disabled="modalDisabled"
          >
            <i class="bi bi-x-circle"></i>
            {{ __('app.labels.cancel') }}
          </AppLightButton>
        </template>

        <!-- Submit Button -->
        <template #submitButton="{ modalDisabled }">
          <AppButton
            type="submit"
            class="inline-flex items-center gap-2 ml-3"
            :disabled="modalDisabled"
            @click.prevent="linkDevice"
          >
            {{ __('tenant.labels.link_device') }} <i class="bi bi-plug"></i>
          </AppButton>
        </template>
      </AppModal>
    </form>
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
