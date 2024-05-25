<script setup>
  import { watch, ref, computed } from "vue";
  import AppButton from "@/components/AppButton.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputGroup from "@/components/AppInputGroup.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppLogoInput from "@/components/AppLogoInput.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppSpinner from "@/components/AppSpinner.vue";
  import upsertCompanyPage from "@/pages/companies/UpsertCompanyPage";

  const props = defineProps({
    model: {
      type: Object,
      required: true,
    },
    editing: {
      type: Boolean,
      default: false,
    },
    action: {
      type: String,
      required: true,
    },
  });

  const emit = defineEmits(["close"]);

  const { form } = upsertCompanyPage(props.model, props.editing);

  const store = () => {
    form.clearErrors();

    if (props.editing) {
      form
        .transform((data) => ({
          ...data,
          _method: "patch",
        }))
        .post(props.action, {
          onSuccess: () => {
            // fire alert
            emit("close");
          },
        });
    } else {
      form
        .transform((data) => ({
          ..._.omit(data, "_method"),
        }))
        .post(props.action, {
          onSuccess: () => {
            form.reset();
            emit("close");
          },
        });
    }
  };
</script>

<template>
  <div>
    <form method="POST" action="#" @submit.prevent="store">
      <!-- Validation Errors -->
      <AppValidationErrors v-if="form.hasErrors" class="mb-8" :errors="form.errors" />
      <!-- END Validation Errors -->

      <!-- Logo-->
      <AppLogoInput
        v-model="form.logo"
        :current-logo="model.company?.logo"
        placeholder="company+logo"
      />
      <!-- END Logo-->

      <!-- Name -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="name" class="inline-block">{{ __('app.labels.company_name') }}</AppInputLabel>

        <AppInput
          id="name"
          v-model="form.name"
          type="text"
          name="name"
          class="form-control"
          required
        />

        <AppInputError :message="form.errors.name" class="mt-2" />
      </div>
      <!-- /.form-group -->

      <!-- Domain -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="domain" class="inline-block">{{ __('app.labels.company_domain') }}</AppInputLabel>

        <AppInputGroup class="w-full" text-bg="bg-slate-200">
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

        <AppInputError :message="form.errors.domain" class="mt-2" />
      </div>
      <!-- /.form-group -->

      <!-- Email Address -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="email" class="inline-block">{{ __('app.labels.email') }}</AppInputLabel>

        <AppInput
          id="email"
          v-model="form.email"
          class="form-control"
          type="email"
          name="email"
          required
        />

        <AppInputError :message="form.errors.email" class="mt-2" />
      </div>
      <!-- /.form-group -->

      <!-- Measurement Unit -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="measurement_unit" class="inline-block">Measurement unit (feet, metres)</AppInputLabel>

        <select
          id="measurement_unit"
          v-model="form.measurement_unit"
          v-choicesjs
          class="form-control w-full block"
          name="measurement_unit"
        >
          <option value>--- Select ---</option>
          <option value="feet">Feet</option>
          <option value="metres">Metres</option>
        </select>

        <AppInputError :message="form.errors.measurement_unit" class="mt-2" />
      </div>
      <!-- Measurement Unit -->

      <!-- Currency -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="currency" class="inline-block">{{ __('app.labels.currency') }}</AppInputLabel>

        <AppInput
          id="currency"
          v-model="form.currency"
          class="form-control"
          type="text"
          name="currency"
        />

        <AppInputError :message="form.errors.currency" class="mt-2" />
      </div>
      <!-- END Currency -->

      <!-- Default Tax -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="default_tax" class="inline-block">{{ __('app.labels.default_tax') }}</AppInputLabel>

        <AppInput
          id="default_tax"
          v-model.number="form.default_tax"
          class="form-control"
          type="text"
          name="default_tax"
        />

        <AppInputError :message="form.errors.default_tax" class="mt-2" />
      </div>
      <!-- END Default Tax -->

      <!-- License No -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="license_no" class="inline-block">{{ __('app.labels.license_no') }}</AppInputLabel>

        <AppInput
          id="license_no"
          v-model="form.license_no"
          class="form-control"
          type="text"
          name="license_no"
        />

        <AppInputError :message="form.errors.license_no" class="mt-2" />
      </div>
      <!-- END License No -->

      <!-- Tax Id -->
      <div class="mt-6 space-y-2">
        <AppInputLabel for="tax_id" class="inline-block">{{ __('app.labels.tax_id') }}</AppInputLabel>

        <AppInput id="tax_id" v-model="form.tax_id" class="form-control" type="text" name="tax_id" />

        <AppInputError :message="form.errors.tax_id" class="mt-2" />
      </div>
      <!-- END Tax Id -->

      <!-- Projects Prefix -->
      <div class="mt-6 space-y-2">
        <AppInputLabel
          for="projects_prefix"
          class="inline-block"
        >{{ __('app.labels.projects_prefix') }}</AppInputLabel>

        <AppInput
          id="projects prefix"
          v-model="form.projects_prefix"
          class="form-control"
          type="text"
          name="projects_prefix"
        />

        <AppInputError :message="form.errors.projects_prefix" class="mt-2" />
      </div>
      <!-- END Projects Prefix -->

      <div class="form-group flex items-center justify-end mt-4">
        <AppButton
          class="flex items-center gap-1 mr-1 mb-1"
          type="submit"
          :disabled="form.processing"
        >
          <AppSpinner v-show="form.processing" :size="4" />
          {{ editing ? __('app.buttons.update') : __('app.buttons.create') }}
        </AppButton>
      </div>
    </form>
  </div>
</template>
