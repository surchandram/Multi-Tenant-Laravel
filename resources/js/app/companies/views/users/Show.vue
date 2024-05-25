<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { watch } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps(['model']);

  const form = useForm({
    role_id: props.model.current_role?.id,
    team_id: props.model.current_team?.id,
  });

  const teamForm = useForm({
    user_id: props.model.user.id,
    team_id: props.model.current_team?.id,
  });

  const store = () => {
    form.clearErrors();

    form.patch(route('companies.users.roles.update', { company: props.model.company, user: props.model.user }), {
      onSuccess: () => {
        form.reset();
      },
    });
  };

  const updateTeam = () => {
    teamForm.clearErrors();

    teamForm.post(route('companies.teams.users.store', props.model.company.id), {
      onSuccess: () => {
        teamForm.defaults();
        teamForm.reset();
      },
    });
  };
</script>

<template>
  <Head :title="`Company User | ${model.company.name}`" />

  <div class="flex flex-col">
    <div class="w-full xl:w-10/12 mx-auto mb-12 xl:mb-0 px-4">
      <!-- Header -->
      <div class="w-full flex flex-col md:flex-row md:items-center mb-5">
        <div class="px-4 flex-1">
          <h3 class="font-semibold text-xl text-slate-700">
            {{ model.user.name }}
          </h3>
        </div>

        <aside class="flex items-center gap-2 px-4 ml-auto text-right">
          <!-- Back -->
          <AppLightButton
            :href="route('companies.users.index', model.company)"
            type="button"
          >
            <i class="bi bi-chevron-left leading-none"></i> Back
          </AppLightButton>
        </aside>
      </div>
      <!-- /Header -->

      <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 pb-4 shadow-lg rounded">
        <div class="px-4 py-3">
          <h4 class="text-lg font-medium">Update user's role.</h4>
        </div>

        <!-- Form Wrapper -->
        <div class="block w-full">
          <div class="px-4 py-4">
            <AppValidationErrors
              class="mb-4"
              :errors="form.errors"
            />

            <form
              method="POST"
              action="#"
              @submit.prevent="store"
            >
              <!-- Role -->
              <div class="form-group mt-4">
                <AppInputLabel
                  for="role"
                  class="form-label inline-flex mb-2"
                >
                  Role
                </AppInputLabel>

                <select
                  id="role"
                  v-model="form.role_id"
                  v-choicesjs
                  name="role"
                  class="form-control w-full flex-1"
                >
                  <option value="">Choose Role</option>
                  <option
                    v-for="role in model.roles"
                    :key="role.id"
                    :value="role.id"
                  >
                    {{ role.name }}
                  </option>
                </select>

                <AppInputError
                  :message="form.errors.role_id"
                  class="mt-2"
                />
              </div>
              <!-- /.form-group -->

              <div class="form-group flex items-center justify-end mt-4">
                <AppButton
                  class="flex items-center gap-1 mr-1 mb-1"
                  type="submit"
                  :disabled="form.processing"
                >
                  <AppSpinner
                    v-if="form.processing"
                    :size="4"
                  />
                  Update
                </AppButton>
              </div>
            </form>
          </div>
        </div>
        <!-- /Form Wrapper -->
      </div>

      <div class="w-full py-6 border-t border-slate-400"></div>

      <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 pb-4 shadow-lg rounded">
        <div class="px-4 py-3">
          <h4 class="text-lg font-medium">Update user's team.</h4>
        </div>

        <!-- Form Wrapper -->
        <div class="block w-full">
          <div class="px-4 py-4">
            <AppValidationErrors
              class="mb-4"
              :errors="teamForm.errors"
            />

            <form
              method="POST"
              action="#"
              @submit.prevent="updateTeam"
            >
              <!-- Team -->
              <div class="form-group mt-4">
                <AppInputLabel
                  for="team"
                  class="form-label inline-flex mb-2"
                >
                  Team
                </AppInputLabel>

                <select
                  id="team"
                  v-model="teamForm.team_id"
                  v-choicesjs
                  name="team"
                  class="form-control w-full flex-1"
                >
                  <option value="">Choose Team</option>
                  <option
                    v-for="team in model.teams"
                    :key="team.id"
                    :value="team.id"
                  >
                    {{ team.name }}
                  </option>
                </select>

                <AppInputError
                  :message="teamForm.errors.team_id"
                  class="mt-2"
                />
              </div>
              <!-- /.form-group -->

              <div class="form-group flex items-center justify-end mt-4">
                <AppButton
                  class="flex items-center gap-1 mr-1 mb-1"
                  type="submit"
                  :disabled="teamForm.processing"
                >
                  <AppSpinner
                    v-if="teamForm.processing"
                    :size="4"
                  />
                  Update
                </AppButton>
              </div>
            </form>
          </div>
        </div>
        <!-- /Form Wrapper -->
      </div>
    </div>
  </div>
</template>
