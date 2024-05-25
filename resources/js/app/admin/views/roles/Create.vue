<script>
  export default {
    pageLayout: 'admin',
  };
</script>

<script setup>
  import { inject, onMounted, ref, watch } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const typeId = ref(null);
  const parentId = ref(null);
  const permissionIds = ref(null);

  const props = defineProps(['model']);

  const form = useForm({
    name: '',
    type: 'admin',
    parent_id: '',
    description: '',
    usable: true,
    permissions: _.map(props.model.role.roles, 'id'),
  });

  const filteredPermissions = ref(_.filter(props.model.permissions, ['type', form.type]));

  var choicesJS;

  const mapChoices = (data) => {
    return _.map(data, (o) => {
      return {
        value: o.id,
        label: o.name,
      };
    });
  };

  const updatePermissionChoices = (choices) => {
    choicesJS.clearStore();
    form.permissions = [];
    choicesJS.setChoices(choices);
  };

  const onBooted = function (choiceJSInstance) {
    choicesJS = choiceJSInstance;
  };

  onMounted(() => {
    watch(
      () => _.cloneDeep(form),
      (formData, oldData) => {
        if (formData.type != oldData.type) {
          form.parent_id = '';
          updatePermissionChoices(mapChoices(_.filter(props.model.permissions, (p) => p.type == formData.type)));
        }
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
      .post(route('admin.roles.store'), {
        //
      });
  };
</script>

<template>
  <Head title="New Role | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- Heading Area -->
    <div class="w-full flex md:items-center px-6 mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">New Role</h1>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-center gap-3">
        <div class="flex items-center gap-2">
          <!-- Actions -->
          <div class="inline-flex items-center">
            <!-- Save Button -->
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
                  class="bi bi-check"
                ></i>
                Save
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

        <div class="mt-2">
          <AppInputLabel class="inline-flex items-center gap-1">
            <AppCheckbox v-model="form.usable" />
            Live
          </AppInputLabel>
        </div>

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

        <!-- Type -->
        <div class="mt-4">
          <AppInputLabel
            for="type"
            class="block mb-2"
            >Type</AppInputLabel
          >

          <select
            id="type"
            ref="typeId"
            v-model="form.type"
            v-choicesjs
            class="w-full mt-2"
            name="type"
          >
            <option value>Choose type</option>
            <option
              v-for="(type, key) in model.types"
              :key="key"
              :value="key"
            >
              {{ type }}
            </option>
          </select>

          <AppInputError
            class="mt-2"
            :message="form.errors.type"
          />
        </div>

        <!-- Parent -->
        <div class="mt-4">
          <AppInputLabel
            for="parent_id"
            class="block mb-2"
            >Parent</AppInputLabel
          >

          <select
            id="parent_id"
            ref="parentId"
            v-model="form.parent_id"
            class="w-full mt-2 rounded"
            name="parent_id"
          >
            <option value>Choose parent</option>
            <option
              v-for="role in model.roles"
              :key="role.id"
              :value="role.id"
              :disabled="form.type != '' && form.type != role.type"
              class="disabled:text-slate-400"
            >
              {{ role.parent?.name }} {{ role.name }}
            </option>
          </select>

          <AppInputError
            class="mt-2"
            :message="form.errors.parent_id"
          />
        </div>

        <!-- Permissions -->
        <div
          v-if="filteredPermissions.length"
          class="mt-4"
        >
          <AppInputLabel
            for="roles"
            class="block mb-2"
            >Permissions</AppInputLabel
          >

          <select
            id="permissions"
            ref="permissionIds"
            v-model="form.permissions"
            v-choicesjs="{
              addItems: true,
              removeItemButton: true,
              duplicateItemsAllowed: false,
              editItems: true,
              onBooted: onBooted,
            }"
            multiple
            class="w-full mt-2"
            name="permissions"
          >
            <option value>Choose permissions</option>
            <option
              v-for="permission in filteredPermissions"
              :key="permission.id"
              :value="permission.id"
            >
              {{ permission.name }}
            </option>
          </select>

          <AppInputError
            class="mt-2"
            :message="form.errors.permissions"
          />
        </div>

        <!-- Description -->
        <div class="mt-4">
          <AppInputLabel for="description">Description</AppInputLabel>

          <AppInput
            id="description"
            v-model="form.description"
            class="w-full mt-2"
            name="description"
          />

          <AppInputError
            class="mt-2"
            :message="form.errors.description"
          />
        </div>

        <div class="mt-4">
          <div class="flex items-baseline justify-end gap-3">
            <!-- Save Button -->
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
                class="bi bi-check"
              ></i>
              Save
            </AppButton>
          </div>
        </div>
      </form>
      <!--/ Form -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
