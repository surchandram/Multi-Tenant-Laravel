<script>
  export default {
    pageLayout: "customer_auth",
  };
</script>

<script setup>
  import { inject } from "vue";
  import { Head } from "@inertiajs/vue3";
  import LoginForm from "@/components/customer/auth/LoginForm.vue";

  defineProps(["tenant"]);

  const $scrollTo = inject("$scrollTo");

  const handleSubmit = () => {
    $scrollTo("#formWrapper");
  };
</script>

<template>
  <Head :title="`${__('customer.labels.customer_portal')} | ${$page.props.tenant.name}`" />

  <!-- Page Section -->
  <div class="px-4 py-8 mx-auto space-y-10 lg:space-y-16 lg:px-8 lg:py-12">
    <div class="mx-auto">
      <div class="space-y-3 text-center">
        <h2 class="inline-flex items-center mb-2 text-3xl font-semibold">
          <img :src="$page.props.tenant.logo" alt class="inline w-16 h-16 mr-2" />
          {{ $page.props.tenant.name }}
        </h2>

        <h3
          class="mb-8 text-sm font-medium text-slate-500"
        >{{ __('customer.auth.invitation.subtitle') }}</h3>
      </div>
    </div>

    <!-- Auth Form -->
    <div class="w-full xl:max-w-lg mx-auto bg-white rounded-md">
      <div
        class="px-6 py-2 font-semibold bg-slate-200/80 rounded-t-md text-center text-slate-600"
      >{{ __('auth.login') }}</div>

      <div id="formWrapper" class="px-6 pt-2 pb-12">
        <LoginForm @submit-error="handleSubmit" />
      </div>
    </div>
    <!-- /Auth Form -->
  </div>
  <!-- END Page Section -->
</template>
