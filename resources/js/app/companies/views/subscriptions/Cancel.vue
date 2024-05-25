<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { computed, onMounted, inject } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppModal from '@/components/AppModal.vue';
  import AppValidationErrors from '@/components/AppInputError.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps(['model']);

  const __ = inject('$translate');

  const form = useForm({
    password: null,
  });

  const subscriptionPlan = computed(() => {
    const plan = props.model.company.subscription_plan;

    return __('app.subscription.current_plan_info', {
      plan: `<span ref="subscriptionPlanRef" class="text-indigo-600">${plan?.name}</span>`,
    });
  });

  const store = () => {
    form.post(route('companies.subscriptions.cancel.store', props.model.company), {
      onSuccess: () => {
        //
      },
    });
  };

  onMounted(() => {
    //
  });
</script>

<template>
  <Head :title="`${__('app.labels.cancel_subscription')} | ${model.company.name}`" />

  <div>
    <!-- heading area -->
    <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-3">
      <!-- Heading -->
      <div class="flex flex-col gap-3 mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
          <span class="font-semibold">{{ __('app.labels.cancel_subscription') }}</span>
        </h1>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full py-6">
      <!-- Current Plan -->
      <p
        class="px-2 py-2 mb-4 border-l-4 border-indigo-500 bg-slate-100"
        v-html="subscriptionPlan"
      ></p>
      <!-- END Current Plan -->

      <!-- Form Section -->
      <div class="flex flex-col py-2 mb-6 space-y-4">
        <div class="py-4">
          <form
            action="#"
            @submit.prevent="store"
          >
            <AppValidationErrors :errors="form.errors" />

            <div>
              <AppInputLabel
                for="password"
                class="block mb-2"
                >{{ __('app.labels.action_requires_password') }}</AppInputLabel
              >

              <AppInput
                id="password"
                v-model="form.password"
                type="password"
                class="w-full mt-2"
              />

              <AppInputError
                :message="form.errors.password"
                class="mt-2"
              />
            </div>

            <div class="flex justify-end gap-3 mt-6">
              <AppButton
                type="submit"
                class="inline-flex items-center gap-2 bg-red-600 text-white hover:bg-opacity-90 focus:bg-opacity-90 focus:ring focus:ring-red-200"
                :disabled="form.processing"
                plain
              >
                <AppSpinner
                  v-if="form.processing"
                  :size="4"
                />
                {{ __('app.buttons.confirm_cancel_subscription') }}
              </AppButton>

              <AppLightButton
                :href="route('companies.subscriptions.index', model.company)"
                :disabled="form.processing"
              >
                {{ __('app.buttons.prevent_cancel_subscription') }}
              </AppLightButton>
            </div>
          </form>
        </div>
      </div>
      <!-- END Form Section -->
    </div>
  </div>

  <AppModal id="previewPlanModal">
    <template #header>
      <h4 class="text-medium">{{ previewPlan.name }}</h4>
    </template>

    <div class="space-y-3">
      <p class="text-lg text-slate-600 font-semibold">
        <span>{{ previewPlan.formatted_price }} / {{ previewPlan.formatted_interval }}</span>
      </p>

      <p class="font-medium">
        {{ previewPlan.per_seat ? 'Charged: ' : 'Users limit: ' }}
        <span class="text-sm text-slate-800">{{
          previewPlan.per_seat ? 'Per User' : previewPlan.team_limit + ' users'
        }}</span>
      </p>

      <h5 class="font-medium mb-5">Features</h5>

      <div class="bg-slate-50">
        <div
          v-for="(feature, index) in previewPlan.features"
          :key="index"
          class="grid grid-cols-2 gap-3 px-4 py-2 first:border-transparent border-t"
        >
          <h5 class="font-medium text-slate-600">{{ feature.feature.name }}</h5>
          <p class="font-semibold text-indigo-600">{{ feature.limit }}</p>
        </div>
      </div>
    </div>
  </AppModal>
</template>
