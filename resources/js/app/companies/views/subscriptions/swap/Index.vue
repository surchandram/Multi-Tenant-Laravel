<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { ref, computed, onMounted, inject } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppModal from '@/components/AppModal.vue';
  import AppValidationErrors from '@/components/AppInputError.vue';
  import AppButton from '@/components/AppButton.vue';
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

  const store = () => {
    form.post(route('companies.subscriptions.swap.store', props.model.company), {
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
          <span class="font-semibold">{{ __('app.labels.swap_subscription') }}</span>
        </h1>
      </div>

      <!-- Aside -->
      <div class="flex items-center gap-3">&nbsp;</div>
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
        <AppInputLabel class="block mb-2">{{ __('app.labels.plan') }}</AppInputLabel>

        <!-- Selected Plan -->
        <template v-if="form.plan">
          <AppPlan :plan="selectedPlan" />

          <p>
            <a
              href="#"
              class="px-1 py-1 rounded text-sm text-indigo-500 font-medium hover:text-indigo-600 focus:ring"
              @click.prevent="form.plan = null"
              >{{ __('app.buttons.change_plan') }}</a
            >
          </p>
        </template>
        <!-- END Selected Plan -->

        <!-- Plans -->
        <template v-else>
          <TabGroup>
            <TabList class="flex space-x-1 p-1">
              <Tab
                v-for="interval in Object.keys(groupedPlans)"
                v-slot="{ selected }"
                :key="interval"
                as="template"
              >
                <button
                  :class="[
                    'px-4 py-2.5 rounded-sm text-sm font-medium leading-5 text-blue-700',
                    'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                    selected ? 'bg-blue-200' : 'text-blue-100 hover:bg-blue-100',
                  ]"
                >
                  {{ interval }}
                </button>
              </Tab>
            </TabList>

            <TabPanels>
              <TabPanel
                v-for="(plans, idx) in groupedPlans"
                :key="idx"
                class="flex flex-col py-2 mb-6 space-y-4"
                :class="[
                  'rounded-xl bg-white p-3',
                  'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]"
              >
                <a
                  v-for="(plan, index) in plans"
                  :key="index"
                  href="#"
                  class="rounded-lg focus:outline-none focus:ring ring-blue-200"
                  @click.prevent="choosePlan(plan)"
                >
                  <AppPlan :plan="plan"></AppPlan>
                </a>
              </TabPanel>
            </TabPanels>
          </TabGroup>
        </template>
        <!-- END Plans -->

        <div class="py-4">
          <form
            action="#"
            @submit.prevent="store"
          >
            <AppValidationErrors :errors="form.errors" />

            <div class="mt-2">
              <AppButton
                type="submit"
                :disabled="form.processing"
              >
                <AppSpinner
                  v-if="form.processing"
                  class="inline-block mr-2"
                  :size="4"
                />
                {{ __('app.buttons.swap_subscription') }}
              </AppButton>
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
