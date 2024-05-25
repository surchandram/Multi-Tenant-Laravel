<script setup>
  import { ref, watch, onMounted } from 'vue';
  import AppButton from '@/components/AppButton.vue';
  import UpsertRoleForm from './UpsertRoleForm.vue';
  import Role from '../../../components/roles/Role.vue';

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
  });

  const emit = defineEmits(['update:modelValue']);

  const creating = ref(false);
  const editing = ref(null);

  const handleCreated = () => {
    setTimeout(() => {
      creating.value = false;
    }, 500);
  };

  const handleEdited = () => {
    editing.value = null;
  };

  onMounted(() => {
    //
  });
</script>

<template>
  <div class="space-y-4">
    <!-- Create Form -->
    <UpsertRoleForm
      v-if="creating"
      :model="model"
      :company="model.company"
      :permissions="model.permissions || []"
      :roles="model.roles || []"
      @cancel="creating = false"
      @created="handleCreated"
    />
    <!-- END Create Form -->

    <!-- Editing Form -->
    <UpsertRoleForm
      v-else-if="editing"
      :role="editing"
      :model="model"
      :company="model.company"
      :permissions="model.permissions || []"
      :roles="model.roles || []"
      :editing="true"
      @cancel="editing = null"
      @updated="handleEdited"
    />
    <!-- END Editing Form -->

    <div
      v-else
      class="space-y-4"
    >
      <!-- Empty Alert -->
      <p
        v-if="model.roles.length < 1"
        class="text-sm text-slate-500 font-medium"
      >
        {{ __('app.labels.no_roles_found') }}
        <AppButton @click="creating = true">{{ __('app.labels.add_role') }}</AppButton>
      </p>
      <!-- END Empty Alert -->

      <div
        v-else
        class="px-4 py-2 space-y-3"
      >
        <!-- Actions -->
        <div class="flex items-start gap-4 py-3">
          <div class="mr-auto space-y-2 font-medium">
            <p class="text-lg">{{ __('app.labels.manage_roles') }}</p>

            <p class="text-sm text-slate-500">{{ __('app.labels.manage_roles_prompt') }}</p>
          </div>

          <AppButton @click="creating = true">{{ __('app.labels.add_role') }}</AppButton>
        </div>
        <!-- END Actions -->

        <!-- Roles -->
        <div class="divide-y-2 divide-slate-200">
          <Role
            v-for="role in model.editable_roles"
            :key="role.id"
            :role="role"
            @edit="(data) => (editing = data)"
          />
        </div>
        <!-- END Roles -->
      </div>
    </div>
  </div>
</template>
