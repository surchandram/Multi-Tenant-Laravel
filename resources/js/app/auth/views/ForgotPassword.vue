<script>
  export default {
    pageLayout: "guest",
  };
</script>

<script setup>
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AuthSessionStatus from "@/components/AuthSessionStatus.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AuthSection from "./partials/AuthSection.vue"
  import {inject} from "vue";

  const __ = inject('$translate')

  const form = useForm({
    email: "",
  });

  const submit = () => {
    form.clearErrors();

    form.post(route('password.email'), {
      onError: () => {
        //TODO: Do something
      },
    });
  };
</script>

<template>
  <Head title="Forgot Password" />
  <AuthSection>
    <div>
      <Link class="inline-flex items-center" :href="route('home')">
        <img class="" src="/logos/cyber_hawk_logo.svg" alt="logo"/>
      </Link>

      <h4 class="font-inter text-3xl lg:text-5xl text-black font-bold mb-3">{{ __('app.labels.forgot_password_title') }}</h4>
      <p class="text-base font-medium text-black mb-8">{{ __('app.labels.forgot_password_text') }}</p>

      <AuthSessionStatus v-if="$page.props.flash.status" class="mb-4"/>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label for="email" class="font-semibold block mb-2">{{ __('app.labels.email') }}</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            :class="{'border-red-600': form.errors.email}"
            required
            autofocus
            autocomplete="email"
            :placeholder="__('app.labels.email_placeholder')"
          />
          <AppInputError :message="form.errors.email"/>
        </div>

        <div class="mt-4">
          <div class="mb-2">
            <button
              class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 mb-6 w-full px-6 py-2.5
                      bg-slate-800 text-white font-semibold text-base leading-tight rounded shadow-md hover:bg-slate-700 hover:shadow-lg
                      focus:bg-slate-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-slate-800 active:shadow-lg
                      transition duration-150 ease-in-out disabled:opacity-25"
              :class="{ 'opacity-25': form.processing }"
              type="submit"
              :disabled="form.processing">
              {{ __('app.labels.email_password_reset_link') }}
            </button>
          </div>
        </div>
      </form>

      <p class="text-base font-medium text-black">{{ __('app.labels.no_need_to_reset_pwd') }} <Link :href="route('login')" class="underline underline-offset-4 text-blue-600 font-semibold">{{ __('app.labels.login') }}</Link></p>
    </div>
  </AuthSection>
</template>
