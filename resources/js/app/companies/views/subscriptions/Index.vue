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
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppPlan from '@/components/plans/AppPlan.vue';

  const props = defineProps(['model']);

  const stripeCard = ref(null);
  const previewPlan = ref(null);
  const selectedPlan = ref(null);
  var stripe;
  var cardElement;

  const __ = inject('$translate');

  const groupedPlans = computed(() => {
    return _.groupBy(props.model.plans, 'formatted_interval');
  });

  const form = useForm({
    plan: null,
    payment_method: null,
    name: props.model.company.name,
    email: props.model.company.email,
  });

  const choosePlan = (plan) => {
    selectedPlan.value = plan;
    form.plan = plan.id;
  };

  const showPlan = (plan) => {
    previewPlan.value = plan;

    $eventBus.emit('open-modal', 'previewPlanModal');
  };

  const subscriptionPlan = computed(() => {
    const plan = props.model.company.subscription_plan;

    return __('app.subscription.current_plan_info', {
      plan: `<span ref="subscriptionPlanRef" class="text-indigo-600">${plan?.name}</span>`,
    });
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
      createSubscription(setupIntent.payment_method);
    }
  };

  const createSubscription = (paymentMethod) => {
    form.payment_method = paymentMethod;

    form.post(route('companies.subscriptions.store', props.model.company), {
      onSuccess: () => {
        //
      },
    });
  };

  onMounted(() => {
    if (!props.model.company.has_subscription) {
      stripe = Stripe(import.meta.env.VITE_STRIPE_KEY);

      const elements = stripe.elements({
        appearance: {
          theme: 'flat',
        },
      });

      cardElement = elements.create('card');

      cardElement.mount(stripeCard.value);
    }

    $eventBus.on('showPlan', (plan) => {
      showPlan(plan);
    });
  });
</script>

<template>
  <Head :title="`${__('app.labels.billing')} | ${model.company.name}`" />

  <div>
    <!-- heading area -->
    <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-3">
      <!-- Heading -->
      <div class="flex flex-col gap-3 mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
          <span class="font-semibold">{{ __('app.labels.billing') }}</span>
        </h1>

        <p class="text-sm text-slate-700">{{ __('app.labels.manage_company_subscriptions') }}</p>
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3">&nbsp;</div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full py-6">
      <!-- Subscribed Section -->
      <div
        v-if="model.company.has_subscription"
        class="w-full mb-6"
      >
        <h5 class="text-lg font-semibold tracking-wider">{{ __('app.labels.company_subscription') }}</h5>

        <template v-if="model.company.has_active_subscription">
          <!-- Subscription Plan -->
          <a
            href="#"
            @click.prevent="showPlan(model.company.subscription_plan)"
          >
            <p
              class="font-medium mt-4"
              v-html="subscriptionPlan"
            ></p>
          </a>

          <p class="text-sm font-medium mt-4">
            {{
              __('app.subscription.current_plan_usage', {
                count: model.company.users_count,
                limit: model.company.subscription_plan?.team_limit,
              })
            }}
          </p>

          <div class="flex items-baseline gap-6 mt-6">
            <AppButton :href="route('companies.subscriptions.swap.index', model.company)">
              {{ __('app.buttons.swap_subscription_plan') }}
            </AppButton>

            <AppLightButton
              :href="route('companies.subscriptions.cancel.index', model.company)"
              class="bg-red-400 text-white hover:text-slate-100 hover:bg-red-600 focus:bg-red-300 focus:ring focus:ring-red-200"
              plain
            >
              {{ __('app.buttons.cancel_subscription') }}
            </AppLightButton>
          </div>
        </template>
        <!-- END Active Subscription -->

        <div
          v-else
          class="py-6 space-y-4"
        >
          <p class="leading-none text-slate-600">{{ __('app.subscription.in_active') }}</p>

          <div>
            <AppButton :href="route('companies.subscriptions.resume.index', model.company)">
              {{ __('app.buttons.resume_subscription') }}
            </AppButton>
          </div>
        </div>
        <!-- END InActive Subscription -->
      </div>
      <!-- END Subscribed Section -->

      <div
        v-else
        class="flex flex-col py-2 mb-6 space-y-4"
      >
        <template v-if="form.plan">
          <AppPlan :plan="selectedPlan" />

          <p>
            <a
              href="#"
              class="px-4 py-2 rounded text-indigo-500 font-medium hover:bg-indigo-200"
              @click.prevent="form.plan = null"
              >{{ __('app.buttons.change_plan') }}</a
            >
          </p>
        </template>

        <template v-else>
          <div
            v-for="(plans, idx) in groupedPlans"
            :key="idx"
            class="flex flex-col py-2 mb-6 space-y-4"
          >
            <h3 class="text-lg font-medium mb-4">{{ idx }}</h3>
            <a
              v-for="(plan, index) in plans"
              :key="index"
              href="#"
              @click.prevent="choosePlan(plan)"
            >
              <AppPlan :plan="plan"></AppPlan>
            </a>
          </div>
        </template>

        <div class="py-4">
          <form
            action="#"
            @submit.prevent="store"
          >
            <AppValidationErrors :errors="form.errors" />

            <div>
              <AppInputLabel for="name">{{ __('app.labels.name') }}</AppInputLabel>

              <AppInput
                id="name"
                v-model="form.name"
                class="w-full mt-2"
              />
            </div>

            <div class="mt-4">
              <AppInputLabel for="email">{{ __('app.labels.email') }}</AppInputLabel>

              <AppInput
                id="email"
                v-model="form.email"
                type="email"
                class="w-full mt-2"
              />
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
                {{ __('app.buttons.pay') }}
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
