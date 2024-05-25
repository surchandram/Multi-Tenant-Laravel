<script>
  export default {
    pageLayout: 'account',
  };
</script>

<script setup>
  import { computed } from 'vue';
  import { Head, useForm, usePage } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppFileInput from '@/components/AppFileInput.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';

  const form = useForm({
    first_name: usePage().props.auth.user.first_name,
    last_name: usePage().props.auth.user.last_name,
    username: usePage().props.auth.user.username,
    email: usePage().props.auth.user.email,
    password: null,
    avatar: null,
  });

  const avatarPreview = computed(() => {
    if (!form.avatar) {
      return;
    }

    return URL.createObjectURL(form.avatar);
  });

  const updateProfile = () => {
    form.post(route('account.profile.store'), {
      onSuccess: () => {
        form.reset('password', 'avatar');
      },
      onError: () => {
        form.reset('password');
      },
    });
  };
</script>

<template>
  <Head :title="__('app.labels.update_profile')" />

  <div class="p-7 rounded-md shadow-sm bg-white dark:bg-slate-900 dark:text-primary">
    <h3 class="mb-6 text-slate-600 font-medium dark:text-slate-100">{{ __('app.labels.update_profile') }}</h3>

    <form
      action="#"
      @submit.prevent="updateProfile"
    >
      <AppValidationErrors
        v-if="form.hasErrors"
        :errors="form.errors"
        class="mb-4"
      />

      <!-- Avatar -->
      <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div>
          <img
            v-if="avatarPreview"
            :src="avatarPreview"
            alt
            class="w-12 h-12 rounded-full"
          />

          <img
            v-else
            :src="$page.props.auth.user.avatar"
            alt
            class="w-12 h-12 rounded-full"
          />
        </div>

        <div class="space-y-3">
          <AppLightButton
            v-if="avatarPreview"
            @click="form.reset('avatar')"
            >{{ __('app.labels.clear') }}</AppLightButton
          >

          <label
            v-else
            for="avatar"
            class="block px-2 py-2 text-sm font-semibold cursor-pointer text-blue-500 hover:text-indigo-500 focus:ring"
            >{{ __('app.labels.choose_avatar') }}</label
          >

          <div class="sr-only">
            <AppFileInput
              id="avatar"
              v-model="form.avatar"
              type="file"
              accept=".png, .jpg, .jpeg"
              class="w-full"
              @change="($event) => (form.avatar = $event.target.files[0])"
            />
          </div>
        </div>

        <AppInputError :message="form.errors.avatar" />
      </div>
      <!-- END Avatar -->

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
        <div class="space-y-3">
          <AppInputLabel for="first_name">{{ __('app.labels.first_name') }}</AppInputLabel>

          <AppInput
            id="first_name"
            v-model="form.first_name"
            class="w-full"
            :placeholder="__('app.labels.first_name_placeholder')"
            type="text"
          />

          <AppInputError :message="form.errors.first_name" />
        </div>

        <div class="space-y-3">
          <AppInputLabel for="last_name">{{ __('app.labels.last_name') }}</AppInputLabel>

          <AppInput
            id="last_name"
            v-model="form.last_name"
            class="w-full"
            :placeholder="__('app.labels.last_name_placeholder')"
            type="text"
          />

          <AppInputError :message="form.errors.last_name" />
        </div>
      </div>

      <div class="mt-6 space-y-3">
        <AppInputLabel
          for="username"
          class
          >{{ __('app.labels.username') }}</AppInputLabel
        >

        <AppInput
          id="username"
          v-model="form.username"
          class="w-full"
          :placeholder="__('app.labels.username_placeholder')"
          type="text"
        />

        <AppInputError :message="form.errors.username" />
      </div>

      <div class="mt-6 space-y-3">
        <AppInputLabel
          for="email"
          class
          >{{ __('app.labels.email') }}</AppInputLabel
        >

        <AppInput
          id="email"
          v-model="form.email"
          type="email"
          class="w-full"
          :placeholder="__('app.labels.email_placeholder')"
        />

        <AppInputError :message="form.errors.email" />
      </div>

      <div class="mt-6 space-y-3">
        <AppInputLabel
          for="password"
          class
          >{{ __('app.labels.current_password') }}</AppInputLabel
        >

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
