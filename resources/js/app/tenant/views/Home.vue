<script>
  export default {
    pageLayout: "tenant",
  };
</script>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import LoginForm from "../../../components/customer/auth/LoginForm.vue";

  defineProps(["tenant", "model"]);
</script>

<template>
  <Head :title="`${$page.props.tenant.name}`" />

  <div class="min-w-full min-h-screen">
    <!-- Topbar -->
    <div class="bg-slate-200">
      <div
        v-if="!$page.props.auth.loggedIn"
        class="min-w-full flex items-center justify-center lg:justify-start gap-1 pt-3 pb-3 px-8 lg:px-12"
      >
        <!-- Left Topbar -->
        <div class="mr-auto">
          <a :href="route('tenant.index')" class="inline-flex items-center gap-3">
            <img :src="$page.props.tenant.logo" alt class="inline w-8" />
            <h4 class="text-sm font-semibold text-slate-600">{{ $page.props.tenant.name }}</h4>
          </a>
        </div>

        <!-- END Left Topbar -->
        <div class="flex items-center lg:ml-auto font-medium">
          <AppButton
            v-if="!$page.props.auth.loggedIn"
            :href="route('login', { redirect_to: route('tenant.switch', $page.props.tenant) })"
            theme="outline-info"
            native
          >{{ __('app.labels.login') }}</AppButton>
        </div>
      </div>
    </div>
    <!-- END Topbar -->

    <!-- Navbar -->
    <div v-if="$page.props.auth.loggedIn" class="min-w-full bg-white">
      <div
        class="min-w-full flex flex-col lg:flex-row items-center justify-between lg:justify-start gap-4 lg:gap-1 py-4 px-8 lg:px-12"
      >
        <!-- Left Navbar -->
        <div class="flex items-center lg:mr-auto">
          <!-- Logo -->
          <a :href="route('tenant.index')">
            <img class="w-16 h-16" :src="$page.props.tenant.logo" alt />
          </a>
        </div>

        <!-- Right Navbar -->
        <div
          class="w-full lg:w-auto flex items-center justify-center lg:justify-end gap-3 lg:gap-4 py-2"
        >
          <template v-if="$page.props.auth.loggedIn">
            <AppButton
              v-if="model.can.browse_tenant_dashboard"
              :href="route('tenant.home')"
            >{{ __('app.labels.dashboard') }}</AppButton>

            <div>
              <img class="w-10 h-10 rounded-full" :src="$page.props.auth.user.avatar" alt />
            </div>
          </template>

          <template v-else>
            <div>
              <AppButton :href="route('login')" theme="outline">{{ __('app.labels.login') }}</AppButton>
            </div>
          </template>
        </div>
        <!-- END Right Navbar -->
      </div>
    </div>
    <!-- END Navbar -->

    <!-- Hero -->
    <div class="bg-slate-100 flex flex-col justify-start">
      <div class="container grid grid-cols-1 md:grid-cols-5 gap-6 px-8 xl:px-0 py-16 mx-auto">
        <!-- Left Section -->
        <div
          :class="[
            $page.props.auth.loggedIn ? 'bg-white/80' : 'bg-white'
          ]"
          class="flex flex-col justify-center col-span-full md:col-span-3 -mx-8 md:mx-auto md:mb-auto lg:mx-0 space-y-8 md:bg-transparent"
        >
          <div class="min-w-full md:px-8 py-12 space-y-8 text-center">
            <h1
              class="text-3xl md:text-5xl text-slate-700 font-medium"
            >{{ __('customer.labels.track_job_progress') }}</h1>

            <div class="px-4">
              <hr class="border-slate-200" />
            </div>

            <div
              class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm font-medium whitespace-break-spaces"
            >
              <div class="col-span-1 px-2 py-4 md:border-r border-slate-300 last:border-r-0">
                <h4 class="text-base lg:text-lg">{{ __('customer.labels.schedule_job') }}</h4>
              </div>

              <div class="col-span-1 px-2 py-4 md:border-r border-slate-300 last:border-r-0">
                <h4 class="text-base lg:text-lg">{{ __('customer.labels.sign_documents') }}</h4>
              </div>

              <div class="col-span-1 px-2 py-4 md:border-r border-slate-300 last:border-r-0">
                <h4 class="text-base lg:text-lg">{{ __('customer.labels.get_work_report') }}</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div
          class="col-span-full md:col-span-2 min-w-0 container max-w-lg order-first md:order-last p-7 mx-auto my-auto rounded-md shadow-md bg-slate-50 text-slate-600"
        >
          <!-- Guest -->
          <div v-if="!$page.props.auth.loggedIn" class="space-y-8">
            <h3 class="text-lg font-medium">{{ __('customer.auth.invitation.subtitle') }}</h3>

            <LoginForm />
          </div>
          <!-- END Guest -->

          <!-- Authenticated -->
          <div v-else class="flex flex-col items-center justify-center lg:mx-auto space-y-8">
            <div class="-mx-7 -mt-7 rounded-t max-h-80 overflow-hidden">
              <img
                v-if="model.is_verified_customer"
                class="min-w-full hidden md:block rounded-t aspect-square hover:scale-[1.75] hover:origin-[20%_75%]"
                :src="model.images.restore"
                alt
              />
            </div>

            <div class="inline-block text-sm font-semibold">
              <template v-if="model.is_verified_customer">
                <p>{{ __('tenant.greeting', { name: $page.props.auth.user.name }) }}</p>

                <br />
                <AppButton
                  :href="route('tenant.customers.portal.dashboard')"
                  theme="outline"
                  class="inline-flex items-center"
                >
                  {{ __('app.labels.view') }}
                  {{ __('app.labels.dashboard') }}
                  <i
                    class="bi bi-arrow-right ml-2"
                  ></i>
                </AppButton>
              </template>

              <template v-if="model.can.browse_tenant_dashboard">
                <p>{{ __('tenant.greeting', { name: $page.props.auth.user.name }) }}</p>

                <br />
                <AppButton
                  :href="route('tenant.home')"
                  theme="outline"
                  class="inline-flex items-center"
                >
                  {{ __('app.labels.view') }}
                  {{ __('app.labels.dashboard') }}
                  <i
                    class="bi bi-arrow-right ml-2"
                  ></i>
                </AppButton>
              </template>
            </div>
          </div>
        </div>
        <!-- END Right Section -->
      </div>
    </div>
    <!-- END Hero -->
  </div>
</template>
