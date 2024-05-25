<script>
  export default {
    pageLayout: 'company_project',
  };
</script>

<script setup>
  import { inject, onMounted, reactive, watch, computed, ref } from 'vue';
  import { Head, useForm, usePage } from '@inertiajs/vue3';
  import WorkScheduleFields from './partials/WorkScheduleFields.vue';
  import ProjectAuthorizationFields from './partials/ProjectAuthorizationFields.vue';
  import AffectedAreasFields from './partials/AffectedAreasFields.vue';
  import InsuranceFields from './partials/InsuranceFields.vue';
  import FormBreadcrumb from './partials/FormBreadcrumb.vue';
  import Editor from '@/components/Editor.vue';
  import Address from '@/components/addresses/Address.vue';
  import AddressCreator from '@/components/addresses/AddressCreator.vue';
  import FormSectionDivider from '@/components/FormSectionDivider.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import { useFlatpickr } from '@/composables/flatpickr.js';
  import { useStepper } from '@vueuse/core';
  import DocumentPreviewModal from '@/components/documents/DocumentPreviewModal.vue';
  import { cloneDeep, get, isEmpty, isNull, keys, map, omit, pick } from 'lodash';

  const typeId = ref(null);
  const categoryId = ref(null);
  const classId = ref(null);
  const documentData = ref(null);

  const { steps, stepNames, index, current, next, previous, isFirst, isLast, goTo, goToNext, goToPrevious, isCurrent } =
    useStepper({
      'project-information': {
        title: 'Project information',
      },
      'loss-details': {
        title: 'Loss Details',
      },
      'affected-areas': {
        title: 'Affected Areas',
      },
      'work-schedule': {
        title: 'Work Schedule',
      },
      'project-authorization': {
        title: 'Project Authorization',
      },
      'project-location': {
        title: 'Project Location',
      },
      'customer-details': {
        title: 'Owner Details',
      },
      insurance: {
        title: 'Insurance Details',
      },
    });

  const props = defineProps(['model']);

  const form = useForm({
    name: props.model.project.name,
    type_id: props.model.project.type?.id,
    description: props.model.project.description,
    contacted_at: props.model.project.contacted_at,
    loss_occurred_at: props.model.project.loss_occurred_at,
    point_of_loss: props.model.project.point_of_loss,
    category_id: props.model.project.category?.id,
    class_id: props.model.project.class?.id,
    affected_areas: [],
    starts_at: props.model.project.starts_at,
    ends_at: props.model.project.ends_at,
    team_id: props.model.project.team?.id,
    overview: props.model.project.overview,
    documents: {},
    address: {
      id: props.model.project.address?.id,
      name: props.model.project.address?.name,
      address_1: props.model.project.address?.address_1,
      address_2: props.model.project.address?.address_2,
      state: props.model.project.address?.state,
      city: props.model.project.address?.city,
      postal_code: props.model.project.address?.postal_code,
      country_id:
        props.model.project.address?.country_id ||
        usePage().props.tenant?.addresses?.find((a) => a.default)?.country?.id ||
        '',
    },
    owner: {
      name: props.model.project.owner?.name,
      email: props.model.project.owner?.email,
      phone: props.model.project.owner?.phone,
      address: {
        id: props.model.project.owner?.address?.id,
        name: props.model.project.owner?.address?.name,
        address_1: props.model.project.owner?.address?.address_1,
        address_2: props.model.project.owner?.address?.address_2,
        state: props.model.project.owner?.address?.state,
        city: props.model.project.owner?.address?.city,
        postal_code: props.model.project.owner?.address?.postal_code,
        country_id:
          props.model.project.owner?.address?.country_id ||
          usePage().props.tenant?.addresses?.find((a) => a.default)?.country?.id ||
          '',
      },
    },
    insurance: {
      id: props.model.project.insurance?.id,
      claim_no: props.model.project.insurance?.claim_no,
      policy_no: props.model.project.insurance?.policy_no,
      deductible: props.model.project.insurance ? props.model.project.insurance.deductible / 100 : null,
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

  const state = reactive({
    use_property_address: false,
  });

  const projectName = computed(() => form.name || 'Untitled Project');

  // flatpickr setup
  const { startDatePicker, endDatePicker } = useFlatpickr({
    boot: false,
    startDate: {
      minDate: form.contacted_at,
      dateFormat: 'Y-m-d H:i',
      enableTime: true,
    },
    endDate: {
      minDate: form.ends_at,
      dateFormat: 'Y-m-d H:i',
      enableTime: true,
    },
  });

  const { singleDatePicker } = useFlatpickr({
    boot: false,
    pickers: 'date',
  });

  // work schedule fields input handler
  const workSchedule = computed({
    get() {
      return pick(form.data(), ['starts_at', 'ends_at', 'team_id']);
    },
    set(val) {
      form.starts_at = val.starts_at;
      form.ends_at = val.ends_at;
      form.team_id = val.team_id;
    },
  });

  // affected areas fields input handler
  const affectedAreas = computed({
    get() {
      return get(form.data(), ['affected_areas'], map(props.model.project.affectedAreas, 'name'));
    },
    set(val) {
      form.affected_areas = val;
    },
  });

  const setupFormInitialState = () => {
    state.use_property_address = isNull(props.model.project.owner?.address?.id);

    if (isNull(form.owner.address.id)) {
      form.owner.address = omit(cloneDeep(form.address));

      // set name from address if owner details empty
      if (!form.owner.email && !form.owner.phone) {
        form.owner.name = form.address.name;
      }
    }

    // set documents field
    var documentKeys = {};

    map(keys(props.model.allowed_project_documents), (key) =>
      Object.assign({}, { [key]: props.model.documents[key]?.id || '' }),
    ).forEach((o) => Object.assign(documentKeys, {}, o));

    form.documents = Object.assign({}, { ...documentKeys });

    // set affected areas field
    form.affected_areas = map(props.model.project.affectedAreas || [], 'name');
  };

  onMounted(() => {
    // setup form
    setupFormInitialState();

    // Access the step object through `current`
    watch(index, () => {
      scrollTo();
    });

    // setup date pickers
    singleDatePicker('.datepicker-contacted_at');
    const lossOccuredAtPicker = singleDatePicker('.datepicker-loss_occurred_at');
    const fpckrStartDate = startDatePicker();
    endDatePicker();

    // contact date watch
    watch(
      () => form.contacted_at,
      (val) => {
        lossOccuredAtPicker?.set('maxDate', val);

        fpckrStartDate?.set('minDate', val);
      },
    );

    // form address name
    watch(
      () => cloneDeep(form.address),
      (val) => {
        // set name from address if owner details empty
        if (!form.owner.email && !form.owner.phone) {
          form.owner.name = val.name;
        }

        // property + owner address sync
        if (state.use_property_address) {
          form.owner.address = val;
        }
      },
    );

    // form address name
    watch(
      () => state.use_property_address,
      (val) => {
        if (!val && props.model.project.owner?.address?.id) {
          form.owner.address = props.model.project.owner?.address;
        }

        // property + owner address sync
        if (val) {
          form.owner.address = omit(form.address, 'id');
        }
      },
    );

    // listen to 'show-document' event
    $eventBus.on('show-document', (document) => {
      documentData.value = document;
    });

    // emit 'setup-project-sidebar'
    $eventBus.emit('setup-project-sidebar', props.model.project);
  });

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body') => {
    $scrollTo(el, { container: 'body' });
  };

  const store = () => {
    form.clearErrors();
    scrollTo();

    if (!isLast) {
      goToNext();
      return;
    }

    form
      .transform((data) => {
        // Check if the insurance property exists and if deductible is present
        if (data.insurance && typeof data.insurance.deductible === 'number') {
          data.insurance.deductible = data.insurance.deductible * 100;
        }

        return data;
      })
      .patch(route('restore.projects.update', props.model.project), {
        onFinish: () => {
          // transform insurance `deductible` back to original by dividing by `100` regardless of response status
          if (form.insurance && typeof form.insurance.deductible === 'number') {
            form.insurance.deductible = form.insurance.deductible / 100;
          }
        },
      });
  };
</script>

<template>
  <Head title="Edit Project | Restore" />

  <div class="flex flex-col gap-4 pb-12 -mx-2 md:mx-0 relative">
    <!-- Heading Area -->
    <div class="w-full flex md:items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto dark:text-primary">
        <span class="font-semibold">{{ projectName }}</span>
      </h1>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-center gap-3">
        <div class="flex items-center gap-2">
          <p>
            <span class="px-2 py-1 mr-2 rounded-md text-sm bg-blue-200 text-blue-600">{{
              model.project.status.name
            }}</span>
          </p>

          <!-- Back Button -->
          <AppSuccessButton
            v-if="!isFirst"
            class="hidden md:flex"
            :disabled="form.processing"
            @click.prevent="goToPrevious"
          >
            <i class="bi bi-chevron-left"></i>
          </AppSuccessButton>

          <!-- Next Button -->
          <AppButton
            v-if="!isLast"
            class="hidden md:flex"
            :disabled="form.processing"
            @click.prevent="goToNext"
          >
            <i class="bi bi-chevron-right"></i>
          </AppButton>

          <!-- Actions -->
          <!-- Save Button -->
          <div class="flex items-center justify-end lg:justify-start">
            <AppButton
              type="submit"
              theme="info"
              class="inline-flex items-center gap-2"
              :disabled="form.processing"
              @click.prevent="store"
            >
              <AppSpinner
                v-if="form.processing"
                :size="4"
              />
              <i
                v-show="!form.processing"
                class="bi bi-check"
              ></i>
              {{ __('app.labels.save') }}
            </AppButton>
          </div>
          <!-- END Save Button -->
          <!-- /Actions -->
        </div>
      </div>
    </div>
    <!-- /Heading Area -->

    <div class="w-full flex items-center md:justify-end">
      <FormBreadcrumb
        :data="{
          current,
          index,
          steps,
          stepNames,
          goTo,
          isCurrent,
        }"
      />
    </div>

    <!-- Content Area -->
    <div class="container min-w-full px-0 md:px-8 mx-auto">
      <!-- Form -->
      <form
        class="min-w-full max-w-xs sm:max-w-sm md:max-w-full space-y-8"
        action="#"
        @submit.prevent="store"
      >
        <AppValidationErrors :errors="form.errors" />

        <!--  Project Information -->
        <div
          class="min-w-full max-w-xs sm:max-w-sm md:max-w-full -mx-4 px-4 sm:mx-auto sm:px-auto"
          v-show="isCurrent('project-information')"
        >
          <FormSectionDivider :value="steps['project-information']?.title" />

          <!-- Name -->
          <div class="mt-4">
            <AppInputLabel for="name">Name</AppInputLabel>

            <AppInput
              id="name"
              v-model="form.name"
              class="w-full mt-2"
              name="name"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.name"
            />
          </div>

          <!-- Type -->
          <div class="mt-4">
            <AppInputLabel
              for="type_id"
              class="block mb-2"
              >Type</AppInputLabel
            >

            <select
              id="type_id"
              ref="typeId"
              v-model="form.type_id"
              v-choicesjs
              class="w-full mt-2"
              name="type_id"
            >
              <option value>Choose type</option>
              <option
                v-for="type in model.types"
                :key="type.id"
                :value="type.id"
              >
                {{ type.name }}
              </option>
            </select>

            <AppInputError
              class="mt-2"
              :message="form.errors.type_id"
            />
          </div>

          <!-- Description -->
          <div class="mt-4">
            <AppInputLabel for="description">Description</AppInputLabel>

            <AppInput
              id="description"
              v-model="form.description"
              class="w-full mt-2"
              name="description"
              maxlength="100"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.description"
            />
          </div>

          <!-- Overview -->
          <div>
            <!-- divider -->
            <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
              <div class="w-12">
                <div class="w-full h-0 border-t-2 border-blue-600">&nbsp;</div>
              </div>
              <p class="text-lg font-semibold">Details</p>
            </div>

            <div class="pt-4">
              <AppInputLabel>Full overview</AppInputLabel>

              <div class="px-1 py-1 mt-3 border border-dotted border-slate-500 rounded dark:bg-slate-100">
                <Editor
                  v-model="form.overview"
                  menu="fixed"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Loss Details -->
        <div v-show="isCurrent('loss-details')">
          <FormSectionDivider value="Loss Details" />

          <!-- Date Range Picker -->
          <div class="grid grid-cols-2 gap-6 mb-4">
            <div class="col-md-3">
              <div class="form-group">
                <AppInputLabel for="contacted_at_date">Date Contacted</AppInputLabel>

                <AppInput
                  id="contacted_at_date"
                  v-model="form.contacted_at"
                  type="text"
                  class="mt-2 datepicker-contacted_at"
                />

                <AppInputError
                  class="mt-2"
                  :message="form.errors.contacted_at"
                />
              </div>
            </div>
            <!-- /date contacted -->

            <div class="col-md-3">
              <div class="form-group">
                <AppInputLabel for="loss_occurred_at_date">Date Loss Occurred</AppInputLabel>

                <AppInput
                  id="loss_occurred_at_date"
                  v-model="form.loss_occurred_at"
                  type="text"
                  class="mt-2 datepicker-loss_occurred_at"
                />

                <AppInputError
                  class="mt-2"
                  :message="form.errors.loss_occurred_at"
                />
              </div>
            </div>
            <!-- /date of loss -->
          </div>
          <!-- /Date Range Picker -->

          <!-- Point of Loss (link to affected areas) -->
          <div class="mt-4">
            <AppInputLabel for="point_of_loss">Point of Loss</AppInputLabel>

            <AppInput
              id="point_of_loss"
              v-model="form.point_of_loss"
              class="w-full mt-2"
              name="point_of_loss"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.point_of_loss"
            />
          </div>

          <!-- Category -->
          <div class="mt-4">
            <AppInputLabel
              for="category_id"
              class="block mb-2"
              >Category</AppInputLabel
            >

            <select
              id="category_id"
              ref="categoryId"
              v-model="form.category_id"
              v-choicesjs
              class="w-full mt-2"
              name="category_id"
            >
              <option value>Choose category</option>
              <option
                v-for="category in model.categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>

            <AppInputError
              class="mt-2"
              :message="form.errors.category_id"
            />
          </div>

          <!-- Class -->
          <div class="mt-4">
            <AppInputLabel
              for="class_id"
              class="block mb-2"
              >Class</AppInputLabel
            >

            <select
              id="class_id"
              ref="classId"
              v-model="form.class_id"
              v-choicesjs
              class="w-full mt-2"
              name="class_id"
            >
              <option value>Choose class</option>
              <option
                v-for="item in model.classes"
                :key="item.id"
                :value="item.id"
              >
                {{ item.name }}
              </option>
            </select>

            <AppInputError
              class="mt-2"
              :message="form.errors.class_id"
            />
          </div>
        </div>

        <!-- Affected Areas -->
        <div class="mt-1">
          <AffectedAreasFields
            v-if="isCurrent('affected-areas')"
            v-model="affectedAreas"
            :data="model"
            :errors="form.errors"
          />
        </div>
        <!-- /Affected Areas -->

        <!-- Work Schedule -->
        <WorkScheduleFields
          v-show="isCurrent('work-schedule')"
          v-model="workSchedule"
          :data="model"
          :errors="form.errors"
        />
        <!-- /Work Schedule -->

        <!-- Project Authorization -->
        <div v-if="isCurrent('project-authorization')">
          <FormSectionDivider
            value="Project Authorization"
            class="mb-3"
          />

          <div
            v-for="(documents, groupKey) in model.allowed_documents"
            :key="groupKey"
            class="flex flex-col gap-8 mt-4 first:mt-0"
          >
            <ProjectAuthorizationFields
              v-model="form.documents[groupKey]"
              :data="documents"
              :label="model.allowed_project_documents[groupKey]"
              :errors="form.errors"
            />
          </div>
        </div>
        <!-- /Project Authorization -->

        <!-- Property Address and Contact -->
        <div v-if="isCurrent('project-location')">
          <FormSectionDivider value="Project Location & Contact" />

          <AddressCreator
            v-model="form.address"
            inline
            :countries="model.countries"
            :without="['default', 'billing']"
          />
        </div>
        <!-- /Property Address and Contact -->

        <!-- Owner Details -->
        <div v-if="isCurrent('customer-details')">
          <FormSectionDivider value="Owner Details" />

          <!-- Full name -->
          <div>
            <AppInputLabel for="owner_name">Full name</AppInputLabel>

            <AppInput
              id="owner_name"
              v-model="form.owner.name"
              type="text"
              class="w-full mt-2"
              name="owner_name"
            />

            <AppInputError
              :message="form.errors.owner?.name"
              class="mt-2"
            />
          </div>

          <!-- Email -->
          <div class="mt-4">
            <AppInputLabel for="owner_email">Email</AppInputLabel>

            <AppInput
              id="owner_email"
              v-model="form.owner.email"
              type="email"
              class="w-full mt-2"
              name="owner_email"
            />

            <AppInputError
              :message="form.errors.owner?.email"
              class="mt-2"
            />
          </div>

          <!-- Phone -->
          <div class="mt-4">
            <AppInputLabel for="owner_phone">{{ __('app.labels.phone') }}</AppInputLabel>

            <AppInput
              id="owner_phone"
              v-model="form.owner.phone"
              type="text"
              class="w-full mt-2"
              name="owner_phone"
            />

            <AppInputError
              :message="form.errors.owner?.phone"
              class="mt-2"
            />
          </div>

          <div class="w-full flex items-center gap-2 mt-8">
            <AppCheckbox
              id="use_property_address"
              v-model="state.use_property_address"
              name="use_property_address"
              value="1"
            />

            <AppInputLabel for="use_property_address">Use Property Address</AppInputLabel>
          </div>

          <!-- Owner Address -->
          <div
            v-if="!state.use_property_address"
            class="mt-8 space-y-3"
          >
            <h4 class="text-base font-medium text-slate-600">Owner Address</h4>

            <AddressCreator
              v-model="form.owner.address"
              inline
              :countries="model.countries"
              :without="['default', 'billing']"
            />
          </div>

          <!-- todo: move this to separate component -->
          <!-- Empty -->
          <div
            v-else-if="!form.address.name"
            class="p-4 mt-8 bg-yellow-200 dark:bg-indigo-600 dark:text-primary font-medium"
          >
            Property address not set. Please add the property location.
          </div>

          <!-- Address -->
          <Address
            v-else
            class="mt-4"
            :address="form.address"
          />
        </div>
        <!-- /Owner Details -->

        <!-- Insurance Details -->
        <InsuranceFields
          v-if="isCurrent('insurance')"
          v-model="form.insurance"
          :errors="form.errors?.insurance"
          :data="model"
        />
        <!-- /Insurance Details -->

        <div class="mt-auto">
          <div class="flex items-baseline justify-end flex-wrap gap-3">
            <!-- Review Button -->
            <AppLightButton :href="route('restore.projects.show', model.project)">
              <i class="bi bi-eye"></i>
              Review
            </AppLightButton>

            <!-- Save Button -->
            <AppButton
              type="submit"
              theme="info"
              class="flex items-center gap-2"
              :disabled="form.processing"
            >
              <AppSpinner
                v-show="form.processing"
                :size="4"
              />
              <i
                v-show="!form.processing"
                class="bi bi-check"
              ></i>
              Save
            </AppButton>

            <!-- Back Button -->
            <AppSuccessButton
              v-if="!isFirst"
              type="button"
              class="flex items-center gap-2"
              :disabled="form.processing"
              @click.prevent="goToPrevious"
            >
              <i class="bi bi-chevron-left"></i> Back
            </AppSuccessButton>

            <!-- Next Button -->
            <AppButton
              v-if="!isLast"
              type="button"
              class="flex items-center gap-2"
              :disabled="form.processing"
              @click.prevent="goToNext"
            >
              Next
              <i class="bi bi-chevron-right"></i>
            </AppButton>
          </div>
        </div>
      </form>
      <!--/ Form -->

      <!-- DocumentPreviewModal -->
      <DocumentPreviewModal :replacements="model.replacements" />
      <!-- /DocumentPreviewModal -->
    </div>
    <!-- /Content Area -->
  </div>
</template>

<style>
  .choices__list--dropdown,
  .choices__list[aria-expanded] {
    z-index: 9999 !important;
  }
</style>
