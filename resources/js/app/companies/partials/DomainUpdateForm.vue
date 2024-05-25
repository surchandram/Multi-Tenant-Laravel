<script setup>
  import AppButton from '@/components/AppButton.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import updateCompanyDomain from '@/pages/companies/UpdateCompanyDomain';

  import { useModal } from 'momentum-modal';

  const { redirect } = useModal();

  const props = defineProps({
    model: {
      type: Object,
      required: true,
    },
  });

  const { form, store } = updateCompanyDomain(
    props.model,
    route('companies.domain.store', props.model.company),
    redirect,
  );
</script>

<template>
  <div class="py-4">
    <form
      action="#"
      @submit.prevent="store"
    >
      <!-- Validation Errors -->
      <AppValidationErrors
        v-if="form.hasErrors"
        class="mb-8"
        :errors="form.errors"
      />
      <!-- END Validation Errors -->

      <!-- Domain -->
      <div class="mt-6 space-y-3">
        <AppInputLabel
          for="domain"
          class="inline-block"
          >{{ __('app.labels.company_domain') }}</AppInputLabel
        >

        <AppInputGroup
          class="w-full"
          text-bg="bg-slate-200"
        >
          <template #default="{ inputStyles }">
            <AppInput
              id="domain"
              v-model="form.domain"
              type="text"
              name="domain"
              placeholder="domain..."
              class="form-control w-full flex-1"
              :class="inputStyles"
              required
            />
          </template>

          <template #end>
            <div>.{{ $page.props.appDomain }}</div>
          </template>
        </AppInputGroup>

        <AppInputError :message="form.errors.domain" />
      </div>
      <!-- END Domain -->

      <div class="form-group flex items-center justify-end mt-8">
        <AppButton
          class="flex items-center gap-1 mr-1 mb-1"
          type="submit"
          :disabled="form.processing"
        >
          <AppSpinner
            v-show="form.processing"
            :size="4"
          />
          {{ __('app.buttons.update') }}
        </AppButton>
      </div>
    </form>
  </div>
</template>
