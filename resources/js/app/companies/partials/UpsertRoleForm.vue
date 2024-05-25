<script setup>
  import { inject, onMounted, ref, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import { filter, get, map } from 'lodash';
  import AppButton from '@/components/AppButton.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';

  const props = defineProps({
    model: {
      type: Object,
      required: true,
    },
    company: {
      type: Object,
      required: true,
    },
    roles: {
      type: Array,
      required: true,
    },
    permissions: {
      type: Array,
      required: true,
    },
    role: {
      type: Object,
      default: () => {},
    },
    editing: {
      type: Boolean,
      default: false,
    },
  });

  const emit = defineEmits(['cancel', 'created', 'updated']);

  const typeId = ref(null);
  const parentId = ref(null);

  const form = useForm({
    name: props.role?.name || '',
    type: props.role?.type || 'admin',
    parent_id: props?.role?.parent_id || '',
    description: props.role?.description || '',
    usable: get(props.role, 'usable', true),
    permissions: map(props.role?.permissions, 'id'),
  });

  const $scrollTo = inject('$scrollTo');

  onMounted(() => {
    $scrollTo('#UpsertRoleForm');
  });

  // const { form } = upsertTeamPage(props.model, props.editing);

  const store = () => {
    form.clearErrors();

    if (!props.editing) {
      form
        .transform((data) => ({
          ..._.omit(data, '_method'),
        }))
        .post(route('companies.roles.store', props.company), {
          onSuccess: () => {
            form.reset();
            emit('created');
          },
        });
    } else {
      form
        .transform((data) => ({
          ...data,
          _method: 'patch',
        }))
        .post(
          route('companies.roles.update', {
            company: props.company,
            role: props.role,
          }),
          {
            onSuccess: () => {
              // fire alert
              emit('updated');
            },
          },
        );
    }
  };
</script>

<template>
  <div id="UpsertRoleForm">
    <form
      method="POST"
      action="#"
      @submit.prevent="store"
    >
      <AppValidationErrors
        v-if="form.hasErrors"
        class="mb-8"
        :errors="form.errors"
      />

      <div class="mt-2">
        <AppInputLabel
          id="usable"
          class="inline-flex items-center gap-2"
        >
          <AppCheckbox
            id="usable"
            v-model="form.usable"
          />Live
        </AppInputLabel>
      </div>

      <!-- Name -->
      <div class="mt-4 space-y-2">
        <AppInputLabel for="name">Name</AppInputLabel>

        <AppInput
          id="name"
          v-model="form.name"
          class="w-full"
          name="name"
        />

        <AppInputError
          class="mt-2"
          :message="form.errors.name"
        />
      </div>

      <!-- Parent -->
      <div class="mt-4 space-y-2">
        <AppInputLabel
          for="parent_id"
          class="block mb-2"
          >Parent</AppInputLabel
        >

        <select
          id="parent_id"
          ref="parentId"
          v-model="form.parent_id"
          class="w-full rounded"
          name="parent_id"
        >
          <option value>Choose parent</option>
          <option
            v-for="node in model.roles"
            :key="node.id"
            :value="node.id"
            :disabled="node.is_shared || node.id == role?.id"
            class="disabled:text-slate-400"
          >
            {{ node.parent?.name }} {{ node.name }}
          </option>
        </select>

        <AppInputError
          class="mt-2"
          :message="form.errors.parent_id"
        />
      </div>

      <!-- Permissions -->
      <div class="mt-4 space-y-2">
        <AppInputLabel
          for="roles"
          class="block mb-2"
          >Permissions</AppInputLabel
        >

        <select
          id="permissions"
          v-model="form.permissions"
          v-choicesjs
          multiple
          class="w-full"
          name="permissions"
        >
          <option value>Choose permissions</option>
          <option
            v-for="permission in permissions"
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
      <div class="mt-4 space-y-2">
        <AppInputLabel for="description">Description</AppInputLabel>

        <AppInput
          id="description"
          v-model="form.description"
          class="w-full"
          name="description"
        />

        <AppInputError
          class="mt-2"
          :message="form.errors.description"
        />
      </div>

      <div class="flex items-center justify-end mt-6 gap-3">
        <AppLightButton
          class="flex items-center gap-1 mb-1 mr-1"
          :disabled="form.processing"
          @click="emit('cancel')"
          >{{ __('app.buttons.cancel') }}</AppLightButton
        >

        <AppButton
          class="flex items-center gap-1 mb-1 mr-1"
          type="submit"
          :disabled="form.processing"
        >
          <AppSpinner
            v-show="form.processing"
            :size="4"
          />
          {{ editing ? __('app.buttons.update') : __('app.buttons.create') }}
        </AppButton>
      </div>
    </form>
  </div>
</template>
