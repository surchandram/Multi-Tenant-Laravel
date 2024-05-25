<script setup>
  import { computed, ref } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  const props = defineProps({
    action: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
      default: 'image',
    },
  });

  const form = useForm({
    [props.name]: null
  });

  const store = () => {
    form.clearErrors();

    form.post(props.action, {
      onSuccess: () => {
        form.reset();
        toggleForm();
      }
    });
  };

  const showForm = ref(false);

  const toggleForm = () => showForm.value = !showForm.value;
</script>

<template>
  <div class="w-full flex flex-col">
    <form v-if="showForm" action="#" @submit.prevent="store">
      <div class="form-group mt-4">
        <AppInputLabel :for="props.name" class="form-label inline-flex mb-2">
          Upload Logo
        </AppInputLabel>
      
        <AppInput
          :id="props.name"
          class="form-control"
          type="file"
          @change="($event) => form[props.name] = $event.target.files[0]"
        />
      
        <AppInputError :message="form.errors[props.name]" class="mt-2" />
      </div>
      <!-- /.form-group -->
      
      <div class="form-group flex items-center justify-end mt-4">
        <AppButton
          class="flex items-center gap-1 mr-1 mb-1"
          type="submit"
          :disabled="form.processing"
        >
          <AppSpinner :size="4" v-show="form.processing" />
          Upload
          <i class="bi bi-upload"></i>
        </AppButton>
      </div>
    </form>

    <!-- Toggle Form Button -->
    <div v-else>
      <slot :toggle-form="toggleForm"></slot>
    </div>
  </div>
</template>
