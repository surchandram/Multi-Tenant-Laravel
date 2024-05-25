<script>
export default {
  pageLayout: "admin",
};
</script>

<script setup>
  import { ref, onMounted, reactive, watch, computed } from "vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AppFeatureCard from "@/components/admin/apps/AppFeatureCard.vue";
  import AppPlanCard from "@/components/admin/apps/AppPlanCard.vue";
  import Editor from "@/components/Editor.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppSuccessButton from "@/components/AppSuccessButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  const props = defineProps(["app", "apps", "features", "plans"]);

  const state = reactive({
    features: [],
    plans: [],
  });

  const form = useForm({
    _method: 'patch',
    name: props.app.name,
    logo: null,
    key: props.app.key,
    url: props.app.url,
    description: props.app.description,
    overview: props.app.overview,
    usable: props.app.usable,
    teams_only: props.app.teams_only,
    primary: props.app.primary,
    subscription: props.app.subscription,
    features: [],
    plans: [],
  });

  onMounted(() => {
    //
  });

  const appDataSetup = function () {
    if (props.app.features?.length > 0) {
      state.features = props.app.features;
    }

    // setup existing app 'plans'
    if (props.app.plans?.length > 0) {
      state.plans = props.app.plans;
    }
  };

  const features_count = computed(() => form.features.length || props.app.features.length);

  const plans_count = computed(() => form.plans.length || props.app.plans.length);


  const store = () => {
    form.clearErrors();

    form.post(route("admin.apps.update", props.app), {
      onSuccess: () => {
        form.reset('features', 'plans', 'logo');
        appDataSetup();
      }
    });
  };
</script>

<template>
  <Head title="Review App - Apps | Admin" />

  <div class="flex flex-col gap-5 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold">Reviewing App: {{ app.name }}</span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppButton
          :href="route('admin.apps.edit', app)"
          class="flex items-center gap-2"
        >
          <i class="bi bi-pencil"></i> Edit
        </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <div>
        <form action="#" @submit.prevent="store">
          <AppValidationErrors :errors="form.errors" />
        </form>

        <div class="grid grid-cols-5 py-5">
          <!-- Logo -->
          <div class="col-span-full md:col-span-1 px-4 mb-4 md:mb-0">
            <img v-if="app.has_logo" class="max-h-[128px]" :src="app.logo" alt="...">
            
            <!-- no logo placeholder -->
            <p v-else class="inline-flex items-center text-3xl">
              <i class="bi bi-stack"></i>
              <span class="ml-2 text-sm font-semibold">
                Upload logo.
              </span>
            </p>
          </div>

          <!-- App Summary -->
          <div class="col-span-full md:col-span-4 px-4">
            <!-- Live -->
            <div>
              <AppInputLabel
                for="usable"
                class="inline-flex items-center gap-3 px-2 py-2 rounded-md"
                :class="{
                  'bg-blue-200 text-blue-600': app.usable,
                  'bg-red-200 text-red-600': !app.usable
                }"
              >
                {{ app.usable ? 'Live' : 'Disabled' }}
              </AppInputLabel>
            </div>
            
            <!-- Name -->
            <div class="mt-4">
              <AppInputLabel for="name">Name</AppInputLabel>
            
              <div
                class="w-full px-2 py-1 mt-2 border-2 border-dotted border-blue-200 text-slate-700"
              >
                {{ app.name }}
              </div>
            
            </div>
            
            <!-- Key -->
            <div class="mt-4">
              <AppInputLabel for="key">Key</AppInputLabel>
            
              <div
                class="w-full px-2 py-1 mt-2 border-2 border-dotted border-blue-200 text-slate-700"
              >
                {{ app.key }}
              </div>
            </div>
            
            <!-- Url -->
            <div class="mt-4">
              <AppInputLabel for="url">Url</AppInputLabel>
            
              <div
                class="w-full px-2 py-1 mt-2 border-2 border-dotted border-blue-200 text-slate-700 break-words"
              >
                {{ app.url }}{{ `.${$page.props.appDomain}` }}
              </div>
            </div>
            
            <!-- Description -->
            <div class="mt-4">
              <AppInputLabel for="description">Description</AppInputLabel>
            
              <div
                class="w-full px-2 py-1 mt-2 border-2 border-dotted border-blue-200 text-slate-700"
              >
                {{ app.description }}
              </div>
            </div>
          </div>
          <!-- /App Summary -->
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
            <Editor v-model="app.overview" />
          </div>
        </div>

        <!-- divider -->
        <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
          <div class="w-12">
            <div class="w-full h-0 border-t-2 border-blue-600">&nbsp;</div>
          </div>
          <p class="text-lg font-semibold">Features</p>
        </div>

        <!-- App Features -->
        <div>
          <p v-if="features_count == 0" class="text-sm font-semibold text-slate-700">
            No features added yet.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
          <!-- Features list -->
          <AppFeatureCard
            v-for="(feature, index) in app.features"
            :key="feature.id"
            :feature="feature"
          />
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
          <p v-if="plans_count <= 0" class="text-sm font-semibold text-slate-700">
            No plans added yet.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
          <AppPlanCard
            v-for="(plan, index) in app.plans"
            :key="plan.id"
            :plan="plan"
          />
        </div>
        <!-- /App Plans -->

        <div class="mt-4">
          <div class="flex items-baseline justify-end">
            ...
          </div>
        </div>
      </div>
      <!--/ Form -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
