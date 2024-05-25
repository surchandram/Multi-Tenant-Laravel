<script>
  export default {
    pageLayout: 'admin',
  };
</script>

<script setup>
  import { inject, onMounted, ref, watch } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const roleId = ref(null);

  const props = defineProps(['model']);

  const form = useForm({
    name: '',
    email: '',
    role_id: '',
    role_expires_at: '',
  });

  onMounted(() => {
    watch(
      () => _.cloneDeep(form),
      (formData, oldData) => {
        //
      },
    );
  });

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body') => {
    $scrollTo(el, { container: 'main' });
  };

  const store = () => {
    form.clearErrors();
    scrollTo();

    form
      .transform((data) => ({
        ...data,
      }))
      .post(route('admin.users.store'), {
        //
      });
  };
</script>

<template>
  <Head title="New User | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- Heading Area -->
    <div class="w-full flex md:items-center justify-between px-6 mb-3">
      <!-- Heading -->
      <div class="mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">New User</h1>

        <p>An invitation link will be emailed to the user to complete registration.</p>
      </div>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-center gap-3">
        <div class="flex items-center gap-2">
          <!-- Actions -->
          <div class="inline-flex items-center">
            <!-- Invite Button -->
            <div class="flex items-center justify-end lg:justify-start">
              <AppButton
                type="submit"
                class="inline-flex items-center gap-2"
                :disabled="form.processing"
                @click.prevent="store"
              >
                <AppSpinner
                  v-show="form.processing"
                  :size="4"
                />
                <i
                  v-show="!form.processing"
                  class="bi bi-send"
                ></i>
                Invite
              </AppButton>
            </div>
          </div>
          <!-- /Actions -->
        </div>
      </div>
    </div>
    <!-- /Heading Area -->

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <form
        action="#"
        @submit.prevent="store"
      >
        <AppValidationErrors :errors="form.errors" />

        <!-- Name -->
        <div class="mt-4">
          <AppInputLabel for="name">Name</AppInputLabel>

          <AppInput
            id="name"
            v-model="form.name"
            class="w-full mt-2"
            name="name"
          />

          <AppInputError
            class="mt-2"
            :message="form.errors.name"
          />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
          <AppInputLabel
            for="email"
            class="block mb-2"
            >Email Address</AppInputLabel
          >

          <AppInput
            id="email"
            v-model="form.email"
            type="email"
            class="w-full mt-2"
            name="email"
          />

          <AppInputError
            class="mt-2"
            :message="form.errors.email"
          />
        </div>

        <!-- Role -->
        <div class="mt-4">
          <AppInputLabel
            for="role_id"
            class="block mb-2"
            >Role</AppInputLabel
          >

          <select
            id="role_id"
            ref="roleId"
            v-model="form.role_id"
            class="w-full mt-2 rounded"
            name="role_id"
          >
            <option value>Choose role</option>
            <option
              v-for="role in model.roles"
              :key="role.id"
              :value="role.id"
              :disabled="form.children_count"
              class="disabled:text-slate-400"
            >
              {{ role.parent?.name }} {{ role.name }}
            </option>
          </select>

          <AppInputError
            class="mt-2"
            :message="form.errors.role_id"
          />
        </div>

        <!-- Role expires at -->
        <div class="mt-4">
          <AppInputLabel for="role_expires_at">Role expires at</AppInputLabel>

          <AppInput
            id="role_expires_at"
            v-model="form.role_expires_at"
            class="w-full mt-2"
            name="role_expires_at"
          />

          <AppInputError
            class="mt-2"
            :message="form.errors.role_expires_at"
          />
        </div>

        <div class="mt-4">
          <div class="flex items-baseline justify-end gap-3">
            <!-- Invite Button -->
            <AppButton
              type="submit"
              class="flex items-center gap-2"
              :disabled="form.processing"
            >
              <AppSpinner
                v-show="form.processing"
                :size="4"
              />
              <i
                v-show="!form.processing"
                class="bi bi-send"
              ></i>
              Invite
            </AppButton>
          </div>
        </div>
      </form>
      <!--/ Form -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
