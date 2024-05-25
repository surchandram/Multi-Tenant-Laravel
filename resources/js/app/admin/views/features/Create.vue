<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { inject, onMounted, watch } from "vue";
  import { Head, useForm } from "@inertiajs/vue3";
  import { cloneDeep } from "lodash";
  import Slugify from "slugify";
  import AppCheckbox from "@/components/AppCheckbox.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppTextarea from "@/components/AppTextarea.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  defineProps(["model"]);

  const form = useForm({
    name: "",
    key: "",
    is_unlimited: false,
    trial_limit: null,
    description: "",
    usable: false,
  });

  const $scrollTo = inject("$scrollTo");

  const scrollTo = (el = "body") => {
    $scrollTo(el, { container: "#app" });
  };

  const store = () => {
    form.clearErrors();
    scrollTo();

    form
      .transform((data) => ({
        ...data,
      }))
      .post(route("admin.features.store"), {
        //
      });
  };

  onMounted(() => {
    watch(
      () => cloneDeep(form.data()),
      (old, val) => {
        if (val.name != old.name) {
          form.key = Slugify(val.name, {
            lower: true,
            remove: new RegExp(/[*+~.()'"!:@#^\\//]/g),
          });
        }
      }
    );
  });
</script>

<template>
  <Head :title="`${__('admin.labels.add_feature')} | Admin`" />

  <div class="flex flex-col gap-10 relative">
    <!-- Heading Area -->
    <div class="w-full flex md:items-center justify-between px-6 mb-3">
      <!-- Heading -->
      <div class="mr-auto">
        <h1
          class="text-slate-800 text-2xl font-hairline leading-tight"
        >{{ __('admin.labels.add_feature') }}</h1>

        <p>Once created feature some fields will not be editable.</p>
      </div>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-center gap-3">
        <div class="flex items-center gap-2">
          <!-- Actions -->
          <div class="inline-flex items-center">
            <!-- Save Button -->
            <div class="flex items-center justify-end lg:justify-start">
              <AppButton
                type="submit"
                class="inline-flex items-center gap-2"
                :disabled="form.processing"
                @click.prevent="store"
              >
                <AppSpinner v-show="form.processing" :size="4" />
                <i v-show="!form.processing" class="bi bi-check"></i>
                Save
              </AppButton>
            </div>
          </div>
          <!-- /Actions -->
        </div>
      </div>
    </div>
    <!-- /Heading Area -->

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 pb-6">
      <!-- Form -->
      <form action="#" @submit.prevent="store">
        <AppValidationErrors v-if="form.hasErrors" :errors="form.errors" />

        <!-- Usable -->
        <div class="mt-4">
          <AppInputLabel class="inline-flex items-center gap-2">
            <AppCheckbox v-model="form.usable" />
            {{ __('app.labels.active') }}
          </AppInputLabel>
        </div>
        <!-- END Usable -->

        <!-- Is Unlimited -->
        <div class="mt-4">
          <AppInputLabel class="inline-flex items-center gap-2">
            <AppCheckbox v-model="form.is_unlimited" />
            {{ __('app.labels.is_unlimited') }}
          </AppInputLabel>
        </div>
        <!-- END Is Unlimited -->

        <!-- Name -->
        <div class="mt-4">
          <AppInputLabel for="name">{{ __('app.labels.name') }}</AppInputLabel>

          <AppInput id="name" v-model="form.name" class="w-full mt-2" name="name" />

          <AppInputError class="mt-2" :message="form.errors.name" />
        </div>
        <!-- END Name -->

        <!-- Key -->
        <div class="mt-4">
          <AppInputLabel for="key">{{ __('app.labels.key') }}</AppInputLabel>

          <AppInput id="key" v-model="form.key" class="w-full mt-2" name="key" />

          <AppInputError class="mt-2" :message="form.errors.key" />
        </div>
        <!-- END Key -->

        <!-- Trial Limit -->
        <div class="mt-4">
          <AppInputLabel for="trial_limit">{{ __('app.labels.trial_limit') }}</AppInputLabel>

          <AppInput
            id="trial_limit"
            v-model.number="form.trial_limit"
            type="number"
            min="0"
            class="w-full mt-2"
            name="trial_limit"
          />

          <AppInputError class="mt-2" :message="form.errors.trial_limit" />
        </div>
        <!-- END Trial Limit -->

        <!-- Description -->
        <div class="mt-4">
          <AppInputLabel for="description">{{ __('app.labels.description') }}</AppInputLabel>

          <AppTextarea
            id="description"
            v-model="form.description"
            class="mt-2"
            rows="4"
            placeholder="Brief details about the feature..."
            name="description"
          />

          <AppInputError class="mt-2" :message="form.errors.description" />
        </div>
        <!-- END Description -->

        <!-- Actions -->
        <div class="flex items-baseline justify-end gap-3 mt-4">
          <!-- Save Button -->
          <AppButton type="submit" class="flex items-center gap-2" :disabled="form.processing">
            <AppSpinner v-show="form.processing" :size="4" />
            <i v-show="!form.processing" class="bi bi-check"></i>
            {{ __('app.labels.save') }}
          </AppButton>
        </div>
        <!-- END Actions -->
      </form>
      <!--/ Form -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
