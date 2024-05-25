<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import AppConfirmationDialogModal from "@/components/AppConfirmationDialogModal.vue";
  import DropdownMenu from "@/components/DropdownMenu.vue";

  defineProps(["model"]);

  const confirmDelete = async (company) => {
    $eventBus.emit("show-confirmation-dialog-modal");
  };
</script>

<template>
  <Head :title="`${__('admin.labels.company_details')} | ${__('admin.labels.dashboard_title')}`" />

  <div class="min-h-screen pb-16">
    <div class="space-y-4">
      <div class="flex items-start justify-between gap-3">
        <h3
          class="text-lg text-slate-700 font-semibold dark:text-slate-200"
        >{{ __('admin.labels.company_details') }}</h3>

        <!-- Actions Dropdown -->
        <DropdownMenu
          v-slot="{ hideDropdown }"
          content-wrapper="div"
          trigger-button
          content-classes="right-0"
        >
          <div class="w-48 flex flex-col z-[99999]">
            <AppButton
              :href="route('admin.companies.edit', model.company)"
              theme="outline-success"
              :rounded="false"
              class="inline-flex items-center"
              @click="hideDropdown"
            >
              <i class="bi bi-pencil mr-2"></i>
              {{ __('app.labels.edit') }}
            </AppButton>
            <!-- END Edit Link -->

            <AppButton
              theme="outline-danger"
              :rounded="false"
              class="inline-flex items-center"
              @click="confirmDelete(model.company)"
              @click.stop="hideDropdown"
            >
              <i class="bi bi-trash mr-2"></i>
              <span>{{ __('app.labels.delete') }}</span>
            </AppButton>
            <!-- END Delete Link -->
          </div>
        </DropdownMenu>
        <!-- END Actions Dropdown -->
      </div>

      <div class="p-7 space-y-4 rounded-md shadow-sm bg-white">
        <div class="py-2 space-y-3">
          <span class="text-slate-500">#</span>
          <span class="ml-1 text-lg font-medium">{{ model.company.id }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="py-2 space-y-2">
            <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.name') }}</h4>
            <p class="text-lg font-medium">{{ model.company.name }}</p>
          </div>

          <div class="py-2 space-y-2">
            <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.company_domain') }}</h4>
            <p class="text-lg font-medium">{{ model.company.domain }}.{{ $page.props.appDomain }}</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="py-2 space-y-2">
            <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.default_tax') }}</h4>
            <p class="text-lg font-medium">{{ model.company.default_tax }}</p>
          </div>

          <div class="py-2 space-y-2">
            <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.license_no') }}</h4>
            <p class="text-lg font-medium">{{ model.company.license_no }}</p>
          </div>

          <div class="py-2 space-y-2">
            <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.tax_id') }}</h4>
            <p class="text-lg font-medium">{{ model.company.tax_id }}</p>
          </div>
        </div>

        <div class="py-2 space-y-2">
          <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.address') }}</h4>
          <p class="text-lg font-medium">
            <span
              v-if="model.company.address"
            >{{ model.company.address.formattedAddress }}, {{ model.company.address.country?.name }}</span>
            <span v-else>{{ __('app.address.not_provided') }}</span>
          </p>
        </div>

        <div class="py-2 space-y-2">
          <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.email') }}</h4>
          <p class="text-lg font-medium">{{ model.company.email }}</p>
        </div>

        <div class="py-2 space-y-2">
          <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.subscription') }}</h4>

          <p class="text-lg font-medium">
            <span
              v-if="model.company.has_subscription"
            >{{ model.company.subscription_plan?.name }} ({{ model.company.subscription_plan?.formatted_price }} / {{ model.company.subscription_plan?.formatted_interval }})</span>
            <span v-else>{{ __('app.labels.not_subscribed') }}</span>
          </p>
        </div>

        <div class="py-2 space-y-2">
          <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.joined_on') }}</h4>
          <p class="text-lg font-medium">{{ model.company.created_at }}</p>
        </div>

        <div class="py-2 space-y-2">
          <h4 class="text-sm font-semibold text-slate-500">{{ __('app.labels.company_users') }}</h4>
          <p class="text-lg font-medium">{{ model.company.users_count }}</p>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div>
      <AppConfirmationDialogModal
        :title="__('app.labels.delete_confirmation')"
        :confirm-label="__('app.labels.delete')"
        :message="__('admin.company.delete_confirmation', { name: model.company.name })"
      >
        <template #confirmButton="{ closeModal }">
          <AppButton
            :href="route('admin.companies.destroy', model.company)"
            as="button"
            method="DELETE"
            theme="danger"
            @success="() => closeModal()"
          >{{ __('app.labels.delete') }}</AppButton>
        </template>
      </AppConfirmationDialogModal>
    </div>
    <!-- END Delete Confirmation Modal -->
  </div>
</template>
