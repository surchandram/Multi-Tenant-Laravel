<script setup>
  import { ref, watch, onMounted } from 'vue';
  import AppInput from '@/components/AppInput.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppSwitchButton from '@/components/AppSwitchButton.vue';

  const emit = defineEmits(['update:modelValue']);

  const props = defineProps({
    section: {
      type: Object,
      required: true,
    },
    id: {
      type: String,
      required: true,
    },
  });

  const form = ref(props.section);

  onMounted(() => {
    watch(form, (val) => {
      emit('update:modelValue', val);
    });
  });
</script>

<template>
  <!-- Status -->
  <div
    v-for="(status, statusKey) in section"
    :key="statusKey"
    class="px-8 py-4 space-y-8 bg-white rounded-xl shadow-lg"
  >
    <h4 class="text-sm font-semibold mb-2 text-slate-600">{{ status.label }}</h4>

    <div
      v-for="(setting, settingKey) in status.collection"
      :key="settingKey"
      class="space-y-6"
    >
      <!-- Boolean -->
      <div
        v-if="typeof setting.value === 'boolean'"
        class="flex items-center justify-between mb-2"
      >
        <label class="font-medium text-slate-500">{{ setting.label }}</label>

        <AppSwitchButton
          :value="true"
          v-model="form[statusKey].collection[settingKey].value"
          class="flex mr-2"
        />
      </div>
      <!-- END Boolean -->

      <!-- Number -->
      <div
        v-else-if="typeof setting.value === 'number'"
        class="flex items-center mb-2"
      >
        <label class="font-medium text-slate-500 mr-2">{{ setting.label }}</label>
        <AppInput
          type="number"
          v-model.number="form[statusKey].collection[settingKey].value"
          class="w-20"
        />
      </div>
      <!-- END Number -->

      <!-- Array -->
      <div
        v-else-if="Array.isArray(setting.choices)"
        class="flex items-center justify-between"
      >
        <label class="font-medium text-slate-500">{{ setting.label }}</label>
        <div class="flex items-center flex-wrap gap-2">
          <template
            v-for="(option, index) in setting.choices"
            :key="index"
          >
            <label class="flex items-center gap-1 leading-none">
              <AppCheckbox
                :value="option"
                v-model="form[statusKey].collection[settingKey].value"
              />
              <span>{{ option }}</span>
            </label>
          </template>
        </div>
      </div>
      <!-- END Array -->
    </div>
  </div>
  <!-- END -->
</template>
