<script setup>
  import { useStepper } from '@vueuse/core';

  const props = defineProps({
    tabs: {
      type: Object,
      default: function () {
        return {}
      }
    },
    tabLabel: {
      type: String,
      default: 'name'
    },
    indexAsLabel: {
      type: Boolean,
      default: false
    },
    contentStyles: {
      type: [String, 'Array', Object],
      default: 'flex flex-col py-6',
    },
    tabNavStyles: {
      type: [String, 'Array', Object],
      default: 'flex items-center flex-wrap gap-y-2 md:gap-y-0 gap-x-4',
    },
    tabLinkItemStyles: {
      type: [String, 'Array', Object],
      default: '',
    },
    tabLinkStyles: {
      type: [String, 'Array', Object],
      default: '',
    },
  });

  const {
    steps,
    index,
    current,
    isFirst,
    isLast,
    goTo,
    goToNext,
    goToPrevious,
    isCurrent,
  } = useStepper(props.tabs);
</script>

<template>
  <!-- Tabs -->
  <div class="w-full flex flex-col">
    <div :class="tabNavStyles">
      <!-- Tab Navigation -->
      <div
        v-for="(tab, tabIndex) in steps"
        :id="`tab${tabIndex}`"
        :key="`tab${tabIndex}`"
        :class="tabLinkItemStyles ? tabLinkItemStyles : [
          'border-b-2',
          {
            'border-blue-500': isCurrent(tabIndex),
            'border-transparent': !isCurrent(tabIndex)
          }
        ]"
      >
        <a
          href="#"
          :class="tabLinkStyles ? tabLinkStyles : [
            'block px-2 py-3 text-sm',
            {
              'border-blue-500': isCurrent(tabIndex),
              'text-slate-500': !isCurrent(tabIndex),
              'text-blue-500': isCurrent(tabIndex)
            }
          ]"
          @click.prevent="goTo(tabIndex)"
        >
          {{ indexAsLabel ? tabIndex : tab[tabLabel] }}
        </a>
      </div>
      <!-- /Tab Navigation -->
    </div>
    
    <!-- Tab Content -->
    <div :class="contentStyles">
      <!-- Tabs -->
      <slot
        name="content"
        :is-current-tab="isCurrent"
        :go-to-tab="goTo"
        :tab-index="index"
        :current-tab="current"
        :tab-is-first="isFirst"
        :tab-is-fast="isLast"
      >
        <p class="text-xs text-slate-400">
          Tabs will show up here.
        </p>
      </slot>
      <!-- /Tabs -->
    </div>
    <!-- /Tab Content -->
  </div>
  <!-- /Tabs -->
</template>
