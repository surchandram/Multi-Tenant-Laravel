<script setup>
  import { ref, reactive, onMounted } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppInput from "@/components/AppInput.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
  } from '@headlessui/vue';

  const isOpen = ref(false);

  function closeModal() {
    isOpen.value = false
  };

  function openModal() {
    isOpen.value = true
  };

  const props = defineProps({
    confirmLabel: {
      type: String,
      default: 'Yes, continue'
    },
  });

  const state = reactive({
    user: null,
    role: null,
    callback: null
  });

  onMounted(() => {
    // listen to 'show-edit-user-role-modal' event
    $eventBus.on('show-edit-user-role-modal', (data) => {
      state.user = data.user;
      state.role = data.role;
      form.expires_at = data.role?.expires_at

      setTimeout(() => {
        openModal();
      }, 500);
    });

    // listen to 'hide-edit-user-role-modal' event
    $eventBus.on('hide-edit-user-role-modal', () => {
      closeModal();

      setTimeout(() => {
        state.user = null;
        state.role = null;
      }, 500);
    });
  });

  const form = useForm({
    expires_at: null,
  });

  const store = () => {
    form.patch(route('admin.users.roles.update', [state.user, state.role]), {
      onSuccess: () => {
        $eventBus.emit('hide-edit-user-role-modal')
      }
    });
  }
</script>

<template>
  <TransitionRoot appear :show="isOpen" as="template">
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
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
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
              <div class="flex items-center justify-between py-2">
                <div class="mr-auto">
                  <DialogTitle
                    as="h3"
                    class="text-lg font-medium leading-6 text-gray-900"
                  >
                    {{ state.user?.name }}
                  </DialogTitle>

                  <p class="text-sm mt-2">Update user's <strong>{{ state.role?.name }}</strong> role</p>
                </div>

                <AppLightButton type="button" @click="closeModal"><i class="bi bi-x"></i></AppLightButton>
              </div>

              <!-- Modal Body -->
              <div class="mt-2">
                <!-- Form -->
                <form v-if="state.role" action="#" @submit.prevent="store">
                  <AppValidationErrors :errors="form.errors" />

                  <!-- Role -->
                  <div class="mt-4">
                    <AppInputLabel for="role_id" class="block mb-2">Role</AppInputLabel>

                    <p class="mt-2 text-lg font-semibold">
                      {{ state.role.name }}
                    </p>

                    <AppInputError class="mt-2" :message="form.errors.role_id" />
                  </div>

                  <!-- Role expires at -->
                  <div class="mt-4">
                    <AppInputLabel for="expires_at">Role expires at</AppInputLabel>

                    <AppInput
                      id="expires_at"
                      v-model="form.expires_at"
                      class="w-full mt-2 datepicker_role_expires_at"
                      name="expires_at"
                    />

                    <p class="text-sm font-semibold mt-2">You can leave field as empty or set a date.</p>

                    <AppInputError class="mt-2" :message="form.errors.expires_at" />
                  </div>
                </form>
                <!--/ Form -->
              </div>
              <!-- /Modal Body -->

              <div class="w-full inline-flex justify-end gap-3 mt-8">
                <button
                  type="button"
                  class="
                    inline-flex
                    justify-center
                    rounded-md
                    border
                    border-transparent
                    bg-blue-100
                    px-4
                    py-2
                    text-sm
                    font-medium
                    text-blue-900
                    hover:bg-blue-200
                    focus:outline-none
                    focus-visible:ring-2
                    focus-visible:ring-blue-500
                    focus-visible:ring-offset-2
                  "
                  @click="closeModal"
                >
                  Cancel
                </button>

                <!-- Confirm Button -->
                <slot name="confirmButton" :close-modal="closeModal">
                  <AppButton
                    type="button"
                    :disabled="form.processing"
                    @click.prevent="store"
                  >
                    <AppSpinner v-show="form.processing" :size="4" />
                    <i v-show="!form.processing" class="bi bi-check"></i>
                    Save
                  </AppButton>
                </slot>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
