<script setup>
  import { useForm, usePage } from "@inertiajs/vue3";

  import AppButton from "@/components/AppButton.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  const form = useForm({
    username: "",
    email: "",
    password: "",
  });

  const emit = defineEmits(["submit-error"]);

  const handleSubmit = () => {
    form.post(
      route("tenant.customers.portal.auth.login", {
        redirect: usePage().props.redirect_url,
      }),
      {
        onSuccess: () => {
          //
        },
        onError: () => {
          emit("submit-error");
        },
      }
    );
  };
</script>

<template>
  <!-- Login Form -->
  <form action="#" @submit.prevent="handleSubmit">
    <div class="mt-4">
      <AppInputLabel :value="__('app.labels.email')" for="email" />

      <AppInput id="email" v-model="form.email" type="email" class="w-full mt-2" />

      <AppInputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="mt-4">
      <AppInputLabel :value="__('app.labels.password')" for="password" />

      <AppInput id="password" v-model="form.password" type="password" class="w-full mt-2" />

      <AppInputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="flex flex-col flex-wrap items-center justify-center mt-6 space-y-6 overflow-hidden">
      <AppButton
        class="inline-flex items-center justify-center gap-3 py-4 text-lg shrink w-full"
        type="submit"
        :disabled="form.processing"
      >
        <AppSpinner v-if="form.processing" />
        {{ __('customer.auth.invitation.access_account_button') }}
      </AppButton>
    </div>
  </form>
  <!-- END Login Form -->
</template>
