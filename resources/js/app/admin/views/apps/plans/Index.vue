<script>
export default {
  pageLayout: "admin",
};
</script>

<script setup>
  import { ref, onMounted, watch } from "vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AppPlanUpsertModal from "@/components/admin/apps/AppPlanUpsertModal.vue";
  import AppPlanCard from "@/components/admin/apps/AppPlanCard.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppSuccessButton from "@/components/AppSuccessButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";

  const props = defineProps(["app", "features", "plans"]);

  const form = useForm({
    plans: [],
  });

  onMounted(() => {
    watch(() => form.name, (val) => {
      form.key = window.domainSlugger(val);
    });
  });

  const addPlan = (feature) => {
    form.plans.push(feature);
  };

  const updatePlan = (feature) => {
    form.plans = form.plans.map((f) => f.id == feature.id ? feature : f);
  };

  const store = () => {
    form.clearErrors();

    // form.post(route("admin.apps.plans.store", props.app), {
      //
    // });
  };
</script>

<template>
  <Head title="Plans - {app.name} | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold">Manage Plans</span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppButton data-bs-toggle="modal" data-bs-target="#planCreateModal">
          Add Billing Plan
        </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <div>
        <form action="#" @submit.prevent="store">

          <!-- App Plans -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
            <p v-if="form.plans.length <= 0" class="text-sm font-semibold text-slate-700">
              No plans added yet.

              <AppSuccessButton data-bs-toggle="modal" data-bs-target="#planCreateModal">
                Add Plan
              </AppSuccessButton>
            </p>

            <!-- Features list -->
            <template v-else>
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
                  data-bs-toggle="modal"
                  data-bs-target="#planCreateModal"
                >
                  <p class="text-center">
                    <i class="bi bi-plus-circle font-semibold text-2xl"></i>
                    <br>
                    Add Plan
                  </p>
                </a>
              </div>
            </template>
          </div>
          <!-- /App Plans -->

          <div class="mt-4">
            <div class="flex items-baseline justify-end">
              <AppButton
                type="submit"
                class="flex items-center gap-2"
                :disabled="form.processing"
              >
                <AppSpinner v-show="form.processing" :size="4" /> Save
              </AppButton>
            </div>
          </div>
        </form>
      </div>
      <!--/ Form -->

      <!-- Plan Create Modal -->
      <AppPlanUpsertModal
        v-if="app.features.length > 0"
        modal-id="planCreateModal"
        :features="app.features"
        @app-plan:added="addPlan"
        @app-plan:edited="updatePlan"
      ></AppPlanUpsertModal>
      <!-- /Plan Create Modal -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
