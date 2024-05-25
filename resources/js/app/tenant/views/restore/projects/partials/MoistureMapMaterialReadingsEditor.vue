<script setup>
  import { onMounted, watch, ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppModal from '@/components/AppModal.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import { useMomentJS } from '@/composables/momentjs.js';
  import { cloneDeep, get, map } from 'lodash';

  defineOptions({
    inheritAttrs: false,
  });

  const props = defineProps({
    modelValue: {
      type: Array,
      default: function () {
        return [];
      },
    },
    affectedArea: {
      type: Object,
      default: function () {
        return {};
      },
    },
    editable: {
      type: Object,
      default: function () {
        return {};
      },
    },
    model: {
      type: Object,
      default: function () {
        return {};
      },
    },
  });

  const { getDatesBetween, dateFormat } = useMomentJS();

  const form = useForm({
    readings: {},
  });

  const store = () => {
    form.clearErrors();

    let moistureMap = props.model.project.moisture_map.find((f) => f.id == props.editable.id);

    const oldData = cloneDeep(form.data());

    form
      .transform((data) => ({
        ...data,
        readings: map(data.readings, (readingValue, recordedAt) => {
          return {
            value: readingValue,
            recorded_at: dateFormat(moment(recordedAt), 'YYYY/MM/DD'),
          };
        }),
      }))
      .post(route('restore.projects.moisture-map.readings.store', [props.model.project, moistureMap.id]), {
        onSuccess: () => {
          form.reset();

          // hide modal
          modalRef.value.hide();
        },
        onError: () => {
          form.readings = cloneDeep(oldData.readings);
        },
      });
  };
  // 867209052510029

  const modalRef = ref(null);

  defineExpose({
    modal: modalRef.value,
  });

  onMounted(() => {
    $eventBus.on('moisture-map::fill-readings-form', () => {
      // show modal
      setTimeout(() => {
        modalRef.value?.show();
      }, 200);
    });

    // setup readings dates
    const readingsDates = getDatesBetween(
      props.model.project.starts_at,
      moment.min(props.model.project.ends_at, moment()),
      'MM/DD/YYYY',
    );

    readingsDates.forEach((readingDate) => {
      form.readings = Object.assign({}, form.readings, { [readingDate]: null });
    });

    // setup initial readings
    watch(
      () => cloneDeep(props.editable),
      (data) => {
        if (!data) {
          return;
        }

        readingsDates.forEach((readingDate) => {
          form.readings = Object.assign({}, form.readings, {
            [readingDate]: get(data.readings, moment(readingDate, 'MM/DD/YYYY').format('YYYY-MM-DD'), null),
          });
        });
      },
    );
  });
</script>

<template>
  <AppModal
    id="structureReadingsInputModal"
    ref="modalRef"
    header-as="div"
    close-label="Cancel"
    submit
    :submit-callback="store"
    :disabled="form.processing"
  >
    <template
      v-if="editable"
      #header
    >
      <div class="text-base font-medium mb-3">{{ __('tenant.labels.enter_readings_prompt') }}&colon;</div>

      <div class="flex flex-col sm:flex-row sm:items-center sm:flex-wrap gap-3 sm:gap-x-1 text-sm">
        <div class="space-x-1 leading-none">
          <span class="sm:hidden">{{ __('tenant.labels.affected_area') }}:&nbsp;</span>
          <span class="text-slate-500 dark:text-slate-200 font-medium">
            {{ affectedArea.name }}
          </span>
          <span class="hidden md:inline">&bullet;</span>
        </div>

        <div class="space-x-1">
          <span class="sm:hidden">{{ __('tenant.labels.structure') }}:&nbsp;</span>
          <span class="text-slate-500 dark:text-slate-200 font-medium">
            {{ editable.structure }}
          </span>
          <span class="hidden md:inline">&bullet;</span>
        </div>

        <div>
          <span class="sm:hidden">{{ __('tenant.labels.material') }}:&nbsp;</span>
          <span class="text-slate-600 dark:text-indigo-200 font-medium">
            {{ editable.material }}
          </span>
        </div>
      </div>
    </template>

    <form
      action="#"
      @submit.prevent="store"
    >
      <div class="flex flex-col gap-6">
        <!-- Validation Errors -->
        <AppValidationErrors
          :errors="form.errors"
          :class="{ 'mb-5': form.errors }"
        />

        <p class="text-sm text-slate-500 dark:text-slate-300">{{ __('tenant.labels.fill_days_readings_prompt') }}</p>

        <!-- Date Readings Input Group -->
        <div
          v-for="(readingValue, readingDate) in form.readings"
          :key="readingDate"
        >
          <div class="grid grid-cols-2 gap-4">
            <AppInputLabel
              :value="readingDate"
              class="block"
            />

            <AppInputGroup end="%">
              <template #default="{ inputStyles }">
                <AppInput
                  v-model.number="form.readings[readingDate]"
                  type="text"
                  :class="inputStyles"
                  class="w-1/2"
                />
              </template>
            </AppInputGroup>
          </div>
        </div>
        <!-- END Date Readings Input Group -->
      </div>
    </form>
  </AppModal>
</template>
