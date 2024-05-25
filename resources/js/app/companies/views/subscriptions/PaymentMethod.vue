<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { ref, computed, onMounted, inject } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppModal from '@/components/AppModal.vue';
  import AppValidationErrors from '@/components/AppInputError.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppPlan from '@/components/plans/AppPlan.vue';

  const props = defineProps(['model']);

  const stripeCard = ref(null);
  const previewPlan = ref(null);
  var stripe;
  var cardElement;

  const __ = inject('$translate');

  const currentCard = computed(() => {
    return __('app.subscription.current_card_info', {
      type: `<span class="text-indigo-500">${props.model.card_type}</span>`,
      last_four: `<span class="text-indigo-500">${props.model.last_four}</span>`,
    });
  });

  const form = useForm({
    payment_method: null,
  });

  const store = async () => {
    form.processing = true;

    const { setupIntent, error } = await stripe.confirmCardSetup(props.model.setup_intent, {
      payment_method: {
        card: cardElement,
        billing_details: {
          name: form.name,
          email: form.email,
        },
      },
    });

    if (error) {
      console.log(error);
      form.processing = false;
    } else {
      updatePaymentMethod(setupIntent.payment_method);
    }
  };

  const updatePaymentMethod = (paymentMethod) => {
    form.payment_method = paymentMethod;

    form.post(route('companies.subscriptions.payment-methods.store', props.model.company), {
      onSuccess: () => {
        //
      },
    });
  };

  onMounted(() => {
    stripe = Stripe(import.meta.env.VITE_STRIPE_KEY);

    const elements = stripe.elements({
      appearance: {
        theme: 'flat',
      },
    });

    cardElement = elements.create('card');

    cardElement.mount(stripeCard.value);
  });
</script>

<template>
  <Head :title="`${__('app.labels.update_card')} | ${model.company.name}`" />

  <div>
    <!-- heading area -->
    <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-3">
      <!-- Heading -->
      <div class="flex flex-col gap-3 mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
          <span class="font-semibold">{{ __('app.labels.update_card') }}</span>
        </h1>
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3">&nbsp;</div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full">
      <div class="flex flex-col py-2 mb-6 space-y-4">
        <div class="py-4">
          <form
            action="#"
            @submit.prevent="store"
          >
            <AppValidationErrors :errors="form.errors" />

            <div>
              <p
                class="font-medium"
                v-html="currentCard"
              ></p>
            </div>

            <div class="mt-4 mb-6">
              <AppInputLabel>{{ __('app.labels.card') }}</AppInputLabel>
            </div>

            <div>
              <div
                id="card"
                ref="stripeCard"
              >
                <!-- stripe -->
              </div>
            </div>

            <div class="mt-8">
              <AppButton
                type="submit"
                :disabled="form.processing"
              >
                <AppSpinner
                  v-if="form.processing"
                  class="inline-block mr-2"
                  :size="4"
                />
                {{ __('app.buttons.update') }}
              </AppButton>
            </div>
          </form>
        </div>
      </div>
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
