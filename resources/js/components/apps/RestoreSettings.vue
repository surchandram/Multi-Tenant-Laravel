<script setup>
  import RestoreNotificationSettings from './RestoreNotificationSettings.vue';
  import RestoreProjectSetting from './RestoreProjectSetting.vue';
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';

  const props = defineProps(['settings']);

  const resolved = {
    project: RestoreProjectSetting,
    notifications: RestoreNotificationSettings,
  };
</script>

<template>
  <div class="space-y-4">
    <TabGroup
      as="div"
      class="flex flex-col md:flex-row items-start gap-4"
    >
      <TabList class="md:w-48 flex md:flex-col -space-x-1 md:space-x-0 rounded bg-slate-200 shadow">
        <Tab
          v-for="(section, sectionKey) in settings"
          :key="sectionKey"
          class="px-4 py-2 first:rounded-l last:rounded-r md:first:rounded-bl-none md:last:rounded-tr-none md:first:rounded-t md:last:rounded-b ui-selected:bg-indigo-500 ui-selected:text-white ui-not-selected:bg-white ui-not-selected:text-indigo-400 focus:outline-none"
        >
          {{ section.label }}
        </Tab>
        <!-- END Tab -->
      </TabList>
      <!-- END Tablist -->

      <TabPanels class="flex-1">
        <TabPanel
          v-for="(section, sectionKey) in settings"
          :key="sectionKey"
          as="div"
          class="md:pl-2"
        >
          <component
            :is="resolved[sectionKey]"
            :section="section.collection"
            :id="sectionKey"
          />
        </TabPanel>
        <!-- END TabPanel -->
      </TabPanels>
      <!-- END TabPanels -->
    </TabGroup>
    <!-- END TabGroup -->
  </div>
</template>
