<script setup>
  import { onMounted, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';

  const props = defineProps({
    modelValue: Object,
    action: String,
    inline: {
      type: Boolean,
      default: false,
    },
    without: {
      type: Array,
      default: () => [],
    },
    countries: {
      type: Array,
      default: () => [],
    },
  });

  const emit = defineEmits(['update:modelValue']);

  const form = useForm({
    name: props.modelValue?.name,
    address_1: props.modelValue?.address_1,
    address_2: props.modelValue?.address_2,
    state: props.modelValue?.state,
    city: props.modelValue?.city,
    postal_code: props.modelValue?.postal_code,
    country_id: props.modelValue?.country_id,
    default: props.modelValue?.default || true,
    billing: props.modelValue?.billing || true,
  });

  const isVisible = (key) => !_.includes(props.without, key);

  onMounted(() => {
    // setup form
    if (typeof props.modelValue == 'object') {
      form.defaults('country_id', props.modelValue?.country_id);
      form.reset();
    }

    // emit 'input' event
    watch(
      () => _.cloneDeep(form),
      () => {
        emit('update:modelValue', form.data());
      },
    );
  });

  const store = () => {
    form.clearErrors();

    if (typeof props.action === 'undefined') {
      emit('update:modelValue', form.data());
    } else {
      form.post(props.action, {
        //
      });
    }
  };
</script>

<template>
  <component
    :is="inline ? 'div' : 'form'"
    method="POST"
    action="#"
    @submit.prevent="store"
  >
    <div>
      <AppInputLabel for="name">Full name</AppInputLabel>

      <AppInput
        id="name"
        type="text"
        class="w-full mt-2"
        name="name"
        v-model="form.name"
        required
      />

      <AppInputError
        :message="form.errors.name"
        class="mt-2"
      />
    </div>

    <div class="mt-4">
      <AppInputLabel for="address_1">Address line 1</AppInputLabel>

      <AppInput
        id="address_1"
        type="text"
        class="w-full mt-2"
        name="address_1"
        v-model="form.address_1"
        required
      />

      <AppInputError
        :message="form.errors.address_1"
        class="mt-2"
      />
    </div>

    <div class="mt-4">
      <AppInputLabel for="address_2">Address line 2</AppInputLabel>

      <AppInput
        id="address_2"
        type="text"
        class="w-full mt-2"
        name="address_2"
        v-model="form.address_2"
      />

      <AppInputError
        :message="form.errors.address_2"
        class="mt-2"
      />
    </div>

    <div class="mt-4">
      <AppInputLabel for="state">State</AppInputLabel>

      <AppInput
        id="state"
        v-model="form.state"
        type="text"
        class="w-full mt-2"
        name="state"
      />

      <AppInputError
        :message="form.errors.state"
        class="mt-2"
      />
    </div>

    <!-- City / Postal code -->
    <div class="flex flex-col mt-4 md:grid md:grid-cols-2 md:gap-4">
      <!-- City -->
      <div class="">
        <AppInputLabel for="city">City</AppInputLabel>

        <AppInput
          id="city"
          v-model="form.city"
          type="text"
          class="w-full mt-2"
          name="city"
          required
        />

        <AppInputError
          :message="form.errors.city"
          class="mt-2"
        />
      </div>

      <!-- Postal code -->
      <div class="mt-2 md:mt-0">
        <AppInputLabel for="postal_code">Postal code</AppInputLabel>

        <AppInput
          id="postal_code"
          v-model="form.postal_code"
          type="text"
          class="w-full mt-2"
          name="postal_code"
          required
        />

        <AppInputError
          :message="form.errors.postal_code"
          class="mt-2"
        />
      </div>
    </div>

    <div class="mt-4 dark:text-secondary">
      <AppInputLabel
        for="country_id"
        class="block mb-2"
      >
        Country
      </AppInputLabel>

      <select
        id="country_id"
        v-model="form.country_id"
        v-choicesjs
        class="w-full mt-2"
        name="country_id"
        required
      >
        <option value="">Choose country</option>
        <option
          v-for="country in countries"
          :key="country.id"
          :value="country.id"
        >
          {{ country.name }}
        </option>
      </select>

      <AppInputError
        :message="form.errors.country_id"
        class="mt-2"
      />
    </div>

    <div
      v-if="isVisible('default')"
      class="w-full flex items-center gap-2 mt-4"
    >
      <AppCheckbox
        id="default"
        v-model="form.default"
        name="default"
        value="1"
      />

      <AppInputLabel for="default">Set as default</AppInputLabel>
    </div>

    <div
      v-if="isVisible('billing')"
      class="w-full flex items-center gap-2 mt-4"
    >
      <AppCheckbox
        id="billing"
        v-model="form.billing"
        name="billing"
        value="1"
      />

      <AppInputLabel for="billing">Use for Billing</AppInputLabel>
    </div>

    <div
      v-if="!inline"
      class="flex items-center justify-end gap-3 mt-4"
    >
      <AppButton type="submit">Save</AppButton>
      <slot name="buttons"></slot>
    </div>
  </component>
</template>
