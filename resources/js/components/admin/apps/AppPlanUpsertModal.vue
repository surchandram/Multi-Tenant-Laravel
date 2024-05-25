<script setup>
  import { useSlots, toRefs, onMounted, watch, ref, computed } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import AppModal from "@/components/AppModal.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputGroup from "@/components/AppInputGroup.vue";
  import AppCheckbox from "@/components/AppCheckbox.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppLightButton from "@/components/AppLightButton.vue";

  const props = defineProps({
    plan: {
      type: Object,
      required: false,
      default: function () {
        return {};
      }
    },
    features: {
      type: Array,
      required: false,
      default: function () {
        return [];
      }
    },
  });

  const { plan, features } = toRefs(props);

  const emit = defineEmits([
    'app-plan:added',
    'app-plan:edited',
  ]);

  const form = useForm({
    id: "",
    name: "",
    provider_id: "",
    price: null,
    description: "",
    usable: true,
    interval: null,
    teams: true,
    per_seat: true,
    is_unlimited: true,
    features: [],
  });

  const editing = ref(false);

  const slots = useSlots();

  const formatted_price = computed(
    () => currencyFormatter(form.price, { fromCents: true }).format()
  );

  const planFeatures = ref([]);
  const modalRef = ref(null);

  onMounted(() => {

    // listen for 'edit' event
    $eventBus.on('app-plan:edit', function (plan) {
      Object.keys(form.data()).forEach((key) => {
        form[key] = plan[key];
      });

      // setup modal
      if (plan.features?.length > 0) {
        planFeatures.value = _.map(plan.features, 'key')
      }

      editing.value = true;

      modalRef.value.show();
    });

    setTimeout(() => {
      watch(() => modalRef.value?.isOpen, (val) => {
        if (val == false) {
          form.reset();
          editing.value = false;
        }
      });
    }, 500);

    watch(() => form.is_unlimited, (val) => {
      form.limit = val == true ? null : 1;
    });

    watch(() => _.cloneDeep(planFeatures.value), (current, old) => {
      if (current.length <= 0) {
        form.features = [];
        return;
      }

      buildPlanFeatures(current, old);
    });

    watch(() => form.name, (val) => {
      form.provider_id = window.slugify(form.name, {
        lower: true
      });
    });

    if (typeof props.plan === 'undefined') {
      form.id = '_' + Date.now();
    }
  });

  const buildPlanFeatures = (current, old) => {
    const keys = _.map(form.features, ['key']);

    var collection = current.filter((c) => !_.includes(keys, c));

    form.features = _.map(collection, makeFeature);
  };

  const makeFeature = (feature) => {
    var data = {};
    const featureData = _.find(features.value, (f) => f.key == feature);

    data['id'] = featureData?.id;
    data['name'] = featureData?.name;
    data['key'] = feature;
    data['is_unlimited'] = true;
    data['default'] = false;
    data['limit'] = 0;

    return data;
  };

  const store = () => {
    form.clearErrors();
    form.processing =  true;

    if (_.isEmpty(form.id)) {
      form.id = '_' + Date.now();
    }

    const data = form.data();

    if (!form.name || !form.provider_id || !form.price) {
      form.processing =  false;

      // name error
      if (!form.name) {
        form.setError('name', 'Name is required.')
      }

      // provider_id error
      if (!form.provider_id) {
        form.setError('provider_id', 'Provider id is required.')
      }

      // price error
      if (!form.price) {
        form.setError('price', 'Price is required.')
      }

      return;
    }

    if (!editing.value) {
      emit('app-plan:added', data);
    }
    else {
      emit('app-plan:edited', data);
    }

    form.reset();

    editing.value = false;
    planFeatures.value = [];

    setTimeout(() => {
      form.processing =  false;
      modalRef.value.hide();
    });
  };
</script>

<template>
  <!-- Card Item Start -->
  <div class="w-full">
    <AppModal
      id="planCreateModal"
      ref="modalRef"
      close-label="Cancel"
      submit
      :submit-label="editing ? 'Update' : 'Add'"
      :submit-callback="store"
    >
      <template #header>Add billing plan</template>

      <form action="#" @submit.prevent="store">
        <AppValidationErrors :errors="form.errors" />

        <!-- Live -->
        <div class="mt-4">
          <AppInputLabel for="plan_usable" class="inline-flex items-center gap-3">
            <AppCheckbox
              id="plan_usable"
              v-model="form.usable"
              class="pl-0 pr-0"
              name="usable"
              value="1"
            />
            Live
          </AppInputLabel>

          <AppInputError class="mt-2" :message="form.errors.usable" />
        </div>

        <!-- Name -->
        <div class="mt-4">
          <AppInputLabel for="plan_name">Name</AppInputLabel>

          <AppInput
            id="plan_name"
            v-model="form.name"
            class="w-full mt-2"
            name="name"
          />

          <AppInputError class="mt-2" :message="form.errors.name" />
        </div>

        <!-- Key -->
        <div class="mt-4">
          <AppInputLabel for="plan_provider_id">Provider Key</AppInputLabel>

          <AppInput
            id="plan_provider_id"
            v-model="form.provider_id"
            class="w-full mt-2"
            name="provider_id"
            placeholder="eg. monthly_25, yearly_100"
          />

          <AppInputError class="mt-2" :message="form.errors.provider_id" />
        </div>

        <!-- Per Seat -->
        <div class="mt-4">
          <AppInputLabel for="plan_per_seat" class="inline-flex items-center gap-3">
            <AppCheckbox
              id="plan_per_seat"
              v-model="form.per_seat"
              class="pl-0 pr-0"
              name="per_seat"
              value="1"
            />
            Per Seat
          </AppInputLabel>

          <AppInputError class="mt-2" :message="form.errors.per_seat" />
        </div>

        <!-- Price -->
        <div class="mt-4">
          <AppInputLabel for="plan_price">Price</AppInputLabel>

          <AppInputGroup custom>
            <AppInput
              type="number"
              min="1"
              id="plan_price"
              v-model="form.price"
              class="w-full rounded-r-none"
              name="price"
            />

            <template #end>
              <div class="w-24 h-full inline-flex items-center justify-center px-2 py-1 text-sm font-semibold bg-slate-100 rounded rounded-l-none">
                {{ formatted_price }}
              </div>
            </template>
          </AppInputGroup>

          <AppInputError class="mt-2" :message="form.errors.price" />
        </div>

        <!-- Features -->
        <div v-if="features.length" class="mt-4">
          <AppInputLabel for="plan_features">Features</AppInputLabel>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-2 mt-2">
            <AppInputLabel
              v-for="feature in features"
              :key="feature.key"
              class="inline-flex items-center gap-2"
            >
              <AppCheckbox
                id="plan_features"
                v-model="planFeatures"
                class=""
                name="features"
                :value="feature.key"
              />
              {{ feature.name }}
            </AppInputLabel>
          </div>

          <AppInputError class="mt-2" :message="form.errors.features" />
        </div>

        <div v-if="form.features.length" class="flex flex-col mt-4">
          <p class="text-sm text-slate-400">Customize</p>
          <!-- Feature -->
          <div class="flex flex-col gap-4" :key="feature.id" v-for="(feature, index) in form.features">
            <div class="grid grid-cols-3 gap-8 mt-4">
              <!-- Name -->
              <div
                class="flex items-center col-span-full md:col-span-1 px-4 py-2 border-2 border-dotted border-indigo-800"
              >
                {{ feature.name }}
              </div>

              <!-- Unlimted -->
              <div
                class="flex items-center col-span-full md:col-span-1 px-4 py-2 border border-dotted border-indigo-800"
              >
                <div>
                  <AppInputLabel
                    :for="`${feature.id}_plan_feature_is_unlimited`"
                    class="inline-flex items-center gap-3"
                  >
                    <AppCheckbox
                      :id="`${feature.id}_plan_feature_is_unlimited`"
                      v-model="form.features[index].is_unlimited"
                      class="pl-0 pr-0"
                      name="is_unlimited"
                      value="1"
                    />
                    Unlimited
                  </AppInputLabel>

                  <AppInputError class="mt-2" :message="form.errors.is_unlimited" />
                </div>
              </div>

              <!-- Limit -->
              <div
                v-if="!form.features[index].is_unlimited"
                class="flex items-center col-span-full md:col-span-1 px-4 py-2 border border-dotted border-indigo-800"
              >
                <div>
                  <AppInputLabel
                    :for="`${feature.id}_plan_feature_limit`"
                  >
                    Limit
                  </AppInputLabel>

                  <AppInput
                    :id="`${feature.id}_plan_feature_limit`"
                    v-model="form.features[index].limit"
                    type="number"
                    min="1"
                    class="w-full mt-2"
                    name="limit"
                  />

                  <AppInputError class="mt-2" :message="form.errors.limit" />
                </div>
              </div>
            </div>
          </div>
          <!-- /Feature -->
        </div>

        <!-- Unlimted -->
        <div class="mt-4">
          <AppInputLabel for="plan_feature_is_unlimited" class="inline-flex items-center gap-3">
            <AppCheckbox
              id="plan_feature_is_unlimited"
              v-model="form.is_unlimited"
              class="pl-0 pr-0"
              name="is_unlimited"
              value="1"
            />
            Unlimited
          </AppInputLabel>

          <AppInputError class="mt-2" :message="form.errors.is_unlimited" />
        </div>

        <!-- Limit -->
        <div v-if="!form.is_unlimited" class="mt-4">
          <AppInputLabel for="plan_feature_limit">Limit</AppInputLabel>

          <AppInput
            type="number"
            min="1"
            id="plan_feature_limit"
            v-model="form.limit"
            class="w-full mt-2"
            name="limit"
          />

          <AppInputError class="mt-2" :message="form.errors.limit" />
        </div>
      </form>
    </AppModal>
  </div>
  <!-- Card Item End -->
</template>
