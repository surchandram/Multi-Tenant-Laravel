<script>
  export default {
    pageLayout: 'customer_auth',
  };
</script>

<script setup>
  import { inject } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';

  import AppButton from '@/components/AppButton.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps(['tenant', 'model']);

  const $scrollTo = inject('$scrollTo');

  const form = useForm({
    first_name: props.model.user.first_name,
    last_name: props.model.user.last_name,
    username: props.model.user.username,
    email: props.model.user.email,
    password: '',
    password_confirmation: '',
    terms: false,
  });

  const handleSubmit = () => {
    if (props.model.is_existing_user) {
      form.post(
        route('tenant.customers.portal.auth.login', {
          project: props.model.project.id,
          invitation: props.model.invitation.identifier,
        }),
        {
          onSuccess: () => {
            //
          },
          onError: () => {
            $scrollTo('#formWrapper');
          },
        },
      );
    } else {
      form.post(
        route('tenant.customers.portal.auth.register', {
          project: props.model.project.id,
          invitation: props.model.invitation.identifier,
        }),
        {
          onSuccess: () => {
            //
          },
          onError: () => {
            $scrollTo('#formWrapper');
          },
        },
      );
    }
  };
</script>

<template>
  <Head :title="`Customer Portal - ${$page.props.tenant.name}`" />

  <!-- Page Section -->
  <div class="px-4 py-8 mx-auto space-y-10 lg:space-y-16 lg:px-8 lg:py-12">
    <div class="mx-auto">
      <div class="space-y-3 text-center">
        <h2 class="mb-2 text-3xl font-semibold"><i class="bi bi-kanban"></i> {{ $page.props.tenant.name }}</h2>

        <h3 class="mb-8 text-sm font-medium text-slate-500">
          {{ __('customer.auth.invitation.subtitle') }}
        </h3>
      </div>
    </div>

    <!-- Auth Form -->
    <div class="w-full xl:max-w-lg mx-auto bg-white rounded-md">
      <div class="px-6 py-2 font-semibold bg-slate-200/80 rounded-t-md text-center text-slate-600">
        {{ model.is_existing_user ? __('auth.login') : __('customer.auth.invitation.confirmation_info') }}
      </div>

      <div
        id="formWrapper"
        class="px-6 pt-2 pb-12"
      >
        <!-- Login Form -->
        <form
          v-if="model.is_existing_user"
          action="#"
          @submit.prevent="handleSubmit"
        >
          <div class="mt-4">
            <AppInputLabel
              value="Email Address"
              for="email"
            />

            <AppInput
              id="email"
              v-model="form.email"
              type="email"
              readonly
              class="w-full mt-2"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.email"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              value="Password"
              for="password"
            />

            <AppInput
              id="password"
              v-model="form.password"
              type="password"
              class="w-full mt-2"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.password"
            />
          </div>

          <div class="flex flex-col flex-wrap items-center justify-center mt-6 space-y-6 overflow-hidden">
            <AppButton
              class="inline-flex items-center justify-center gap-3 shrink w-2/3 md:w-48"
              type="submit"
              :disabled="form.processing"
            >
              <AppSpinner v-if="form.processing" />
              {{ __('customer.auth.invitation.access_account_button') }}
            </AppButton>

            <AppButton
              v-if="!form.processing"
              class="shrink w-2/3 md:w-48 text-center"
              :href="route('home')"
              native
            >
              {{ __('customer.auth.invitation.cancel_button') }}
            </AppButton>
          </div>
        </form>
        <!-- END Login Form -->

        <!-- Registration Form -->
        <form
          v-else
          action="#"
          @submit.prevent="handleSubmit"
        >
          <div class="mt-4">
            <AppInputLabel
              value="First name"
              for="first_name"
            />

            <AppInput
              id="first_name"
              v-model="form.first_name"
              class="w-full mt-2"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.first_name"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              value="Last name"
              for="last_name"
            />

            <AppInput
              id="last_name"
              v-model="form.last_name"
              class="w-full mt-2"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.last_name"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              value="Username"
              for="username"
            />

            <AppInputGroup
              start="@"
              text-bg="bg-indigo-300"
              class="mt-2"
            >
              <template #default="{ inputStyles }">
                <AppInput
                  id="username"
                  v-model="form.username"
                  :class="inputStyles"
                  class="w-full"
                />
              </template>
            </AppInputGroup>

            <AppInputError
              class="mt-2"
              :message="form.errors.username"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              value="Email Address"
              for="email"
            />

            <AppInput
              id="email"
              v-model="form.email"
              type="email"
              readonly
              class="w-full mt-2"
            />

            <p class="text-sm font-semibold text-slate-400">
              You can only change this email once you've signed up or request a new link be sent to preferred email.
              <br />
              <br />
              <span class="text-slate-800">
                Note: This email will be used for contact throughout the duration of the project and any related
                services.
              </span>
            </p>

            <AppInputError
              class="mt-2"
              :message="form.errors.email"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              value="Password"
              for="password"
            />

            <AppInput
              id="password"
              v-model="form.password"
              type="password"
              class="w-full mt-2"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.password"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              value="Confirm password"
              for="password_confirmation"
            />

            <AppInput
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              class="w-full mt-2"
            />
          </div>

          <div class="mt-4">
            <AppInputLabel
              for="terms"
              class="inline-flex items-center gap-2"
            >
              <AppCheckbox
                id="terms"
                v-model="form.terms"
              />
              I accept the
              <a
                href="#"
                class="text-blue-500 hover:underline focus:outline-none focus:ring-2"
                @click.prevent
              >
                {{ __('app.labels.tos') }}
              </a>
              and
              <a
                href="#"
                class="text-blue-500 hover:underline focus:outline-none focus:ring-2"
                @click.prevent
              >
                {{ __('app.labels.privacy_policy') }}
              </a>
            </AppInputLabel>

            <AppInputError
              class="mt-2"
              :message="form.errors.terms"
            />
          </div>

          <div class="flex flex-col flex-wrap items-center justify-center mt-6 space-y-6 overflow-hidden">
            <AppButton
              class="inline-flex items-center justify-center gap-3 shrink w-2/3 md:w-48"
              type="submit"
              :disabled="form.processing"
            >
              <AppSpinner v-if="form.processing" />
              {{ __('customer.auth.invitation.setup_account_button') }}
            </AppButton>

            <AppButton
              v-if="!form.processing"
              class="shrink w-2/3 md:w-48 text-center"
              :href="route('home')"
              native
            >
              {{ __('customer.auth.invitation.cancel_button') }}
            </AppButton>
          </div>
        </form>
        <!-- END Registration Form -->
      </div>
    </div>
    <!-- /Auth Form -->
  </div>
  <!-- END Page Section -->
</template>
