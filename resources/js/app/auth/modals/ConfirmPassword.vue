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
    password: null,
  });

  const confirmPassword = () => {
    form.post(route("password.confirm"), {
      onSuccess: () => {
        form.reset("password");
        close();
      },
      onError: () => {
        form.reset("password");
      },
    });
  };

  defineProps(["model"]);
</script>

<template>
  <Head :title="__('app.labels.confirm_password')" />

  <div>
    <Modal class="lg:max-w-sm lg:w-96" :title="__('app.labels.confirm_password')">
      <form action="#" @submit.prevent="confirmPassword">
        <div class="mt-6 space-y-3">
          <AppInputLabel for="password" class>{{ __('app.labels.current_password') }}</AppInputLabel>

          <AppInput
            id="password"
            v-model="form.password"
            type="password"
            class="w-full"
            :placeholder="__('app.labels.current_password_placeholder')"
          />

          <AppInputError :message="form.errors.password" />
        </div>

        <div class="flex items-center justify-end mt-8">
          <AppButton
            type="submit"
            class="inline-flex items-center justify-center flex-1 gap-3"
            :disabled="form.processing"
          >
            <AppSpinner v-if="form.processing" :size="4" />
            {{ __('app.labels.confirm_password') }}
          </AppButton>
        </div>
      </form>
    </Modal>
  </div>
</template>
