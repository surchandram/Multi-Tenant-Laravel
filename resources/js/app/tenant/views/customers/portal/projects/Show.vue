<script>
  export default {
    pageLayout: "customer_project",
  };
</script>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import { useMomentJS } from "@/composables/momentjs";
  import ResheduleProjectFormModal from "./partials/ResheduleProjectFormModal.vue";
  import ProjectAuthorizationFormModal from "./partials/ProjectAuthorizationFormModal.vue";
  import ProjectCompletionApprovalFormModal from "./partials/ProjectCompletionApprovalFormModal.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppSuccessButton from "@/components/AppSuccessButton.vue";
  import DocumentSignaturePreviewModal from "@/components/documents/DocumentSignaturePreviewModal.vue";

  defineProps(["model"]);

  const { formatDateZone } = useMomentJS();
</script>

<template>
  <Head :title="`${model.project.name} | ${$page.props.tenant.name}`" />

  <!-- Page Section -->
  <div
    class="container static px-4 py-8 mx-auto space-y-10 lg:space-y-16 lg:px-8 lg:py-12 xl:max-w-7xl"
  >
    <div>
      <h2 class="mb-2 text-3xl font-semibold">{{ model.project.name }}</h2>
      <h3
        class="mb-8 text-sm font-medium text-slate-500"
      >{{ __('customer.project.greeting', { name: $page.props.auth.user.first_name }) }}</h3>

      <div class="flex flex-col items-start gap-8 md:flex-row">
        <div class="w-full md:w-1/3 md:sticky md:top-[20%]">
          <!-- Card Item Start -->
          <div class="w-full p-4 bg-white rounded-md shadow">
            <h4 v-if="model.project.team" class="mb-3 text-sm font-semibold">
              {{ __('customer.labels.team') }}:
              <span
                class="text-slate-600"
              >{{ model.project.team?.name }}</span>
            </h4>

            <div class="mb-4">
              <p
                class="mb-2 text-sm font-medium text-slate-400"
              >{{ __('customer.labels.property') }}</p>
              <p
                class="text-sm font-semibold"
              >{{ model.project.address.address_1 }}, {{ model.project.address.city }}, {{ model.project.address.state }}</p>
            </div>

            <div class="mb-4">
              <!-- Start -->
              <div>
                <p class="mb-2 text-sm font-medium uppercase text-slate-400">{{ __('customer.labels.start') }}</p>
                <p class="text-sm">{{ formatDateZone(model.project.starts_at, 'MM/DD/YYYY HH:mm') }}</p>
              </div>

              <!-- Deadline -->
              <div class="mt-2">
                <p class="mb-2 text-sm font-medium uppercase text-slate-400">{{ __('customer.labels.deadline') }}</p>
                <p class="text-sm">{{ formatDateZone(model.project.ends_at, 'MM/DD/YYYY HH:mm') }}</p>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="inline-flex flex-wrap items-center gap-2">
                <p class="text-xs font-semibold">{{ __('customer.labels.status') }}</p>
                <div
                  class="px-2 py-1 text-sm text-center text-white bg-blue-500 rounded-md"
                >{{ model.project.status.name }}</div>
              </div>
            </div>
          </div>
          <!-- Card Item End -->
        </div>

        <!-- Right Section -->
        <div class="flex-1 w-full md:w-auto">
          <!-- Actions Card -->
          <div class="w-full px-4 py-3 mb-8 bg-white rounded-md shadow shadow-indigo-200">
            <h3 class="mb-3 text-sm font-semibold">
              <span class="text-slate-600">{{ __('customer.labels.actions') }}</span>
            </h3>

            <div class="flex items-center flex-wrap gap-3">
              <template v-if="model.project_not_approved">
                <AppButton
                  type="button"
                  @click="$eventBus.emit('toggle-project-reschedule-form')"
                >{{ __('customer.project.reschedule_button') }}</AppButton>

                <!-- Authorize Commencement -->
                <AppSuccessButton
                  v-if="model.can_authorize_start"
                  type="button"
                  @click="$eventBus.emit('toggle-project-authorization-form')"
                >{{ __('customer.project.authorize_button') }}</AppSuccessButton>
              </template>

              <!-- Mark as Completed -->
              <AppButton
                v-else-if="model.can_approve_completion"
                type="button"
                @click="$eventBus.emit('toggle-project-completion-approval-form')"
              >{{ __('customer.project.completion_approval_button') }}</AppButton>

              <!-- No Action -->
              <p v-else class="text-sm text-slate-500">{{ __('app.labels.no_action') }}</p>
            </div>
          </div>
          <!-- END Actions Card -->

          <!-- Summary -->
          <div class="w-full px-4 py-8 mb-8 bg-white rounded-md shadow shadow-indigo-200">
            <h3 class="mb-3 text-sm font-semibold">
              <span class="text-slate-600">{{ __('customer.labels.summary') }}</span>
            </h3>

            <div class="text-sm font-medium space-y-3">
              <p>
                {{ __('customer.labels.type') }}&colon;&nbsp;
                <span
                  class="text-slate-600 font-semibold"
                >{{ model.project.type.name }}</span>
              </p>

              <p>
                {{ __('customer.labels.date_loss_occurred') }}&colon;&nbsp;
                <span
                  class="text-slate-600 font-semibold"
                >{{ formatDateZone(model.project.loss_occurred_at) }}</span>
              </p>

              <p>
                {{ __('customer.labels.date_contacted') }}&colon;&nbsp;
                <span
                  class="text-slate-600 font-semibold"
                >{{ formatDateZone(model.project.contacted_at) }}</span>
              </p>
            </div>
          </div>
          <!-- END Summary -->

          <!-- Documents -->
          <div class="w-full px-4 py-8 mb-8 bg-white rounded-md shadow shadow-indigo-200">
            <h3 class="mb-3 text-sm font-semibold">
              <span class="text-slate-600">{{ __('customer.labels.documents') }}</span>
            </h3>

            <div class="font-medium space-y-3">
              <div
                v-for="document in model.authorization_documents"
                :key="document.id"
                class="space-y-4"
              >
                <div class="inline-flex items-center gap-2">
                  <span>{{ document.title }}&colon;</span>
                  <span
                    :class="[document.signed ? 'bg-indigo-200 text-indigo-600' : 'bg-slate-100 text-slate-600']"
                    class="px-2 py-2 rounded-full text-sm font-semibold"
                  >{{ document.signed ? __('customer.labels.document_signed') : __('customer.labels.document_not_signed') }}</span>
                </div>

                <div>
                  <AppButton
                    theme="info"
                    @click.prevent="$eventBus.emit('show-document-signature', document)"
                  >{{ __('customer.labels.document_view_signature') }}</AppButton>
                </div>
              </div>
            </div>
          </div>
          <!-- END Documents -->

          <!-- Daily Logs -->
          <div class="w-full px-4 py-8 mb-8 bg-white rounded-md shadow shadow-indigo-200">
            <h3 class="mb-3 text-sm font-semibold">
              <span class="text-slate-600">{{ __('customer.labels.daily_logs') }}</span>
            </h3>

            <div class="font-medium space-y-3">
              <!-- Empty Logs Alert -->
              <p
                v-if="model.project.logs?.length < 1"
                class="text-slate-500 font-medium"
              >{{ __('tenant.project.no_logs_found') }}</p>
              <!-- END Empty Logs Alert -->

              <!-- Log -->
              <div
                v-for="log in model.project.logs"
                :key="log.id"
                class="flex flex-col gap-3 px-2 py-2 rounded-md text-sm border-t first:border-t-0 border-slate-100"
              >
                <article class="text-gray-700 prose prose-sm lg:prose" v-html="log.body"></article>
                <h4
                  class="font-medium"
                >{{ __('tenant.project.log_posted_on', { date: formatDateZone(log.created_at), name: log.user?.name }) }}</h4>
              </div>
              <!-- END Log -->
            </div>
          </div>
          <!-- END Daily Logs -->
        </div>
      </div>
    </div>

    <ResheduleProjectFormModal :project="model.project" />

    <ProjectAuthorizationFormModal :model="model" />

    <ProjectCompletionApprovalFormModal :model="model" />

    <DocumentSignaturePreviewModal :replacements="model.replacements" />
  </div>
  <!-- END Page Section -->
</template>
