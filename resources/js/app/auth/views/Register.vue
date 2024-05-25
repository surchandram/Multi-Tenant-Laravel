<script>
  export default {
    pageLayout: 'guest',
  };
</script>

<script setup>
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import AppInputError from '@/components/AppInputError.vue';
  import GoogleIcon from '@/assets/icons/GoogleIcon.vue';
  import { inject } from 'vue';

  const __ = inject('$translate');
  const date = new Date().getFullYear();

  const props = defineProps(['form']);

  const form = useForm({
    first_name: props.form?.first_name || '',
    last_name: props.form?.last_name || '',
    username: props.form?.username || '',
    email: props.form?.email || '',
    password: '',
    password_confirmation: '',
    terms: false,
  });

  const register = () => {
    form.post(route('register'), {
      onError: () => {
        form.reset('password', 'password_confirmation');
      },
    });
  };
</script>

<template>
  <Head title="Register" />

  <div class="lg:h-screen flex flex-col bg-white">
    <div class="w-full h-full">
      <div class="grid grid-cols-1 lg:grid-cols-2 h-full">
        <div class="flex justify-center h-full">
          <div class="py-10 lg:py-20 lg:w-1/2 px-5 lg:px-0 flex flex-col justify-between">
            <div>
              <div>
                <Link
                  class="inline-flex items-center"
                  :href="route('home')"
                >
                  <img
                    class=""
                    src="/logos/cyber_hawk_logo.svg"
                    alt="logo"
                  />
                </Link>

                <h4 class="font-inter text-3xl lg:text-5xl text-black font-bold mb-6">
                  {{ __('app.labels.register_alt') }}
                </h4>
                <p class="text-base font-medium text-black mb-8">
                  {{ __('app.labels.login_question', { name: $page.props.appName }) }}
                  <Link
                    :href="route('login')"
                    class="underline underline-offset-4 text-blue-600 font-semibold"
                    >{{ __('app.labels.login') }}</Link
                  >
                </p>
              </div>

              <form @submit.prevent="register">
                <div>
                  <label
                    for="first_name"
                    class="font-semibold block mb-2"
                    >{{ __('app.labels.first_name') }}</label
                  >
                  <input
                    id="first_name"
                    v-model="form.first_name"
                    type="text"
                    class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :class="{ 'border-red-600': form.errors.first_name }"
                    autofocus
                    :placeholder="__('app.labels.first_name_placeholder')"
                    autocomplete="name"
                  />
                  <AppInputError :message="form.errors.first_name" />
                </div>

                <div class="mt-4">
                  <label
                    for="last_name"
                    class="font-semibold block mb-2"
                    >{{ __('app.labels.last_name') }}</label
                  >
                  <input
                    id="last_name"
                    v-model="form.last_name"
                    type="text"
                    class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :class="{ 'border-red-600': form.errors.last_name }"
                    autofocus
                    :placeholder="__('app.labels.last_name_placeholder')"
                    autocomplete="name"
                  />
                  <AppInputError :message="form.errors.last_name" />
                </div>

                <div class="mt-4">
                  <label
                    for="username"
                    class="font-semibold block mb-2"
                    >{{ __('app.labels.username') }}</label
                  >
                  <input
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :class="{ 'border-red-600': form.errors.username }"
                    autofocus
                    :placeholder="__('app.labels.username_placeholder')"
                    autocomplete="name"
                  />
                  <AppInputError :message="form.errors.username" />
                </div>

                <div class="mt-4">
                  <label
                    for="email"
                    class="font-semibold block mb-2"
                    >{{ __('app.labels.email') }}</label
                  >
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :class="{ 'border-red-600': form.errors.email }"
                    required
                    autofocus
                    autocomplete="email"
                    :placeholder="__('app.labels.email_placeholder')"
                  />
                  <AppInputError :message="form.errors.email" />
                </div>

                <div class="mt-4">
                  <label
                    for="password"
                    class="font-semibold block mb-2"
                    >{{ __('app.labels.password') }}</label
                  >
                  <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :class="{ 'border-red-600': form.errors.password }"
                    required
                    autocomplete="current-password"
                    :placeholder="__('app.labels.enter_password')"
                  />
                  <AppInputError :message="form.errors.password" />
                </div>

                <div class="mt-4">
                  <label
                    for="password_confirmation"
                    class="font-semibold block mb-2"
                    >{{ __('app.labels.confirm_password') }}</label
                  >
                  <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control block w-full px-3 py-3 mb-1 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :class="{ 'border-red-600': form.errors.password_confirmation }"
                    required
                    autocomplete="current-password_confirmation"
                    :placeholder="__('app.labels.confirm_password')"
                  />
                  <AppInputError :message="form.errors.password_confirmation" />
                </div>

                <div class="mt-4">
                  <label class="">
                    <input
                      v-model="form.terms"
                      :checked="form.terms"
                      :value="true"
                      name="terms"
                      type="checkbox"
                      class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer"
                    />
                    <span class="ml-2 text-base font-medium text-black">{{
                      __('app.labels.terms_and_conditions_text')
                    }}</span>
                  </label>
                </div>

                <div class="mt-16 mb-6">
                  <button
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 mb-6 w-full px-6 py-2.5 bg-slate-800 text-white font-semibold text-base leading-tight rounded shadow-md hover:bg-slate-700 hover:shadow-lg focus:bg-slate-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-slate-800 active:shadow-lg transition duration-150 ease-in-out disabled:opacity-25"
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                  >
                    {{ __('app.labels.register_alt') }}
                  </button>
                </div>
              </form>

              <div class="mt-10">
                <div class="flex items-center gap-x-4">
                  <div class="border-b-2 border-gray-200 grow"></div>
                  <span class="text-base text-black font-medium uppercase hidden lg:flex">Or</span>
                  <span class="text-sm text-black font-medium lg:hidden">{{
                    __('app.labels.social_account_cta')
                  }}</span>
                  <div class="border-b-2 border-gray-200 grow"></div>
                </div>
              </div>

              <div class="mt-11 lg:mt-8">
                <p class="text-base text-black font-medium m-0 hidden lg:block">
                  {{ __('app.labels.social_account_cta') }}
                </p>

                <div class="w-full mt-3">
                  <a
                    class="bg-slate-50 border border-gray-300 text-sm text-gray-700 font-bold p-4 flex items-center gap-x-2 w-max-content"
                    :href="route('login.social', { provider: 'google' })"
                  >
                    <google-icon />
                    {{ __('app.labels.google_sign_in') }}
                  </a>
                </div>
              </div>
            </div>

            <div class="pt-12">
              <p class="text-sm text-black font-medium mb-3 text-center lg:text-start">
                Copyright © {{ date }} {{ $page.props.appName }}. All Rights Reserved.
              </p>

              <p class="text-sm text-black font-medium m-0">
                <a
                  class="text-gray-700 underline"
                  :href="route('terms.show')"
                  target="_blank"
                >
                  Terms and Conditions
                </a>
                and
                <a
                  class="text-gray-700 underline"
                  :href="route('policy.show')"
                  target="_blank"
                >
                  Privacy Policy
                </a>
              </p>
            </div>
          </div>
        </div>

        <div class="hidden lg:block register-gradient">
          <div
            class="bg-[url('/images/auth/register-banner.jpg')] justify-between bg-cover bg-no-repeat bg-center h-full"
          >
            <div class="h-full w-full lg:flex flex-col bg-gradient-to-t from-gray-600 to-transparent"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
  .register-gradient {
    background: rgba(0, 0, 0, 0.1);
  }
</style>
