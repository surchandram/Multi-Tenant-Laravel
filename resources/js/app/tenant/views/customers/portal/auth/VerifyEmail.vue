<script>
  export default {
    pageLayout: "customer_auth",
  };
</script>

<script setup>
  import { computed } from "vue";
  import { Head } from "@inertiajs/vue3";

  import AppButton from '@/components/AppButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps([
    'tenant',
    'status',
  ]);

  const verificationLinkSent = computed(
    () => _.has(route().params, 'status') || props.status === "verification-link-sent"
  );
</script>

<template>
  <Head :title="`Customer Portal - ${$page.props.tenant.name}`" />

  <!-- Page Section -->
  <div
    class="px-4 py-8 mx-auto space-y-10 lg:space-y-16 lg:px-8 lg:py-12"
  >
    <div class="mx-auto">
      <div class="space-y-3 text-center">
        <h2 class="mb-2 text-3xl font-semibold">
          <i class="bi bi-shield"></i> {{ $page.props.tenant.name }}
        </h2>
      </div>
    </div>

    <!-- Auth Form -->
    <div class="w-full xl:max-w-lg mx-auto bg-white rounded-md">
      <div class="px-6 py-2 font-semibold bg-slate-200/80 rounded-t-md text-center">
        <h3 class="text-lg font-medium text-slate-700">
          {{ __('auth.email.verify_title') }}
        </h3>
      </div>

      <div id="formWrapper" class="px-6 pt-2 pb-8">
        <div
          class="text-base font-medium text-center"
          :class="{
            'text-slate-600': !verificationLinkSent,
            'text-indigo-600': verificationLinkSent,
          }"
        >
          {{ verificationLinkSent ? __('auth.email.resend_notification_alert') : __('auth.email.verify_prompt') }}
        </div>

          <!-- Resend Notification Form -->
        <form method="POST" :action="route('verification.send', { redirect: $page.props.ziggy.location })">
          <input type="hidden" name="_token" :value="$page.props.csrf_token">

          <div class="flex flex-col flex-wrap items-center justify-center mt-6 space-y-6 overflow-hidden">
            <AppButton
              class="w-2/3 md:w-64 inline-flex items-center justify-center gap-3 shrink"
              type="submit"
            >
              {{ __('auth.email.resend_verification_email') }}
            </AppButton>
          </div>
        </form>
        <!-- END Resend Notification Form -->
      </div>
    </div>
    <!-- /Auth Form -->
  </div>
  <!-- END Page Section -->
</template>
