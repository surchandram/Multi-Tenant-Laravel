<script>
  export default {
    pageLayout: 'company',
  };
</script>

<script setup>
  import { inject, onMounted, reactive, watch, computed } from 'vue';
  import { Head, useForm, usePage } from '@inertiajs/vue3';
  import WorkScheduleFields from './partials/WorkScheduleFields.vue';
  import ProjectAuthorizationFields from './partials/ProjectAuthorizationFields.vue';
  import AffectedAreasFields from './partials/AffectedAreasFields.vue';
  import InsuranceFields from './partials/InsuranceFields.vue';
  import FormBreadcrumb from './partials/FormBreadcrumb.vue';
  import DocumentPreviewModal from '@/components/documents/DocumentPreviewModal.vue';
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
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { useFlatpickr } from '@/composables/flatpickr.js';
  import { useStepper } from '@vueuse/core';
  import { get, map, pick } from 'lodash';

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

  const state = reactive({
    use_property_address: true,
  });

  const form = useForm({
    name: '',
    type_id: '',
    description: '',
    contacted_at: '',
    loss_occurred_at: '',
    point_of_loss: '',
    category_id: '',
    class_id: '',
    affected_areas: [],
    starts_at: '',
    ends_at: '',
    team_id: '',
    overview: '',
    documents: {},
    address: {
      name: '',
      address_1: '',
      address_2: '',
      state: '',
      city: '',
      postal_code: '',
      country_id: usePage().props.tenant?.addresses?.find((a) => a.default)?.country?.id || '',
    },
    owner: {
      name: '',
      email: '',
      phone: '',
      address: {
        default: true,
        billing: true,
        country_id: '',
      },
    },
    insurance: {
      id: '',
      claim_no: '',
      policy_no: '',
      deductible: '',
      company: {
        id: '',
        name: '',
        email: '',
        phone: '',
      },
      agent: {
        id: '',
        name: '',
        email: '',
        phone: '',
      },
      adjuster: {
        id: '',
        name: '',
        email: '',
        phone: '',
      },
    },
  });

  const projectName = computed(() => form.name || 'Untitled Project');

  // flatpickr setup
  const { startDatePicker, endDatePicker } = useFlatpickr({
    boot: false,
    startDate: {
      minDate: form.contacted_at,
    },
    endDate: {
      minDate: form.ends_at,
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
      return get(form.data(), ['affected_areas'], []);
    },
    set(val) {
      form.affected_areas = val;
    },
  });

  onMounted(() => {
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
      () => _.cloneDeep(form.address),
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
      .post(route('restore.projects.store'), {
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
  <Head title="New Project | Restore" />

  <div class="flex flex-col gap-10 relative">
    <!-- Heading area -->
    <div class="w-full flex flex-col md:flex-row gap-4 md:gap-0 items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto dark:text-primary">
        <span class="font-semibold">{{ projectName }}</span>
      </h1>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-end gap-5 md:gap-3">
        <!-- Breadcrumb -->
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
        <!-- END BreadCrumb -->

        <div class="flex items-center justify-end gap-3">
          <!-- Previous Step -->
          <AppSuccessButton
            v-if="!isFirst"
            :disabled="form.processing"
            @click.prevent="goToPrevious"
          >
            <LucideIcon
              name="chevron-left"
              class="size-5"
            />
          </AppSuccessButton>
          <!-- END Previous Step -->

          <!-- Next Step -->
          <AppButton
            v-if="!isLast"
            theme="info"
            :disabled="form.processing"
            @click.prevent="goToNext"
          >
            <LucideIcon
              name="chevron-right"
              class="size-5"
            />
          </AppButton>
          <!-- END Next Step -->

          <!-- Save Button -->
          <AppButton
            type="submit"
            class="flex items-center gap-2"
            :disabled="form.processing"
            @click.prevent="store"
          >
            <AppSpinner
              v-show="form.processing"
              :size="4"
            />
            <i
              v-show="!form.processing"
              class="bi bi-check"
            ></i>
            {{ isFirst ? 'Create' : 'Save' }}
          </AppButton>
          <!-- END Save Button -->
        </div>
      </div>
    </div>
    <!-- /Heading area -->

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <div>
        <form
          action="#"
          @submit.prevent="store"
        >
          <AppValidationErrors :errors="form.errors" />

          <!--  Project Information -->
          <div v-show="isCurrent('project-information')">
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

              <div class="z-[100]">
                <select
                  id="type_id"
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
              </div>

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
              inline
              :countries="model.countries"
              :without="['default', 'billing']"
              v-model="form.address"
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
              <AppInputLabel for="owner_phone">Phone</AppInputLabel>

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
              />
            </div>

            <!-- Address -->
            <Address
              v-else-if="state.use_property_address && form.owner.address?.name"
              class="mt-4"
              :address="form.owner.address"
            />

            <!-- todo: move this to separate component -->
            <!-- Empty -->
            <div
              v-else
              class="p-4 mt-8 bg-yellow-200 dark:bg-indigo-600 dark:text-primary font-medium"
            >
              Property address not set. Please add the property location.
            </div>
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

          <div class="mt-4">
            <div class="flex items-baseline justify-end gap-3">
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

              <!-- Save Button -->
              <AppButton
                type="submit"
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
                {{ isFirst ? 'Create' : 'Save' }}
              </AppButton>

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
      </div>
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
