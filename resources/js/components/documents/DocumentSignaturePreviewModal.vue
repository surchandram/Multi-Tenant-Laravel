<script setup>
  import { ref, onMounted, watch } from "vue";
  import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
  } from "@headlessui/vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import formatDocument from "@/helpers/documentFormatter";

  const props = defineProps({
    title: {
      type: String,
      default: "Document Preview",
    },
    replacements: {
      type: Object,
      default: () => {},
    },
  });

  const isOpen = ref(false);
  const document = ref(null);

  function closeModal() {
    isOpen.value = false;
  }

  function openModal() {
    isOpen.value = true;
  }

  const formattedBody = ref(null);

  onMounted(() => {
    // listen to 'show-document-signature' event
    $eventBus.on("show-document-signature", (documentData) => {
      document.value = documentData;
      openModal();
    });

    watch(document, (doc) => {
      if (!_.isEmpty(doc)) {
        formattedBody.value = formatDocument(doc.body, props.replacements);
      }
    });
  });
</script>

<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog class="relative z-50 z-99999" as="div" @close="closeModal">
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
              class="w-full max-w-md md:max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <div class="flex items-center justify-between py-2">
                <DialogTitle
                  as="h3"
                  class="text-lg font-medium leading-6 text-gray-900"
                >{{ document?.title || title }}</DialogTitle>

                <AppLightButton type="button" @click="closeModal">
                  <i class="bi bi-x"></i>
                </AppLightButton>
              </div>

              <!-- Document Body -->
              <div class="mt-2">
                <img v-if="document?.signed" :src="document?.signature" class="w-full" />

                <div
                  v-else
                  class="text-gray-500 font-medium"
                >{{ __('customer.labels.document_not_signed') }}</div>
              </div>
              <!-- /Document Body -->

              <div class="w-full inline-flex justify-end mt-4">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="closeModal"
                >Close</button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
