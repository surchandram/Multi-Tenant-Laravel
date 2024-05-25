<script setup>
  import { useSlots, ref, onMounted, inject } from 'vue';
  import { get } from 'lodash';
  import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue';
  import AppButton from './AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSpinner from './AppSpinner.vue';
  import LucideIcon from './LucideIcon.vue';

  const props = defineProps({
    id: {
      type: String,
      default: Date.now(),
    },
    size: {
      type: String,
      default: '2xl',
    },
    vCentered: {
      type: Boolean,
      default: true,
    },
    contentClasses: {
      type: [Array, String],
      default: '',
    },
    panelClasses: {
      type: [Array, String],
      default: '',
    },
    headerAs: {
      type: String,
      default: 'h2',
    },
    noFooter: {
      type: Boolean,
      default: false,
    },
    submit: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    spinner: {
      type: Boolean,
      default: false,
    },
    allowOverflow: {
      type: Boolean,
      default: false,
    },
    noScroll: {
      type: Boolean,
      default: false,
    },
    closeLabel: {
      type: String,
      default: 'Close',
    },
    submitTheme: {
      type: String,
      default: 'default',
    },
    submitLabel: {
      type: String,
      default: 'Save',
    },
    submitCallback: {
      type: Function,
      default: () => console.log('Default Function'),
    },
  });

  const emit = defineEmits(['closed', 'opened', 'ready']);

  const $eventBus = inject('$eventBus');

  const isOpen = ref(false);

  const closeModal = () => {
    isOpen.value = false;
    emit('closed');
    $eventBus.emit('closed-modal', props.id);
  };

  const openModal = () => {
    isOpen.value = true;
    emit('opened');
    $eventBus.emit('opened-modal', props.id);
  };

  const slots = useSlots();

  const sizes = {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
  };

  const size = get(sizes, props.size, sizes['2xl']);

  const handleShowModalEvent = (modalId) => {
    if (props.id != modalId) {
      return;
    }
    openModal();
  };

  const handleHideModalEvent = (modalId) => {
    if (props.id != modalId) {
      return;
    }
    closeModal();
  };

  onMounted(() => {
    // listen to 'show-modal' event
    $eventBus.on('show-modal', handleShowModalEvent);
    $eventBus.on('open-modal', handleShowModalEvent);

    emit('ready', {
      close: closeModal,
      hide: closeModal,
      open: openModal,
      show: openModal,
    });

    // listen to 'hide-modal' event
    $eventBus.on('hide-modal', handleHideModalEvent);
    $eventBus.on('close-modal', handleHideModalEvent);
  });

  defineExpose({
    close: closeModal,
    hide: closeModal,
    open: openModal,
    show: openModal,
    isOpen: isOpen.value,
  });
</script>

<template>
  <TransitionRoot
    appear
    :show="isOpen"
    as="template"
  >
    <Dialog
      :id="id"
      class="relative z-[1099]"
      tabindex="-1"
      :aria-labelledby="`${props.id}Label`"
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
              :class="[size, { 'overflow-hidden': !allowOverflow }, panelClasses]"
              class="modal-content w-full transform rounded-2xl bg-white text-left align-middle shadow-xl transition-all z-[9999] dark:bg-slate-800 dark:text-slate-100"
            >
              <!-- Modal Header -->
              <DialogTitle
                v-if="slots.header"
                :as="headerAs"
                class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-slate-200 rounded-t-md"
              >
                <div
                  :id="`${props.id}Label`"
                  class="text-xl font-medium leading-normal text-gray-800 dark:text-gray-100"
                >
                  <slot name="header">{{ slots.header }}</slot>
                </div>

                <AppLightButton
                  type="button"
                  aria-label="Close"
                  :disabled="props.disabled"
                  @click="closeModal"
                >
                  <LucideIcon
                    name="x"
                    class="size-5"
                  />
                </AppLightButton>
              </DialogTitle>

              <!-- Modal Body -->
              <div
                :class="[
                  {
                    'overflow-y-auto': !noScroll,
                  },
                  contentClasses,
                ]"
                class="modal-body relative p-4"
              >
                <slot></slot>
              </div>

              <div
                v-if="!props.noFooter"
                class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end gap-3 p-4 border-t border-slate-200 rounded-b-md"
              >
                <!-- Close Button Slot -->
                <slot
                  name="closeButton"
                  :modal-disabled="props.disabled"
                >
                  <AppLightButton
                    type="button"
                    class="bg-slate-100"
                    :disabled="props.disabled"
                    @click="closeModal"
                  >
                    {{ props.closeLabel }}
                  </AppLightButton>
                </slot>

                <!-- Submit Button -->
                <slot
                  v-if="slots.submitButton || props.submit"
                  name="submitButton"
                  :modal-disabled="props.disabled"
                >
                  <AppButton
                    type="submit"
                    class="inline-flex items-center gap-2"
                    :theme="submitTheme"
                    :disabled="props.disabled"
                    @click="submitCallback"
                  >
                    <slot name="submitLabel">
                      {{ props.submitLabel }}
                      <AppSpinner
                        v-if="spinner"
                        :size="4"
                      />
                    </slot>
                  </AppButton>
                </slot>
                <!-- END Submit Button -->
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
