<script setup>
  import { ref, reactive, onMounted } from 'vue';
  import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import LucideIcon from './LucideIcon.vue';
  import { Button } from './ui/button';

  const isOpen = ref(false);

  const emit = defineEmits(['opened', 'closed']);

  function closeModal() {
    isOpen.value = false;
    emit('closed');
  }

  function openModal() {
    isOpen.value = true;
    emit('opened');
  }

  const props = defineProps({
    title: {
      type: String,
      default: 'Confirmation Dialog',
    },
    confirmLabel: {
      type: String,
      default: 'Yes, continue',
    },
    message: {
      type: String,
      default: 'Confirmation message goes here',
    },
    confirmTheme: {
      type: String,
      default: '',
    },
  });

  const state = reactive({
    title: '',
    message: props.message,
    callback: null,
  });

  onMounted(() => {
    // listen to 'show-confirmation-dialog-modal' event
    $eventBus.on('show-confirmation-dialog-modal', (data) => {
      state.title = data?.title || props.title;
      state.message = data?.message || props.message;
      state.callback = data?.callback;

      openModal();
    });

    // listen to 'hide-confirmation-dialog-modal' event
    $eventBus.on('hide-confirmation-dialog-modal', () => {
      state.title = '';
      state.message = props.message;
      state.callback = null;

      closeModal();
    });
  });
</script>

<template>
  <TransitionRoot
    appear
    :show="isOpen"
    as="template"
  >
    <Dialog
      class="relative z-50 z-99999"
      as="div"
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
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-slate-900"
            >
              <div class="flex items-center justify-between py-2">
                <DialogTitle
                  as="h3"
                  class="text-lg font-medium leading-6 text-gray-900 dark:text-primary"
                  >{{ state.title || title }}</DialogTitle
                >

                <Button
                  type="button"
                  variant="ghost"
                  @click="closeModal"
                >
                  <LucideIcon
                    name="x"
                    class="size-5"
                  />
                </Button>
              </div>

              <!-- Modal Body -->
              <div class="mt-2">
                <slot>{{ state.message }}</slot>
              </div>
              <!-- /Modal Body -->

              <div class="w-full inline-flex justify-end gap-3 mt-4">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="closeModal"
                >
                  {{ __('app.labels.cancel') }}
                </button>

                <!-- Confirm Button -->
                <slot
                  name="confirmButton"
                  :close-modal="closeModal"
                >
                  <AppLightButton
                    v-if="state.callback && !confirmTheme"
                    type="button"
                    plain
                    class="bg-red-200 text-red-600"
                    @click.prevent="state.callback"
                    >{{ confirmLabel }}</AppLightButton
                  >

                  <AppButton
                    v-else
                    type="button"
                    :theme="confirmTheme"
                    @click.prevent="state.callback"
                    >{{ confirmLabel }}</AppButton
                  >
                </slot>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
