<script setup>
  import { watch, onMounted } from "vue";
  import { useForm, usePage } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import AppTextarea from "@/components/AppTextarea.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppSpinner from "@/components/AppSpinner.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import { useMomentJS } from "@/composables/momentjs";

  const form = useForm({
    body: "",
  });

  const emit = defineEmits(["close", "toggle-close"]);

  const { formatDateZone } = useMomentJS();

  const store = () => {
    form.post(route("restore.projects.logs.store", usePage().props.model?.project), {
      onSuccess: () => {
        form.reset();
        setTimeout(() => {
          emit("close");
        }, 500);
      },
    });
  };

  onMounted(() => {
    watch(
      () => form.processing,
      () => {
        emit("toggle-close");
      }
    );
  });
</script>

<template>
  <div class="px-4 py-2 space-y-8">
    <h3 class="text-lg text-slate-500 font-medium">{{ __('tenant.labels.create_log') }}</h3>

    <form action="#" class="space-y-6" @submit.prevent="store">
      <AppValidationErrors v-if="form.hasErrors" :errors="form.errors" />

      <!-- Body -->
      <div>
        <AppTextarea v-model="form.body" rows="6" />
        <AppInputError :message="form.errors.body" />
      </div>
      <!-- END Body -->

      <div class="flex items-center justify-end">
        <AppButton type="submit" class="inline-flex items-center gap-2" :disabled="form.processing">
          <AppSpinner v-if="form.processing" :size="4" />
          {{ __('tenant.labels.add_log') }}
        </AppButton>
      </div>
    </form>
  </div>
</template>
