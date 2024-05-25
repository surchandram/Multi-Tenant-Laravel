<script>
  export default {
    pageLayout: "customer_project",
  };
</script>

<script setup>
  import { ref, onMounted, inject } from "vue";
  import { Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import { useForm } from "@inertiajs/vue3";
  import { useMomentJS } from '@/composables/momentjs';

  const props = defineProps([
    'model'
  ]);

  const documentRef = ref([]);
  const authorizeButtonRef = ref(null);
  const isOpen = ref(false);
  const selectedTab = ref(0);

  const { formatDateZone } = useMomentJS();

  const form = useForm({
    approved: null
  });

  const setIsOpen = (value) => {
    isOpen.value = value

    if (!value) {
      form.reset();
      selectedTab.value = 0;
    }
  };

  const $scrollTo = inject("$scrollTo");

  const scrollTo = (el = "body") => {
    $scrollTo(el, { container: "#pjAuthDialog", duration: 500, offset: -100, });
  };

  const changeTab = (index) => {
    selectedTab.value = index;

    setTimeout(() => {
      scrollTo(`#pjAuthTabPanels`);
    }, 200);
  };

  const isAccepted = () => {
    return form.accepted;
  };

  const store = () => {
    form.post(route('tenant.customers.portal.projects.work-authorization.store', props.model.project), {
      onSuccess: () => setIsOpen(false),
    });
  };

  onMounted(() => {
    $eventBus.on('toggle-project-completion-approval-form', () => setIsOpen(!isOpen.value));
  });
</script>

<template>
  <!-- Form Modal -->
  <Dialog :open="isOpen" class="relative z-50" @close="setIsOpen(false)">
    <!-- The backdrop, rendered as a fixed sibling to the panel container -->
    <div class="fixed inset-0 bg-black/30" aria-hidden="true" />

    <!-- Full-screen scrollable container -->
    <div id="pjAuthDialog" class="fixed inset-0 overflow-y-auto">
      <!-- Container to center the panel -->
      <div class="flex min-h-full items-center justify-center p-4">
        <!-- The actual dialog panel -->
        <DialogPanel class="w-full md:max-w-xl xl:max-w-5xl px-4 py-8 lg:px-8 lg:py-12 rounded bg-white">
          <DialogTitle as="div" class="flex items-center justify-between py-2 mb-6">
            <div>
              <h4 class="font-medium text-lg text-slate-600">
                Work Completion Certificate
              </h4>
            </div>

            <AppLightButton type="button" @click="setIsOpen(false)"><i class="bi bi-x"></i></AppLightButton>
          </DialogTitle>

          <form id="pjAuthTabPanels" action="#" @submit.prevent="store">
            <AppValidationErrors />

            <p class="text-sm font-medium">Approve agreement for work completion undertaken at:</p>
            <br>
            <div class="text-xs font-semibold text-slate-700">
              {{ model.project.address.address_1 }},
              {{ model.project.address.city }},
              {{ model.project.address.postal_code }},
              {{ model.project.address.state }}
            </div>

            <div class="w-full px-4 py-2 mt-8 bg-slate-50">
              <div class="min-w-full text-gray-700 prose prose-sm lg:prose" v-html="model.completion_document.body" />

              <div class="w-full flex justify-end py-2 mt-6">
                <AppInputLabel class="inline-flex items-center justify-end gap-2">
                  <AppCheckbox v-model="form.accepted" :value="model.completion_document.id" />
                  I agree
                </AppInputLabel>
              </div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-12">
              <AppLightButton type="button" @click="setIsOpen(false)">Cancel</AppLightButton>

              <!-- Use `initialFocus` to force initial focus to a specific ref. -->
              <AppButton v-if="form.accepted" ref="authorizeButtonRef" type="submit">
                Confirm
              </AppButton>
            </div>
          </form>
        </DialogPanel>
      </div>
    </div>
  </Dialog>
  <!-- END Form Modal -->
</template>
