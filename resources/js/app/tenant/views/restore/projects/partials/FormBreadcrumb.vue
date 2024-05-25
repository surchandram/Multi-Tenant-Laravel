<script setup>
  import { ref, toValue, onMounted, watch } from 'vue';
  import { cloneDeep } from 'lodash';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';

  const props = defineProps(['data']);

  const { goTo, isCurrent, index } = toValue(props.data);

  const selected = ref(null);

  onMounted(() => {
    selected.value = props.data.stepNames[index];

    watch(
      () => cloneDeep(props.data),
      (val) => {
        selected.value = props.data.stepNames[val.index];
      },
    );
  });

  const changed = (event) => {
    selected.value = event.target.value;

    props.data.goTo(event.target.value);
  };
</script>

<template>
  <TooltipProvider>
    <div class="rounded-sm">
      <!-- Large Screens -->
      <div class="hidden lg:flex items-center gap-2">
        <div
          v-for="(step, key) in data.steps"
          :key="key"
        >
          <Tooltip>
            <TooltipTrigger>
              <a
                href="#"
                class="inline-flex items-center rounded-full text-sm text-white hover:bg-blue-600 dark:hover:bg-blue-600"
                :class="{
                  'w-4 h-4 bg-teal-400 dark:bg-orange-400': !isCurrent(key),
                  'h-8 p-2 bg-blue-600 dark:bg-blue-600 font-medium': isCurrent(key),
                }"
                @click.prevent="goTo(key)"
              >
                {{ isCurrent(key) ? step.title : '' }}
              </a>
            </TooltipTrigger>
            <TooltipContent>
              {{ step.title }}
            </TooltipContent>
          </Tooltip>
        </div>
      </div>
      <!-- /Large Screens -->

      <!-- Small Screens -->
      <div class="w-full flex items-center gap-2 lg:hidden">
        <AppInputLabel>{{ __('app.labels.go_to') }}</AppInputLabel>

        <select
          v-model="selected"
          class="flex-1 dark:bg-slate-800"
          @change="changed"
        >
          <option
            v-for="(step, key) in data.steps"
            :key="key"
            :value="key"
          >
            {{ step.title }}
          </option>
        </select>
      </div>
      <!-- /Small Screens -->
    </div>
  </TooltipProvider>
</template>
