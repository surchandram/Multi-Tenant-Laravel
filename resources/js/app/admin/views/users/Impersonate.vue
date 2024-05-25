<script>
  export default {
    pageLayout: 'admin',
  };
</script>

<script setup>
  import { ref, onMounted, reactive, toRefs, computed, watch, inject } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps(['model']);

  const { model } = toRefs(props);

  const state = reactive({
    emailPlaceholder: 'Enter email address of user to impersonate',
  });

  const $scrollTo = inject('$scrollTo');

  const form = useForm({
    email: '',
  });

  const impersonate = () => {
    $scrollTo('body', { container: 'main' });

    form.post(route('admin.users.impersonate.store'));
  };

  onMounted(() => {});
</script>

<template>
  <Head title="Impersonate User | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold"> Impersonate User </span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppButton :href="route('admin.users.index')"> <i class="bi bi-people"></i> Back to Users </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <form
        action="#"
        @submit.prevent="impersonate"
      >
        <AppInputLabel
          for="email"
          class="block mb-3"
        >
          Enter email address
        </AppInputLabel>

        <AppInputGroup custom>
          <template #default="{ inputStyles }">
            <AppInput
              v-model="form.email"
              id="email"
              :class="inputStyles"
              class="flex-1"
              :placeholder="state.emailPlaceholder"
            />
          </template>

          <template #end>
            <!-- Submit Button -->
            <AppButton
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center gap-2 pt-2.5 pb-2.5 !mt-0 rounded-l-none"
            >
              <AppSpinner
                v-if="form.processing"
                size="4"
              />
              Impersonate
            </AppButton>
          </template>
        </AppInputGroup>

        <AppInputError
          class="mt-2"
          :message="form.errors.email"
        />
      </form>
      <!-- /Form -->
    </div>
  </div>
</template>
