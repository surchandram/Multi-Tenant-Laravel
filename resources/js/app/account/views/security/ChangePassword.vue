<script>
  export default {
    pageLayout: 'account',
  };
</script>

<script setup>
  import { Head, useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';

  const form = useForm({
    password: null,
    password_confirmation: null,
    current_password: null,
  });

  const updatePassword = () => {
    form.post(route('account.password.store'), {
      onSuccess: () => {
        form.reset();
      },
      onError: () => {
        form.reset('current_password');
      },
    });
  };
</script>

<template>
  <Head :title="__('app.labels.change_password')" />

  <div class="p-7 rounded-md shadow-sm bg-white dark:bg-slate-900 dark:text-primary">
    <h3 class="mb-6 text-slate-600 font-medium dark:text-slate-100">{{ __('app.labels.change_password') }}</h3>

    <form
      action="#"
      @submit.prevent="updatePassword"
    >
      <AppValidationErrors
        v-if="form.hasErrors"
        :errors="form.errors"
        class="mb-4"
      />

      <div class="space-y-3">
        <AppInputLabel for="password">{{ __('app.labels.new_password') }}</AppInputLabel>

        <AppInput
          id="password"
          v-model="form.password"
          type="password"
          class="w-full"
          :placeholder="__('app.labels.new_password_placeholder')"
        />

        <AppInputError :message="form.errors.password" />
      </div>

      <div class="form-group mt-6 space-y-3">
        <AppInputLabel for="password_confirmation">{{ __('app.labels.confirm_password') }}</AppInputLabel>

        <div class="input-group password-check">
          <AppInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="w-full"
            :placeholder="__('app.labels.confirm_password_placeholder')"
          />
        </div>
      </div>

      <div class="mt-6 space-y-3">
        <AppInputLabel for="current_password">{{ __('app.labels.current_password') }}</AppInputLabel>

        <AppInput
          id="current_password"
          v-model="form.current_password"
          type="password"
          class="w-full"
          :placeholder="__('app.labels.current_password_placeholder')"
        />

        <AppInputError :message="form.errors.current_password" />
      </div>

      <div class="flex items-center justify-end mt-6">
        <AppButton
          type="submit"
          class="inline-flex items-center gap-3"
          :disabled="form.processing"
        >
          <AppSpinner
            v-if="form.processing"
            :size="4"
          />
          {{ __('app.buttons.update') }}
        </AppButton>
      </div>
    </form>
  </div>
</template>
