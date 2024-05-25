<script setup>
  import { useSlots, toRefs, onMounted, watch, ref } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import AppModal from "@/components/AppModal.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppCheckbox from "@/components/AppCheckbox.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  const props = defineProps({
    "feature": {
      type: Object,
      required: false,
      default: function () {
        return {};
      }
    },
    "modalId": {
      type: String,
      default: Date.now()
    }
  });

  const { feature, modalId } = toRefs(props);

  const emit = defineEmits([
    'app-feature:added',
    'app-feature:edited',
  ]);

  const form = useForm({
    id: "",
    name: "",
    key: "",
    description: "",
    usable: true,
    limit: 0,
    is_unlimited: true,
  });

  const editing = ref(false);

  const slots = useSlots();

  const modalRef = ref(null);

  onMounted(() => {
    $eventBus.on('app-feature:edit', function (feature) {
      Object.keys(form.data()).forEach((key) => {
        form[key] = feature[key];
      });

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
      form.limit = val == true ? 0 : 1;
    });

    watch(() => form.name, (val) => {
      form.key = window.slugify(form.name, {
        lower: true
      });
    });
  });

  const store = () => {
    form.clearErrors();
    form.processing =  true;

    if (_.isEmpty(form.id)) {
      form.id = '_' + Date.now();
    }

    if (!form.name || !form.key) {
      form.processing =  false;

      // name error
      if (!form.name) {
        form.setError('name', 'Name is required.')
      }

      // key error
      if (!form.key) {
        form.setError('key', 'Key is required.')
      }

      return;
    }

    const data = form.data();

    form.reset();

    if (!editing.value) {
      emit('app-feature:added', data);
    }
    else {
      emit('app-feature:edited', data);
    }

    editing.value = false;

    setTimeout(() => {
      form.processing =  false;
      modalRef.value.hide();
    }, 500);
  };
</script>

<template>
  <AppModal
    id="featureCreateModal"
    ref="modalRef"
    close-label="Cancel"
    submit
    submit-label="Add"
    :submit-callback="store"
  >
    <template #header>Add app feature</template>

    <form action="#" @submit.prevent="store">
      <AppValidationErrors :errors="form.errors" />

      <!-- Live -->
      <div class="mt-4">
        <AppInputLabel for="feature_usable" class="inline-flex items-center gap-3">
          <AppCheckbox
            id="feature_usable"
            v-model="form.usable"
            class="pl-0 pr-0"
            name="usable"
            valie="1"
          />
          Live
        </AppInputLabel>

        <AppInputError class="mt-2" :message="form.errors.usable" />
      </div>

      <!-- Name -->
      <div class="mt-4">
        <AppInputLabel for="feature_name">Name</AppInputLabel>

        <AppInput
          id="feature_name"
          v-model="form.name"
          class="w-full mt-2"
          name="name"
        />

        <AppInputError class="mt-2" :message="form.errors.name" />
      </div>

      <!-- Key -->
      <div class="mt-4">
        <AppInputLabel for="feature_key">Key</AppInputLabel>

        <AppInput
          id="feature_key"
          v-model="form.key"
          class="w-full mt-2"
          name="key"
        />

        <AppInputError class="mt-2" :message="form.errors.key" />
      </div>

      <!-- Unlimted -->
      <div class="mt-4">
        <AppInputLabel for="feature_is_unlimited" class="inline-flex items-center gap-3">
          <AppCheckbox
            id="feature_is_unlimited"
            v-model="form.is_unlimited"
            class="pl-0 pr-0"
            name="is_unlimited"
            valie="1"
          />
          Unlimited
        </AppInputLabel>

        <AppInputError class="mt-2" :message="form.errors.is_unlimited" />
      </div>

      <!-- Limit -->
      <div v-if="!form.is_unlimited" class="mt-4">
        <AppInputLabel for="feature_limit">Limit</AppInputLabel>

        <AppInput
          type="number"
          min="1"
          id="feature_limit"
          v-model="form.limit"
          class="w-full mt-2"
          name="limit"
        />

        <AppInputError class="mt-2" :message="form.errors.limit" />
      </div>
    </form>
  </AppModal>
</template>
