<script setup>
  import { ref } from 'vue';
  import AppInput from '@/components/AppInput.vue';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppSwitchButton from '@/components/AppSwitchButton.vue';

  const props = defineProps({
    section: {
      type: Object,
      required: true,
    },
  });

  const form = ref(props.section);
</script>

<template>
  <div class="px-8 py-4 space-y-8 bg-white rounded-xl shadow-lg">
    <div
      v-for="(setting, settingKey) in section"
      :key="settingKey"
      class="space-y-2"
    >
      <!-- Boolean -->
      <div
        v-if="typeof setting.value === 'boolean'"
        class="flex items-center justify-between mb-2"
      >
        <label class="font-medium text-slate-500">{{ setting.label }}</label>

        <AppSwitchButton
          :value="true"
          v-model="form[settingKey].value"
          class="flex mr-2"
        />
      </div>
      <!-- END Boolean -->

      <!-- Number -->
      <div
        v-else-if="typeof setting.value === 'number'"
        class="flex items-center mb-2"
      >
        <label class="font-medium text-slate-500 mr-auto">{{ setting.label }}</label>

        <div class="w-20">
          <AppInput
            type="number"
            v-model.number="form[settingKey].value"
          />
        </div>
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
                v-model="form[settingKey].value"
              />
              <span>{{ option }}</span>
            </label>
          </template>
        </div>
      </div>
      <!-- END Array -->
    </div>
  </div>
</template>
