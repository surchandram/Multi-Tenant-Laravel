<script>
  export default {
    pageLayout: 'account',
  };
</script>

<script setup>
  import { Head, useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';

  const form = useForm({
    password: null,
  });

  const updatePassword = () => {
    form.post(route('account.deactivate.store'), {
      onSuccess: () => {
        form.reset();
      },
      onError: () => {
        form.reset();
      },
    });
  };
</script>

<template>
  <Head :title="__('app.labels.deactivate_account')" />

  <div class="p-7 rounded-md shadow-sm bg-white dark:bg-slate-900 dark:text-primary">
    <h3 class="mb-2 text-slate-600 font-medium dark:text-slate-100">{{ __('app.labels.deactivate_account') }}</h3>

    <!-- <div class="mb-8 border-t-2 border-indigo-200"></div> -->

    <p class="mb-6 text-indigo-700 text-sm font-medium">{{ __('app.account.deactivate.warning') }}</p>

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
        <AppInputLabel for="password">{{ __('app.labels.password') }}</AppInputLabel>

        <AppInput
          id="password"
          v-model="form.password"
          type="password"
          class="w-full"
          :placeholder="__('app.labels.deactivate_password_placeholder')"
        />

        <p class="mb-6 text-sm text-rose-500 font-medium">
          {{ __('app.account.deactivate.info', { email: $page.props.auth.user.email }) }}
        </p>
        <AppInputError :message="form.errors.password" />
      </div>

      <div class="flex items-center justify-end gap-3 mt-6">
        <AppLightButton
          :href="route('account.index')"
          :disabled="form.processing"
          >{{ __('app.buttons.cancel') }}</AppLightButton
        >

        <AppButton
          type="submit"
          class="inline-flex items-center gap-3 bg-rose-400 hover:bg-rose-600 focus:bg-rose-600 focus:ring text-white"
          plain
          :disabled="form.processing"
        >
          <AppSpinner
            v-if="form.processing"
            :size="4"
          />
          {{ __('app.buttons.deactivate_account_confirm') }}
        </AppButton>
      </div>
    </form>
  </div>
</template>
