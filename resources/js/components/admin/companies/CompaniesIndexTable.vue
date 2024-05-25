<script setup>
  import { ref } from 'vue';
  import AppButton from '@/components/AppButton.vue';
  import AppConfirmationDialogModal from '@/components/AppConfirmationDialogModal.vue';
  import DropdownMenu from '@/components/DropdownMenu.vue';

  defineProps({
    companies: {
      type: Array,
      required: true,
    },
  });

  const deleteData = ref(null);

  const confirmDelete = async (company) => {
    deleteData.value = company;

    $eventBus.emit('show-confirmation-dialog-modal');
  };
</script>

<template>
  <div class="flex flex-col">
    <div
      class="hidden md:grid grid-cols-1 md:grid-cols-4 items-center justify-start gap-2 md:gap-6 px-2 md:px-0 py-4 text-slate-600 bg-slate-200 text-sm font-medium"
    >
      <div class="px-4 py-2">{{ __('app.labels.company_name') }}</div>
      <div class="px-4 py-2">{{ __('app.labels.address') }}</div>
      <div class="px-4 py-2">{{ __('app.labels.subscription') }}</div>
      <div class="px-4 py-2">&nbsp;</div>
    </div>

    <div
      v-for="company in companies"
      :key="company.id"
      class="grid grid-cols-1 md:grid-cols-4 items-center justify-start gap-4 md:gap-6 px-2 md:px-0 py-3 text-slate-600 hover:bg-slate-50"
    >
      <div class="px-2 md:px-4">
        <h4 class="py-2 text-indigo-600 font-medium">{{ company.name }}</h4>
      </div>

      <div class="px-2 md:px-4 font-medium text-sm">
        <span>{{ company.address?.formattedAddress }}</span>
      </div>

      <div class="px-2 md:px-4 font-medium">
        <p
          :class="[company.has_subscription ? 'bg-indigo-200' : 'bg-slate-200']"
          class="inline-flex px-4 py-2 rounded-full text-indigo-600"
        >
          {{ company.has_subscription ? __('app.labels.subscribed') : __('app.labels.not_subscribed') }}
        </p>
      </div>

      <div class="flex items-center justify-end md:justify-start gap-3 px-2 md:px-4">
        <DropdownMenu
          v-slot="{ hideDropdown }"
          content-wrapper="div"
          trigger-button
          content-classes="right-0"
        >
          <div class="w-48 flex flex-col z-[99999]">
            <AppButton
              :href="route('admin.companies.show', company)"
              theme="outline-info"
              :rounded="false"
              class="inline-flex items-center"
              @click="hideDropdown"
            >
              <i class="bi bi-arrow-right mr-2"></i>
              {{ __('app.labels.view') }}
            </AppButton>
            <!-- END View Link -->

            <AppButton
              :href="route('admin.companies.edit', company)"
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
              @click="confirmDelete(company)"
              @click.prevent="hideDropdown"
            >
              <i class="bi bi-trash mr-2"></i>
              <span>{{ __('app.labels.delete') }}</span>
            </AppButton>
            <!-- END Delete Link -->
          </div>
        </DropdownMenu>
      </div>
    </div>

    <div v-if="deleteData">
      <AppConfirmationDialogModal
        :title="__('app.labels.delete_confirmation')"
        :confirm-label="__('app.labels.delete')"
        :message="__('admin.company.delete_confirmation', { name: deleteData.name })"
      >
        <template #confirmButton="{ closeModal }">
          <AppButton
            :href="route('admin.companies.destroy', deleteData)"
            as="button"
            method="DELETE"
            theme="danger"
            @success="() => closeModal()"
            >{{ __('app.labels.delete') }}</AppButton
          >
        </template>
      </AppConfirmationDialogModal>
    </div>
  </div>
</template>
