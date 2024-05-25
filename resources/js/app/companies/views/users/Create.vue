<script>
  export default {
    pageLayout: 'company_settings',
  };
</script>

<script setup>
  import { watch } from 'vue';
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps(['model']);

  const form = useForm({
    name: '',
    email: '',
    role_id: '',
    team_id: '',
  });

  watch(
    () => form.name,
    (value) => {
      form.domain = window.domainSlugger(value);
    },
  );

  const store = () => {
    form.clearErrors();

    form.post(route('companies.users.store', props.model.company), {
      onSuccess: () => {
        form.reset();
      },
    });
  };
</script>

<template>
  <Head :title="`Add Company User | ${model.company.name}`" />

  <div class="flex flex-col">
    <div class="w-full xl:w-10/12 mx-auto mb-12 xl:mb-0 px-4">
      <!-- Header -->
      <div class="w-full flex flex-col md:flex-row md:items-center mb-5">
        <div class="px-4 flex-1">
          <h3 class="font-semibold text-xl text-slate-700">Add company user</h3>
        </div>

        <aside class="flex items-center gap-2 px-4 ml-auto text-right">
          <AppButton
            type="submit"
            @click.prevent="store"
          >
            Invite
          </AppButton>

          <!-- Cancel -->
          <AppLightButton
            :href="route('companies.users.index', model.company)"
            type="button"
          >
            Cancel
          </AppLightButton>
        </aside>
      </div>
      <!-- /Header -->

      <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 pb-4 shadow-lg rounded">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
          <p>Fill in details below to invite a user to the company.</p>
        </div>

        <!-- Form Wrapper -->
        <div class="block w-full overflow-x-auto">
          <div class="px-4 py-4">
            <AppValidationErrors
              class="mb-4"
              :errors="form.errors"
            />

            <form
              x-data="{
                  changed(event) {
                      document.getElementById('name').value = window.domainNamer(event.target.value)
                      document.getElementById('domain').value = window.domainSlugger(event.target.value)
                  }
              }"
              method="POST"
              action="#"
              @submit.prevent="store"
            >
              <!-- Name -->
              <div class="form-group">
                <AppInputLabel
                  for="name"
                  class="form-label inline-flex mb-2"
                >
                  Name
                </AppInputLabel>

                <AppInput
                  id="name"
                  v-model="form.name"
                  x-data=""
                  type="text"
                  name="name"
                  class="form-control"
                  required
                />

                <AppInputError
                  :message="form.errors.name"
                  class="mt-2"
                />
              </div>
              <!-- /.form-group -->

              <!-- Email Address -->
              <div class="form-group mt-4">
                <AppInputLabel
                  for="email"
                  class="form-label inline-flex mb-2"
                >
                  Email
                </AppInputLabel>

                <AppInput
                  id="email"
                  v-model="form.email"
                  class="form-control"
                  type="email"
                  name="email"
                  required
                />

                <AppInputError
                  :message="form.errors.email"
                  class="mt-2"
                />
              </div>
              <!-- /.form-group -->

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
                  required
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
                  v-model="form.team_id"
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
                  :message="form.errors.team_id"
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
                  Invite
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
