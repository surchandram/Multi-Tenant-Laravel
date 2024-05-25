<script>
export default {
  pageLayout: "admin",
};
</script>

<script setup>
  import { ref, onMounted, reactive, watch } from "vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AppFeatureUpsertModal from "@/components/admin/apps/AppFeatureUpsertModal.vue";
  import AppPlanUpsertModal from "@/components/admin/apps/AppPlanUpsertModal.vue";
  import AppFeatureCard from "@/components/admin/apps/AppFeatureCard.vue";
  import AppPlanCard from "@/components/admin/apps/AppPlanCard.vue";
  import Editor from "@/components/Editor.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputGroup from "@/components/AppInputGroup.vue";
  import AppCheckbox from "@/components/AppCheckbox.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppSuccessButton from "@/components/AppSuccessButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  const props = defineProps(["apps", "features", "plans"]);

  const state = reactive({
    features: [],
    plans: [],
  });

  const form = useForm({
    name: "",
    key: "",
    url: "",
    description: "",
    overview: "",
    usable: false,
    teams_only: true,
    primary: true,
    subscription: true,
    features: [],
    plans: [],
  });

  onMounted(() => {
    watch(() => form.name, (val) => {
      form.key = window.domainSlugger(val);
    });
  });

  const addFeature = (feature) => {
    state.features.push(feature);

    form.features = state.features;
  };

  const updateFeature = (feature) => {
    state.features = state.features.map((f) => f.id == feature.id ? feature : f);

    form.features = state.features;
  };

  const addPlan = (plan) => {
    state.plans.push(plan);

    form.plans = state.plans;
  };

  const updatePlan = (plan) => {
    state.plans = state.plans.map((p) => p.id == plan.id ? plan : p);

    form.plans = state.plans;
  };

  const store = () => {
    form.clearErrors();

    form
      .transform((data) => ({
        ...data,
        features: data.features.map((f) => _.omit(f, 'id')),
        plans: data.plans.map(
          (p) => {
            p.features = p.features.map((f) => _.omit(f, ['id']))
            return p
          })
      }))
      .post(route("admin.apps.store"), {
        //
      });
  };
</script>

<template>
  <Head title="Add new App - Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold"> Add new App </span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppSuccessButton @click.prevent="$eventBus.emit('show-modal', 'featureCreateModal')">
          Add Feature
        </AppSuccessButton>

        <AppButton @click.prevent="$eventBus.emit('show-modal', 'planCreateModal')">
          Add Billing Plan
        </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <div>
        <form action="#" @submit.prevent="store">
          <AppValidationErrors :errors="form.errors" />

          <!-- Live -->
          <div class="mt-4">
            <AppInputLabel for="usable" class="inline-flex items-center gap-3">
              <AppCheckbox
                class="pl-0 pr-0"
                name="usable"
                id="usable"
                valie="1"
                v-model="form.usable"
              />
              Live
            </AppInputLabel>

            <AppInputError class="mt-2" :message="form.errors.usable" />
          </div>

          <!-- Name -->
          <div class="mt-4">
            <AppInputLabel for="name">Name</AppInputLabel>

            <AppInput
              class="w-full mt-2"
              name="name"
              id="name"
              v-model="form.name"
            />

            <AppInputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Key -->
          <div class="mt-4">
            <AppInputLabel for="key">Key</AppInputLabel>

            <AppInput
              class="w-full mt-2"
              name="key"
              id="key"
              v-model="form.key"
            />

            <AppInputError class="mt-2" :message="form.errors.key" />
          </div>

          <!-- Url -->
          <div class="mt-4">
            <AppInputLabel for="url">Url</AppInputLabel>

            <AppInputGroup :end="`.${$page.props.appDomain}`">
              <template #default="{ inputStyles }">
                <AppInput
                  :class="inputStyles"
                  class="w-full"
                  name="url"
                  id="url"
                  v-model="form.url"
                />
              </template>

              <!-- <template #end>
                <div class="px-2 py-1 text-sm font-semibold bg-slate-200">
                  {{ $page.props.appDomain }}
                </div>
              </template> -->
            </AppInputGroup>

            <AppInputError class="mt-2" :message="form.errors.url" />
          </div>

          <!-- Description -->
          <div class="mt-4">
            <AppInputLabel for="key">Description</AppInputLabel>

            <AppInput
              class="w-full mt-2"
              name="description"
              id="description"
              v-model="form.description"
              maxlength="100"
            />

            <AppInputError class="mt-2" :message="form.errors.description" />
          </div>

          <!-- divider -->
          <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
            <div class="w-12">
              <div class="w-full h-0 border-t-2 border-blue-600">&nbsp;</div>
            </div>
            <p class="text-lg font-semibold">Details</p>
          </div>

          <!-- Overview -->
          <div class="pt-4">
            <AppInputLabel>Full overview</AppInputLabel>

            <div class="px-1 py-1 mt-3 border border-dotted border-slate-500 rounded">
              <Editor v-model="form.overview" />
            </div>
          </div>

          <!-- divider -->
          <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
            <div class="w-12">
              <div class="w-full h-0 border-t-2 border-blue-600">&nbsp;</div>
            </div>
            <p class="text-lg font-semibold">Features</p>
          </div>

          <div>
            <AppInputError class="mt-2 mb-4" :message="form.errors.features" />
          </div>

          <!-- App Features -->
          <p v-if="form.features.length == 0" class="text-sm font-semibold text-slate-700">
            No features added yet.

            <AppSuccessButton @click.prevent="$eventBus.emit('show-modal', 'featureCreateModal')">
              Add Feature
            </AppSuccessButton>
          </p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
            <!-- Features list -->
            <AppFeatureCard
              v-for="(feature, index) in state.features"
              :key="feature.id"
              :feature="feature"
            >
              <template #footer>
                <AppButton
                  type="button"
                  class=""
                  @click.prevent="$eventBus.emit('app-feature:edit', feature)"
                >
                  Edit
                </AppButton>
              </template>
            </AppFeatureCard>

            <template v-if="form.features.length > 0">
              <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark hover:bg-slate-100"
              >
                <a
                  class="w-full h-full flex flex-col items-center justify-center py-6 px-7.5"
                  href="#"
                  @click.prevent="$eventBus.emit('show-modal', 'featureCreateModal')"
                >
                  <p class="text-center">
                    <i class="bi bi-plus-circle font-semibold text-2xl"></i>
                    <br>
                    Add Feature
                  </p>
                </a>
              </div>
            </template>
          </div>
          <!-- /App Features -->

          <!-- App Plans -->
          <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
            <div class="w-12">
              <div class="w-full h-0 border-t-2 border-teal-600">&nbsp;</div>
            </div>
            <p class="text-lg font-semibold">Plans</p>
          </div>

          <div>
            <AppInputError class="mt-2 mb-4" :message="form.errors.features" />

            <p v-if="form.plans.length <= 0" class="text-sm font-semibold text-slate-700">
              No plans added yet.
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
              <AppPlanCard
                v-for="(plan, index) in form.plans"
                :key="plan.id"
                :plan="plan"
              >
                <template #footer>
                  <AppButton
                    type="button"
                    @click.prevent="$eventBus.emit('app-plan:edit', plan)"
                  >
                    Edit
                  </AppButton>
                </template>
              </AppPlanCard>

              <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark hover:bg-slate-100"
              >
                <a
                  class="w-full h-full flex flex-col items-center justify-center py-6 px-7.5"
                  href="#"
                  @click.prevent="$eventBus.emit('show-modal', 'planCreateModal')"
                >
                  <p class="text-center">
                    <i class="bi bi-plus-circle font-semibold text-2xl"></i>
                    <br>
                    Add Billing Plan
                  </p>
                </a>
              </div>
          </div>
          <!-- /App Plans -->

          <div class="mt-4">
            <div class="flex items-baseline justify-end">
              <AppButton
                type="submit"
                class="flex items-center gap-2"
                :disabled="form.processing"
              >
                <AppSpinner v-show="form.processing" :size="4" /> Create
              </AppButton>
            </div>
          </div>
        </form>
      </div>
      <!--/ Form -->

      <!-- Feature Modal -->
      <AppFeatureUpsertModal
        modal-id="featureCreateModal"
        @app-feature:added="addFeature"
        @app-feature:edited="updateFeature"
      >
      </AppFeatureUpsertModal>
      <!-- /Feature Create Modal -->

      <!-- Plan Create Modal -->
      <AppPlanUpsertModal
        modal-id="planCreateModal"
        :features="state.features"
        @app-plan:added="addPlan"
        @app-plan:edited="updatePlan"
      ></AppPlanUpsertModal>
      <!-- /Plan Create Modal -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
