<script setup>
  import AppButton from "@/components/AppButton.vue";
  import AppCheckbox from "@/components/AppCheckbox.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import { useForm } from "@inertiajs/vue3";
  import { useModal } from "momentum-modal";

  const props = defineProps(["model"]);

  const { redirect } = useModal();

  const form = useForm({
    allowed: props.model.defaults || [],
  });
</script>

<template>
  <div class="w-full h-full fixed top-0 z-[9999] bg-indigo-100 bg-opacity-70"></div>
  <div
    class="w-full h-screen md:max-w-sm xl:max-w-lg flex fixed top-0 right-0 z-[9999] overflow-hidden"
  >
    <div class="min-w-full h-full p-7 ml-auto bg-white overflow-y-auto">
      <div class="flex items-start justify-between gap-3">
        <div class="pr-2 space-y-2">
          <h3 class="font-medium text-slate-600">
            <i class="bi bi-gear"></i>
            {{ __('tenant.labels.project_report_setup') }}
          </h3>

          <p class="text-sm font-medium text-indigo-400">{{ model.project.name }}</p>

          <p class="text-sm font-medium text-slate-700">
            <span class="text-slate-500">{{ __('tenant.labels.type') }}</span>
            : {{ model.project.type.name }}
          </p>
        </div>

        <aside class="flex items-center gap-3">
          <!-- Export Report -->
          <AppButton
            native
            target="_blank"
            theme="info"
            :href="route('restore.projects.reports.generate', { project: model.project, setup: form.allowed })"
          >
            <span class="sr-only">{{ __('tenant.labels.export_report') }}</span>
            <i class="bi bi-download"></i>
          </AppButton>
          <!-- END Export Report -->

          <!-- Close -->
          <AppLightButton @click="redirect">
            <i class="bi bi-x-lg"></i>
          </AppLightButton>
          <!-- END Close -->
        </aside>
      </div>

      <div class="border-t-2 border-indigo-200 my-8"></div>

      <div class="space-y-6">
        <p class="text-sm font-medium">{{ __('tenant.project.report_setup_prompt') }}</p>

        <div v-for="(label, key) in model.config" :key="key" class="flex items-center gap-2">
          <AppCheckbox :id="key" v-model="form.allowed" :value="key" />
          <AppInputLabel :for="key" class="font-medium text-slate-700">{{ label }}</AppInputLabel>
        </div>
      </div>

      <div class="border-t-2 border-indigo-200 my-8"></div>

      <div class="flex items-center justify-end gap-3">
        <!-- Close -->
        <AppLightButton class="gap-3 border-2 border-slate-200" @click="redirect">
          <i class="bi bi-x-lg"></i>
          {{ __('app.buttons.cancel') }}
        </AppLightButton>
        <!-- END Close -->

        <!-- Export Report -->
        <AppButton
          native
          target="_blank"
          theme="info"
          class="space-x-2"
          :href="route('restore.projects.reports.generate', { project: model.project, setup: form.allowed })"
        >
          <i class="bi bi-download"></i>
          <span>{{ __('tenant.labels.export_report') }}</span>
        </AppButton>
        <!-- END Export Report -->
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
