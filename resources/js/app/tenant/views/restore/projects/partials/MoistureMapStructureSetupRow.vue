<script setup>
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import LucideIcon from '@/components/LucideIcon.vue';

  const props = defineProps({
    modelValue: {
      type: Array,
      default: function () {
        return [];
      },
    },
    affectedArea: {
      type: Object,
      default: function () {
        return {};
      },
    },
    project: {
      type: Object,
      default: function () {
        return {};
      },
    },
    data: {
      type: Object,
      default: function () {
        return {};
      },
    },
  });

  const emit = defineEmits(['remove']);

  const form = useForm({});

  const confirmDelete = () => {
    if (!confirm('Do you want to remove item from moisture map?')) {
      return;
    }

    form.delete(route('restore.projects.moisture-map.destroy', [props.project.id, props.data.id]), {
      onSuccess: () => {
        emit('remove');
      },
    });
  };
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Structure -->
    <div class="flex items-center px-2 py-3 border-2 border-blue-500 border-dotted">
      <AppInputLabel
        class="block text-lg"
        :value="data.structure"
      />
    </div>

    <!-- Material -->
    <div class="flex items-center px-2 py-3 border-2 border-blue-500 border-dotted">
      <AppInputLabel
        class="block text-lg"
        :value="data.material"
      />
    </div>

    <div class="flex items-center gap-4 px-2 py-3 md:border-2 border-transparent">
      <AppSuccessButton
        v-if="data.id"
        type="button"
        @click="$eventBus.emit('moisture-map::fill-readings-form', props.data)"
      >
        <LucideIcon
          name="notebook-pen"
          class="size-5"
        />
      </AppSuccessButton>

      <AppLightButton
        v-if="data.device?.uuid"
        type="button"
        @click="$eventBus.emit('moisture-map::show-device-info', props.data)"
      >
        <LucideIcon
          name="cloud"
          class="size-5"
        />
      </AppLightButton>

      <AppButton
        v-else
        type="button"
        @click="$eventBus.emit('moisture-map::scan-device', props.data)"
      >
        <LucideIcon
          name="qr-code"
          class="size-5"
        />
      </AppButton>

      <AppLightButton
        type="button"
        @click="data.id ? confirmDelete() : emit('remove')"
      >
        <LucideIcon
          name="x"
          class="size-5"
        />
      </AppLightButton>
    </div>
  </div>
</template>
