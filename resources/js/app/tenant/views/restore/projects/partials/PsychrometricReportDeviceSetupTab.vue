<script setup>
  import { inject, ref, onMounted, computed, reactive } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue';
  import PsychrometricReportGridColumn from './PsychrometricReportGridColumn.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSvg from '@/components/AppSvg';
  import AppTabs from '@/components/AppTabs.vue';
  import AppQrCodeScanner from '@/components/AppQrCodeScanner.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';

  const props = defineProps({
    data: {
      type: Object,
      required: true,
    },
    project: {
      type: Object,
      required: true,
    },
  });

  const $eventBus = inject('$eventBus');

  const state = reactive({
    device: null,
    showDevice: false,
  });

  const isOpen = ref(true);

  function closeModal() {
    isOpen.value = false;
    state.showDevice = false;
    showQrScanner.value = false;
    $eventBus.emit('qrcode-scanner::stop');
  }

  function openModal() {
    isOpen.value = true;
  }

  const tabs = computed(() => _.map(props.data, (v, key) => key));

  const affectedArea = ref(null);
  const deviceMeasurePoint = ref(null);

  const form = useForm({
    device: null,
    project_id: null,
    project_affected_area_id: null,
    psychrometry_measure_point_id: null,
  });

  const setupForm = (area, measure_point) => {
    affectedArea.value = area;
    deviceMeasurePoint.value = measure_point;
  };

  const showQrScanner = ref(false);

  const linkDevice = () => {
    form.post(route('restore.projects.psychrometric-report.devices.store', props.project.id), {
      onSuccess: () => {
        closeModal();
        form.reset();
        affectedAreas.value = props.data;
        $eventBus.emit('psychrometric-report-map::updated');
      },
    });
  };

  const affectedAreas = ref(props.data);

  onMounted(() => {
    $eventBus.on('psychrometric-report-map::scan-device', ({ area, measure_point, measure_point_data }) => {
      form.defaults(measure_point_data);
      form.reset();

      setupForm(area, measure_point);

      setTimeout(() => {
        openModal();
        showQrScanner.value = true;
      }, 500);
    });

    // listen to 'qrcode-scanner::result'
    $eventBus.on('qrcode-scanner::result', (scannerData) => {
      form.device = scannerData.decodedText;

      showQrScanner.value = false;
    });

    // listen to 'psychrometric-report-map::show-device-info'
    $eventBus.on('psychrometric-report-map::show-device-info', (deviceData) => {
      state.device = deviceData.measurePointData.device;
      setupForm(deviceData.area, deviceData.measure_point);

      state.showDevice = true;
      setTimeout(() => {
        openModal();
      }, 500);
    });
  });
</script>

<template>
  <div class="flex flex-col gap-6">
    <AppTabs
      :tabs="affectedAreas"
      index-as-label
    >
      <template #content="{ currentTab, tabIndex }">
        <!-- Header -->
        <div class="hidden md:grid md:grid-cols-5 gap-2 mb-4 text-sm font-semibold">
          <div class="col-span-full md:col-auto px-4 py-2">&nbsp;</div>
          <div class="col-span-full md:col-span-3 px-4 py-2 bg-slate-200/80">Device</div>
          <div class="col-span-full md:col-span-1 px-4 py-2 bg-slate-200/80">Actions</div>
        </div>
        <!-- /Header -->

        <div
          v-for="(measurePointData, index) in currentTab"
          :key="index"
          class="grid grid-cols-1 md:grid-cols-5 gap-2 mt-3 text-sm hover:bg-slate-200"
        >
          <!-- Measure Point Label -->
          <div class="col-span-full md:col-auto">
            <PsychrometricReportGridColumn
              label="Area"
              :value="index"
              class="w-full text-slate-600 font-semibold bg-slate-200/80"
            />
          </div>
          <!-- /Measure Point Label -->

          <!-- Device -->
          <div class="col-span-full md:col-span-3">
            <PsychrometricReportGridColumn
              label="Device"
              :value="measurePointData.device?.uuid ? measurePointData.device.name : 'No device setup.'"
              class="w-full text-slate-600 font-medium bg-slate-200/80"
            />
          </div>

          <!-- Actions -->
          <div class="col-span-full md:col-span-1 flex md:justify-center">
            <AppLightButton
              v-if="measurePointData.device?.uuid"
              type="button"
              class="text-2xl"
              @click="
                $eventBus.emit('psychrometric-report-map::show-device-info', {
                  area: tabs[tabIndex],
                  measure_point: index,
                  measurePointData,
                })
              "
            >
              <AppSvg
                size="32"
                icon="/icons/cloud-data-connection.svg"
                path="cloud-data-connection"
                variant="text-teal-500"
              />
            </AppLightButton>

            <AppButton
              v-else
              type="button"
              class="text-2xl"
              @click="
                $eventBus.emit('psychrometric-report-map::scan-device', {
                  area: tabs[tabIndex],
                  measure_point: index,
                  measure_point_data: measurePointData,
                })
              "
            >
              <i class="bi bi-qr-code-scan"></i>
            </AppButton>
          </div>
          <!-- /Values -->
        </div>
      </template>
    </AppTabs>

    <!-- Device Modal -->
    <div v-if="state.showDevice || affectedArea">
      <TransitionRoot
        appear
        :show="isOpen"
        as="template"
      >
        <Dialog
          as="div"
          class="relative z-99999"
          @close="closeModal"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
              <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
              >
                <DialogPanel
                  class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                >
                  <DialogTitle
                    as="h3"
                    class="text-lg font-medium leading-6 text-gray-900"
                  >
                    Device {{ state.showDevice ? 'Info' : 'Setup' }}
                  </DialogTitle>

                  <!-- Device Details -->
                  <div
                    v-if="state.showDevice"
                    class="mt-2"
                  >
                    <p class="text-sm text-gray-500">
                      Showing device details for <strong>{{ deviceMeasurePoint }}</strong> in
                      <strong>{{ affectedArea }}</strong>
                    </p>

                    <div class="flex flex-col gap-4 mt-3">
                      <div>
                        <h4 class="text-sm font-medium">Device name</h4>
                        <p class="text-sm font-semibold mt-2">{{ state.device.name }}</p>
                      </div>
                      <div>
                        <h4 class="text-sm font-medium">Device uuid</h4>
                        <p class="text-sm font-semibold mt-2">{{ state.device.uuid }}</p>
                      </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                      <AppLightButton @click="closeModal">Close</AppLightButton>
                    </div>
                  </div>

                  <!-- Device Link Up Form -->
                  <form
                    v-else
                    action="#"
                    method="POST"
                    @submit.prevent="linkDevice"
                  >
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">
                        Setup device to take readings for <strong>{{ deviceMeasurePoint }}</strong> in
                        <strong>{{ affectedArea }}</strong>
                      </p>

                      <AppValidationErrors
                        :class="{
                          'mt-4': Object.keys(form.errors).length,
                        }"
                        :errors="form.errors"
                      />

                      <AppQrCodeScanner
                        v-if="showQrScanner"
                        class="mt-4"
                      />

                      <div
                        v-else
                        class="mt-4"
                      >
                        <div class="mb 3">
                          <AppInputLabel value="Device name" />

                          <AppInput
                            v-model="form.device"
                            class="w-full mt-2"
                            readonly
                          />
                        </div>

                        <p class="mt-3">
                          <a
                            href="#"
                            @click.prevent="showQrScanner = true"
                            >Scan Qr Code</a
                          >
                        </p>
                      </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-4">
                      <button
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:opacity-25"
                        :disabled="form.processing"
                        @click="closeModal"
                      >
                        Cancel
                      </button>

                      <button
                        type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-teal-100 px-4 py-2 text-sm font-medium text-teal-900 hover:bg-teal-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 focus-visible:ring-offset-2 disabled:opacity-25"
                        :disabled="form.processing"
                      >
                        Link Device
                      </button>
                    </div>
                  </form>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
    </div>
    <!-- /Device Modal -->
  </div>
</template>
