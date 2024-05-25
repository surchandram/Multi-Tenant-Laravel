<script setup>
  import { onMounted, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';

  const props = defineProps({
    modelValue: Object,
    action: String,
    editing: {
      type: Boolean,
      default: false
    },
    inline: {
      type: Boolean,
      default: false
    },
    without: {
      type: Array,
      default: (() => [])
    }
  });

  const emit = defineEmits([
    'update:modelValue',
    'close'
  ]);

  const form = useForm({
    name: props.modelValue?.name || '',
    description: props.modelValue?.description || '',
    usable: props.modelValue?.usable || true,
  });

  onMounted(() => {
    // emit 'input' event
    watch(() => _.cloneDeep(form.data()), () => {
      emit('update:modelValue', form.data());
    });
  });

  const store = () => {
    form.clearErrors();

    if (typeof props.action === 'undefined') {
      emit('update:modelValue', form.data());
      emit('close');
    } else {
      if (props.editing) {
        form.patch(props.action, {
          onSuccess: () => {
            emit('close');
          },
        });
      }
      else {
        form.post(props.action, {
          onSuccess: () => {
            emit('close');
          },
        });
      }
    }
  };
</script>

<template>
  <component
    :is="inline ? 'div' : 'form'"
    method="POST"
    action="#"
    @submit.prevent="store"
  >
    <h4 class="text-sm text-slate-400 font-semibold mb-3">
      {{ editing ? 'Editing Team' : 'Add new team' }}
    </h4>

    <div>
      <AppInputLabel for="name">Team name</AppInputLabel>

      <AppInput
        id="name"
        v-model="form.name"
        type="text"
        class="w-full mt-2"
        name="name"
        required
      />

      <AppInputError :message="form.errors.name" class="mt-2" />
    </div>

    <div class="mt-4">
      <AppInputLabel for="description">Description</AppInputLabel>

      <AppInput
        id="description"
        v-model="form.description"
        type="text"
        class="w-full mt-2"
        name="description"
        maxlength="140"
        placeholder="Short description about team..."
      />

      <AppInputError :message="form.errors.description" class="mt-2" />
    </div>

    <div
      class="w-full flex items-center gap-2 mt-4"
    >
      <AppCheckbox
        id="usable"
        v-model="form.usable"
        name="usable"
        value="1"
      />

      <AppInputLabel for="usable">Live</AppInputLabel>
    </div>

    <div
      v-if="!inline"
      class="flex items-center justify-end gap-3 mt-4"
    >
      <AppButton type="submit">Save</AppButton>
      <slot name="buttons"></slot>
    </div>
  </component>
</template>
