<script setup>
  import { onMounted, reactive, ref } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputGroup from "@/components/AppInputGroup.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppModal from "@/components/AppModal.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";

  const props = defineProps({
    model: {
      type: Object,
      default: function () {
        return {};
      }
    },
  });

  const emit = defineEmits([
    'psychrometric-report::updated'
  ]);

  const form = useForm({
    recorded_at: '',
    project_affected_area_id: '',
    affected_area_id: '',
    psychrometric_report: {},
  });

  const state = reactive({});

  const store = () => {
    form.clearErrors();

    form
      .post(
        route(
          'restore.projects.psychrometric-report.readings.store',
          props.model.project
        ),
        {
          onSuccess: () => {
            // hide modal
            $eventBus.emit('close-modal', 'psychrometricReportEditor');

            emit('psychrometric-report::updated');
          },
        }
      );
  };

  const modalRef = ref(null);

  const setupForm = ({ key, affectedArea, recordingDate }) => {

    state.key = key;
    state.affectedArea = affectedArea;
    state.recordingDate = recordingDate;

    const affectedAreaModel = _.find(props.model.project.affectedAreas, ['name', key]);

    form.recorded_at = recordingDate;
    form.project_affected_area_id = affectedAreaModel?.affected_area_id;
    form.affected_area_id = affectedAreaModel?.id;

    _.keys(state.affectedArea).forEach((measurePoint) => {
      form.psychrometric_report = Object.assign(
        {},
        form.psychrometric_report,
        {
          [measurePoint]: _.merge(_.pick(
            state.affectedArea[measurePoint],
            [
              'temperature',
              'relative_humidity',
              'psychrometry_measure_point_id',
              'project_affected_area_id',
            ]
          ), {
            // todo: set value from weather api if empty for `outside`
            recorded_at: recordingDate,
          })
        }
      );
    });

    // show modal
    $eventBus.emit('open-modal', 'psychrometricReportEditor');
  };

  onMounted(() => {
    // setup form before opening modal
    $eventBus.on('psychrometric-report::edit', setupForm)
  });
</script>

<template>
  <form action="#" @submit.prevent="store">
    <AppModal
      id="psychrometricReportEditor"
      ref="modalRef"
      close-label="Cancel"
      submit
      :submit-callback="store"
      :disabled="form.processing"
    >
      <template v-if="state.affectedArea" #header>
        <div class="text-sm font-semibold mb-3">
          Psychrometric Report Editor:
          <span class="text-slate-600 font-semibold">{{ state.recordingDate }}</span>
        </div>

        <p class="text-sm text-slate-500">
          Fill the fields below with readings for:
          <span class="text-slate-600 font-semibold">{{ state.key }}</span>
        </p>
      </template>

      <div
        v-if="state.affectedArea"
        class="flex flex-col gap-6"
      >
        <!-- Validation Errors -->
        <AppValidationErrors
          :errors="form.errors"
          :class="{ 'mb-5': form.errors }"
        />

        <!-- Header -->
        <div
          class="grid grid-cols-3 gap-4 mb-4 text-sm font-semibold bg-slate-200/80"
        >
          <div class="md:col-start-2 px-4 py-2">
            Temperature (F&deg;)
          </div>
          <div class="px-4 py-2">
            Relative Humidity (RH)
          </div>
        </div>

        <div
          v-for="(measurePoint, index) in state.affectedArea"
          :key="index"
          class="
            grid
            grid-cols-1
            md:grid-cols-3
            gap-4
            text-sm
            hover:bg-slate-100
          "
        >
          <div class="inline-flex items-center p-2">
            <AppInputLabel :value="index" class="block" />
          </div>

          <div class="p-2 -mb-2">
            <AppInputGroup end="F">
              <template #default="{ inputStyles }">
                <AppInput
                  v-model.number="form.psychrometric_report[index]['temperature']"
                  type="text"
                  :class="inputStyles"
                  class="w-1/2"
                />
              </template>
              <template #end>
                F&deg;
              </template>
            </AppInputGroup>

            <AppInputError
              v-if="form.errors.psychrometric_report"
              :message="form.errors.psychrometric_report[index]?.temperature"
            />
          </div>

          <div class="p-2 -mb-2">
            <AppInputGroup end="%">
              <template #default="{ inputStyles }">
                <AppInput
                  v-model.number="form.psychrometric_report[index]['relative_humidity']"
                  type="text"
                  :class="inputStyles"
                  class="w-1/2"
                />
              </template>
            </AppInputGroup>

            <AppInputError
              v-if="form.errors.psychrometric_report"
              :message="form.errors.psychrometric_report[index]?.relative_humidity"
            />
          </div>
        </div>
      </div>
    </AppModal>
  </form>
</template>
