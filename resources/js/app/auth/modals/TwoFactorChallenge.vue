<script setup>
  import { Head, useForm } from "@inertiajs/vue3";
  import Modal from "@/components/modals/Modal.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  import { useModal } from 'momentum-modal';

  const { close } = useModal();

  const form = useForm({
    code: null,
  });

  const confirmCode = () => {
    form.post(route("two-factor.login"), {
      onSuccess: () => {
        close();
      },
      onError: () => {
        form.reset("code");
      },
    });
  };

  defineProps(["model"]);
</script>

<template>
  <Head :title="__('app.labels.2fa')" />

  <div>
    <Modal class="lg:max-w-sm lg:w-96" :title="__('app.labels.2fa')">
      <form action="#" @submit.prevent="confirmCode">
        <div class="mt-6 space-y-3">
          <AppInputLabel for="code" class>{{ __('app.labels.code') }}</AppInputLabel>

          <AppInput
            id="code"
            v-model="form.code"
            type="text"
            name="code"
            placeholder
            class="py-2"
          />

          <AppInputError :message="form.errors.code" />
        </div>

        <div class="flex items-center justify-end mt-8">
          <AppButton
            type="submit"
            class="inline-flex items-center justify-center flex-1 gap-3"
            :disabled="form.processing"
          >
            <AppSpinner v-if="form.processing" :size="4" />
            {{ __('app.labels.continue') }}
          </AppButton>
        </div>
      </form>
    </Modal>
  </div>
</template>
