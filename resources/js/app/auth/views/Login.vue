<script>
  export default {
    pageLayout: "guest",
  };
</script>

<script setup>
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AppInputError from "@/components/AppInputError.vue";
  import GoogleIcon from "@/assets/icons/GoogleIcon.vue"
  import AuthSection from "./partials/AuthSection.vue"
  import {inject} from "vue";

  const __ = inject('$translate')

  const form = useForm({
    email: "",
    password: "",
    remember: false,
  });

  const submit = () => {
    form.clearErrors();
    form.post(route("login"), {
      onError: () => {
        form.reset("password");
      },
    });
  };
</script>

<template>
  <Head title="Login"/>

  <AuthSection>
    <div>
      <Link class="inline-flex items-center" :href="route('home')">
        <img class="" src="/logos/cyber_hawk_logo.svg" alt="logo"/>
      </Link>

      <h4 class="font-inter text-3xl lg:text-5xl text-black font-bold mb-3">{{ __('app.labels.login_alt') }}</h4>
      <p class="text-base font-medium text-black mb-8">{{ __('app.labels.register_question', {name: $page.props.appName}) }} <Link :href="route('register')" class="underline underline-offset-4 text-blue-600 font-semibold">{{ __('app.labels.register_cta') }}</Link></p>
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

        <div>
          <label for="password" class="font-semibold block mb-2">{{ __('app.labels.password') }}</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            :class="{'border-red-600': form.errors.password}"
            required
            autocomplete="current-password"
            :placeholder="__('app.labels.enter_password')"
          />
          <AppInputError :message="form.errors.password" />
        </div>

        <div class="flex items-center justify-between my-6">
          <label class="flex items-center">
            <input v-model="form.remember" :checked="form.remember" :value="true" name="remember" type="checkbox"
                   class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer"/>
            <span class="ml-2 text-base font-medium text-black">{{ __('app.labels.remember') }}</span>
          </label>
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
              {{ __('app.labels.login') }}
            </button>
          </div>

          <Link :href="route('password.request')" class="text-base font-medium text-black underline underline-offset-4">
            {{ __('app.labels.forgot_password') }}
          </Link>
        </div>
      </form>

      <div class="mt-10">
        <div class="flex items-center gap-x-4">
          <div class="border-b-2 border-gray-200 grow"></div>
          <span class="text-base text-black font-medium uppercase hidden lg:flex">Or</span>
          <span class="text-sm text-black font-medium lg:hidden">{{ __('app.labels.social_account_cta') }}</span>
          <div class="border-b-2 border-gray-200 grow"></div>
        </div>
      </div>

      <div class="mt-11 lg:mt-8">
        <p class="text-base text-black font-medium m-0 hidden lg:block">{{ __('app.labels.social_account_cta') }}</p>

        <div class="w-full mt-3">
          <a class="bg-slate-50 border border-gray-300 text-sm text-gray-700 font-bold p-4 flex items-center gap-x-2 w-max-content" :href="route('login.social', {provider: 'google'})">
            <google-icon/>
            {{ __('app.labels.google_sign_in') }}
          </a>
        </div>
      </div>
    </div>
  </AuthSection>
</template>
