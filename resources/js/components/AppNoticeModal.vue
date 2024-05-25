<script setup>
  import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import useNotice from '@/composables/useNotice';

  const { open, notice, close } = useNotice();
</script>

<template>
  <div v-if="notice">
    <TransitionRoot
      appear
      :show="open"
      as="template"
    >
      <Dialog
        as="div"
        class="relative z-[99999]"
        @close="close"
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
                  {{ notice.title }}
                </DialogTitle>

                <!-- Details -->
                <div class="space-y-8 mt-2">
                  <div class="flex flex-col gap-4 mt-3">
                    <div>
                      <p class="text-base mt-2">{{ notice.body }}</p>
                    </div>
                  </div>

                  <div class="flex items-center justify-end gap-3 mt-4">
                    <AppLightButton @click="close">{{ __('app.labels.close') }}</AppLightButton>

                    <AppButton
                      v-if="notice.action && notice.action.url"
                      :href="notice.action.url"
                      native
                    >
                      {{ notice.action.label }}
                      <i class="bi bi-arrow-right"></i>
                    </AppButton>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>
