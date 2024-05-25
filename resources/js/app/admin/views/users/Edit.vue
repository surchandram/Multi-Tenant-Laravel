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
  import AppLightButton from '@/components/AppLightButton.vue';
  import DropdownMenu from '@/components/DropdownMenu.vue';
  import ChevronDown from '@/components/ChevronDown.vue';
  import AppConfirmationDialogModal from '@/components/AppConfirmationDialogModal.vue';
  import { useFlatpickr } from '@/composables/flatpickr.js';

  import moment from 'moment';

  import 'vue-good-table-next/dist/vue-good-table-next.css';
  import { VueGoodTable } from 'vue-good-table-next';
  import EditUserRoleModal from './partials/EditUserRoleModal.vue';

  const roleId = ref(null);

  const props = defineProps(['model']);

  const $eventBus = inject('$eventBus');

  const { singleDatePicker } = useFlatpickr({
    boot: false,
    pickers: 'date',
    singleDate: {
      minDate: moment(Date.now()).add(24.1, 'hours').format('Y-MM-DD H:m'),
      dateFormat: 'Y-m-d H:i',
      enableTime: true,
    },
  });

  const columns = [
    {
      label: '#',
      field: 'id',
      filterable: false,
      sortable: false,
    },
    {
      label: 'Name',
      field: 'name',
    },
    {
      label: 'Expires',
      field: 'expires_at',
      formatFn: (value) => {
        return value ? moment(value).format('MM/DD/YYYY') : '';
      },
      sortable: false,
    },
    {
      label: 'Assigned',
      field: 'role_assigned_at',
      formatFn: (value) => {
        return value ? moment(value).format('MM/DD/YYYY') : '';
      },
      sortable: false,
    },
    {
      label: 'Action',
      field: 'action',
      sortable: false,
    },
  ];

  const dateFormat = (value) => moment(value).format('MM/DD/YYYY');

  onMounted(() => {
    // setup date pickers
    singleDatePicker('.datepicker_role_expires_at');
  });

  const confirmDelete = (data) => {
    $eventBus.emit('show-confirmation-dialog-modal', {
      title: `Revoke Role Confirmation`,
      message: `Are you sure you want to revoke '${data.name}' role from ${props.model.user.name}?`,
      callback: () => {
        destroyActionForm.delete(route('admin.users.roles.destroy', [props.model.user, data]), {
          onSuccess: () => {
            $eventBus.emit('hide-confirmation-dialog-modal');
          },
        });
      },
    });
  };

  const destroyActionForm = useForm({});

  const form = useForm({
    role_id: '',
    expires_at: '',
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
      .post(route('admin.users.roles.store', props.model.user), {
        //
      });
  };
</script>

<template>
  <Head title="New User | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Assign Role Form -->
      <div class="w-full px-6 py-4 rounded-md bg-white shadow-md">
        <!-- Heading Area -->
        <div class="w-full flex md:items-center justify-between mb-3">
          <!-- Heading -->
          <div>
            <h3 class="text-slate-800 text-lg font-semibold">
              {{ model.user.name }}
            </h3>
            <p>Manage user's details and roles.</p>
          </div>

          <!-- Aside -->
          <div class="flex flex-col md:flex-row md:items-center gap-3">
            <div class="flex items-center gap-2">
              <!-- Actions -->
              <div class="inline-flex items-center"></div>
              <!-- /Actions -->
            </div>
          </div>
        </div>
        <!-- /Heading Area -->

        <!-- Form -->
        <form
          action="#"
          @submit.prevent="store"
        >
          <AppValidationErrors :errors="form.errors" />

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
            <AppInputLabel for="expires_at">Role expires at</AppInputLabel>

            <AppInput
              id="expires_at"
              v-model="form.expires_at"
              class="w-full mt-2 datepicker_role_expires_at"
              name="expires_at"
            />

            <AppInputError
              class="mt-2"
              :message="form.errors.expires_at"
            />
          </div>

          <!-- Actions -->
          <div class="mt-4">
            <div class="flex items-baseline justify-end gap-3">
              <!-- Assign Button -->
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
                Assign Role
              </AppButton>
            </div>
          </div>
        </form>
        <!--/ Form -->
      </div>
      <!-- Assign Role Form -->

      <!-- User Roles Managenent -->
      <div class="w-full mt-12">
        <div class="space-y-4">
          <h3 class="text-lg font-semibold">Roles</h3>

          <!-- Table -->
          <div class="datatable-wrapper mt-4">
            <vue-good-table
              :columns="columns"
              :rows="model.user.roles"
              :total-rows="model.user.roles.length"
              :pagination-options="{
                enabled: true,
                perPage: 10,
                total: model.user.roles.length,
                perPageDropdownEnabled: false,
                dropdownAllowAll: false,
              }"
              :sort-options="{
                enabled: true,
                multipleColumns: true,
              }"
              style-class="vgt-table striped"
            >
              <!-- Row Slot -->
              <template #table-row="props">
                <!-- Action column -->
                <div
                  v-if="props.column.field == 'action'"
                  class="flex items-center gap-2"
                >
                  <span v-if="props.row.expired">Role Expired</span>

                  <DropdownMenu
                    v-else
                    :positioned="false"
                    content-wrapper="div"
                    content-classes="w-64 flex flex-col gap-2 left-auto right-0"
                  >
                    <template #trigger="{ showDropdown, toggleDropdown }">
                      <AppLightButton
                        class="inline-flex items-center gap-2"
                        type="button"
                        @click="toggleDropdown"
                      >
                        Actions
                        <div>
                          <ChevronDown :open="showDropdown" />
                        </div>
                      </AppLightButton>
                    </template>

                    <!-- Content -->
                    <!-- Edit -->
                    <AppButton
                      class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
                      plain
                      @click.prevent="
                        $eventBus.emit('show-edit-user-role-modal', {
                          role: props.row,
                          user: model.user,
                        })
                      "
                    >
                      <i class="bi bi-pencil"></i>
                      Edit
                    </AppButton>

                    <!-- Delete -->
                    <AppButton
                      class="inline-flex items-center gap-2 text-red-600 hover:bg-red-200 rounded-none"
                      type="button"
                      plain
                      @click.prevent="confirmDelete(props.row)"
                    >
                      <i class="bi bi-trash"></i>
                      Revoke
                    </AppButton>
                  </DropdownMenu>
                </div>

                <!-- Status Field with parent -->
                <div v-else-if="props.column.field == 'expires_at'">
                  <span
                    v-if="props.row.expired"
                    class="px-2 py-1 text-xs font-semibold text-red-100 bg-red-600 rounded-full whitespace-nowrap"
                  >
                    Expired
                  </span>
                </div>

                <span
                  v-else
                  class="text-sm"
                  :class="{
                    'text-slate-700 font-semibold': props.column.field == 'key',
                  }"
                >
                  <a
                    v-if="props.column.field == 'name'"
                    href="#"
                    :style="{
                      'margin-left': `${props.row.depth}em`,
                    }"
                    :class="{
                      'font-semibold': props.row.depth == 0,
                    }"
                    @click.prevent="$eventBus.emit('show-role', props.row)"
                  >
                    {{ props.formattedRow[props.column.field] }}
                  </a>
                  <template v-else>{{ props.formattedRow[props.column.field] }}</template>
                </span>
              </template>
            </vue-good-table>
          </div>
          <!--/ Table -->
        </div>
      </div>
      <!-- /User Roles Management -->

      <!-- AppConfirmationDialogModal -->
      <AppConfirmationDialogModal
        title="Delete Confirmation"
        confirm-label="Yes, revoke it"
      />
      <!-- /AppConfirmationDialogModal -->

      <!-- EditUserRoleModal -->
      <EditUserRoleModal />
      <!-- /EditUserRoleModal -->
    </div>
    <!-- /Content Area -->
  </div>
</template>

<style>
  .datatable-wrapper .vgt-responsive {
    position: static !important;
  }
</style>
