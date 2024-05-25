<script setup>
  import AppSwitchButton from '@/components/AppSwitchButton.vue';

  // Props
  defineProps({ label: String, collection: Object, data: Object });
</script>

<template>
  <div>
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">{{ label }}</h2>
    <div v-if="collection">
      <!-- Loop through project notification settings -->
      <template
        v-for="(status, statusKey) in collection"
        :key="statusKey"
      >
        <!-- Render settings for each status -->
        <div class="mb-4">
          <h3 class="text-lg font-semibold mb-2">{{ status.label }}</h3>
          <!-- Render settings for each status sub-collection -->
          <template
            v-for="(subSetting, subSettingKey) in status.collection"
            :key="subSettingKey"
          >
            <div
              v-if="typeof subSetting.value === 'boolean'"
              class="flex items-center mb-2"
            >
              <!-- Render SwitchButton for boolean settings -->
              <AppSwitchButton
                :label="subSetting.label"
                v-model="data.options.notifications.project[statusKey][subSettingKey]"
              />
            </div>
            <!-- Other setting types can be handled similarly -->
          </template>
        </div>
      </template>
    </div>
  </div>
</template>
