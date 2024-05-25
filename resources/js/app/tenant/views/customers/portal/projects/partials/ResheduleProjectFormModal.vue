<script>
  export default {
    pageLayout: "customer_project",
  };
</script>

<script setup>
  import { ref, onMounted } from "vue";
  import { Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue';
  import { useFlatpickr } from '@/composables/flatpickr';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import { useForm } from "@inertiajs/vue3";
  import { useMomentJS } from '@/composables/momentjs';

  const props = defineProps([
    'project'
  ]);

  const rescheduleButtonRef = ref(null)
  const isOpen = ref(false)

  const { formatDateZone } = useMomentJS();

  const form = useForm({
    starts_at: formatDateZone(props.project.starts_at, 'MM/DD/YYYY H:mm'),
    // ends_at: props.project.ends_at,
  });

  function setIsOpen(value) {
    isOpen.value = value

    if (!value) {
      form.reset();
    } else {
      setTimeout(() => {
        // setup date pickers
        startDatePicker();
        endDatePicker();
      }, 500);
    }
  };

  function store() {
    form.post(route('tenant.customers.portal.projects.reschedule.store', props.project), {
      onSuccess: () => setIsOpen(false),
    });
  };

  // flatpickr setup
  const { startDatePicker, endDatePicker } = useFlatpickr({
    boot: false,
    startDate: {
      minDate: form.contacted_at,
      dateFormat: 'Y-m-d H:i',
      enableTime: true
    },
    endDate: {
      minDate: form.ends_at,
      dateFormat: 'Y-m-d H:i',
      enableTime: true
    },
  });

  onMounted(() => {
    $eventBus.on('toggle-project-reschedule-form', (val) => setIsOpen(!isOpen.value));
  });
</script>

<template>
  <!-- Form Modal -->
  <Dialog :open="isOpen" class="relative z-50" @close="setIsOpen">
    <!-- The backdrop, rendered as a fixed sibling to the panel container -->
    <div class="fixed inset-0 bg-black/30" aria-hidden="true" />

    <!-- Full-screen scrollable container -->
    <div class="fixed inset-0 overflow-y-auto">
      <!-- Container to center the panel -->
      <div class="flex min-h-full items-center justify-center p-4">
        <!-- The actual dialog panel -->
        <DialogPanel class="w-full max-w-sm xl:max-w-xl px-4 py-8 lg:px-8 lg:py-12 rounded bg-white">
          <DialogTitle as="h4" class="font-semibold text-lg text-slate-600 mb-6">
            Reschedule your project
          </DialogTitle>

          <form action="#" @submit.prevent="store">
            <AppValidationErrors />

            <div class="grid md:grid-cols-2 gap-6">
              <div class="col-span-full md:col-span-1 mt-4">
                <AppInputLabel for="starts_at">Starts at</AppInputLabel>

                <AppInput id="starts_at" v-model="form.starts_at" class="w-full mt-2 datepicker-from" />

                <AppInputError class="mt-2" :message="form.errors.starts_at" />
              </div>

              <div class="hidden col-span-full md:col-span-1 mt-4">
                <AppInputLabel for="ends_at">Ends at</AppInputLabel>

                <AppInput id="ends_at" type="hidden" :value="props.project.ends_at" class="w-full mt-2 datepicker-to" />

                <AppInputError class="mt-2" :message="form.errors.ends_at" />
              </div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-12">
              <AppLightButton type="button" @click="setIsOpen(false)">Cancel</AppLightButton>

              <!-- Use `initialFocus` to force initial focus to a specific ref. -->
              <AppButton ref="rescheduleButtonRef" type="submit">
                Reschedule
              </AppButton>
            </div>
          </form>
        </DialogPanel>
      </div>
    </div>
  </Dialog>
  <!-- END Form Modal -->
</template>
