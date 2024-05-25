<script setup>
  import { onMounted, computed, ref, watch } from 'vue';
  import { cloneDeep, get, includes, pick } from 'lodash';
  import AppButton from '@/components/AppButton.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppDetailsModal from '@/components/apps/AppDetailsModal.vue';

  const props = defineProps({
    modelValue: {
      type: Array,
      required: true,
    },
    apps: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
      default: () => {},
    },
  });

  const emit = defineEmits(['update:modelValue']);

  const selected = ref(props.modelValue.map((val) => val.app_id));

  const selecting = ref(false);

  const selectedApps = computed(() => props.apps.filter((f) => includes(selected.value, f.id)));

  const removeSelected = (app) => {
    selected.value = cloneDeep(selected.value).filter((f) => f !== app.id);
  };

  const clearSelected = () => (selected.value = []);

  const appPayloads = computed(() => {
    return selected.value.map((val) => appPayload(val));
  });

  const appPayload = (appId) => {
    return Object.assign(
      {},
      {
        app_id: appId,
      },
      get(appPayloads.value, appId, {
        data: {},
      }),
    );
  };

  onMounted(() => {
    watch(selected, () => {
      emit('update:modelValue', appPayloads);
    });
  });
</script>

<template>
  <div>
    <!-- Selected Section -->
    <div
      v-if="!selecting"
      class="space-y-8"
    >
      <p
        v-if="selected.length < 1"
        class="text-sm font-medium text-slate-600"
      >
        {{ __('app.app.none_chosen') }}
        <AppButton @click.prevent="selecting = !selecting">{{ __('app.labels.choose') }}</AppButton>
      </p>

      <!-- Selected Apps -->
      <div class="w-full flex flex-wrap gap-6">
        <!-- App -->
        <div
          v-for="(app, index) in selectedApps"
          :key="app.key"
          class="space-y-3"
        >
          <div
            class="w-full md:w-auto md:min-w-[12rem] px-4 py-2 rounded flex items-center gap-3 bg-indigo-50 hover:bg-indigo-100"
          >
            <!-- App Logo -->
            <div class="w-16 h-16">
              <img
                :src="app.logo"
                :alt="app.name"
              />
            </div>
            <!-- END App Logo -->

            <!-- App Details -->
            <div class="pl-1 space-y-3">
              <h4 class="text-base font-medium">
                {{ app.name }}
              </h4>

              <!-- Actions -->
              <p>
                <!-- Remove -->
                <AppButton
                  theme="outline-danger"
                  class="inline-flex items-center gap-1 -ml-2 text-xs leading-none"
                  @click.prevent="removeSelected(app)"
                  ><i class="bi bi-x -ml-2"></i> {{ __('app.labels.remove') }}</AppButton
                >
                <!-- END Remove -->
              </p>
              <!-- END Actions -->
            </div>
          </div>

          <div class="px-2">
            <AppInputError :message="errors[`apps.${index}`]" />
          </div>
        </div>
        <!-- END App -->
      </div>
      <!-- END Selected Apps -->

      <!-- Actions -->
      <div
        v-if="selected.length > 0"
        class="flex flex-wrap items-center gap-2"
      >
        <!-- Choose -->
        <AppButton @click.prevent="selecting = !selecting">{{ __('app.labels.choose') }}</AppButton>
        <!-- END Choose -->

        <!-- Clear -->
        <AppButton
          v-if="selected.length > 0"
          theme="outline-secondary"
          class="inline-flex items-center gap-1"
          @click.prevent="clearSelected"
          ><i class="bi bi-x-circle leading-none"></i>{{ __('app.labels.clear') }}</AppButton
        >
        <!-- END Clear -->
      </div>
      <!-- END Actions -->
    </div>
    <!-- END Selected Section -->

    <!-- Selector Section -->
    <div
      v-else
      class="flex flex-col gap-6 mt-8"
    >
      <div class="flex justify-end gap-3">
        <!-- Clear -->
        <AppButton
          v-if="selected.length > 0"
          theme="outline-secondary"
          @click.prevent="selected = []"
          class="inline-flex items-center gap-1"
          ><i class="bi bi-x-circle leading-none"></i>{{ __('app.labels.clear') }}</AppButton
        >
        <!-- END Clear -->

        <!-- Cancel -->
        <AppButton
          theme="outline-info"
          @click.prevent="selecting = false"
          >{{ __('app.labels.cancel') }}</AppButton
        >
        <!-- END Cancel -->

        <!-- Done -->
        <AppButton
          v-if="selected.length > 0"
          theme="success"
          @click="selecting = false"
          ><span v-if="selected.length">({{ selected.length }})</span> {{ __('app.labels.done') }}</AppButton
        >
        <!-- END Done -->
      </div>

      <!-- App -->
      <div
        v-for="app in apps"
        :key="app.id"
        class="flex flex-wrap rounded-md"
      >
        <AppInputLabel
          :id="app.key"
          class="flex flex-wrap flex-1 gap-4 p-4 rounded-l-md"
          :class="[
            selected.filter((a) => a === app.id).length === 1
              ? 'bg-indigo-200 shadow-sm'
              : 'bg-slate-200 hover:bg-slate-100',
          ]"
        >
          <input
            v-model="selected"
            type="checkbox"
            id="app.key"
            class="hidden"
            :value="app.id"
          />

          <!-- App Logo -->
          <div class="w-24 h-24">
            <img
              :src="app.logo"
              :alt="app.name"
            />
          </div>
          <!-- END App Logo -->

          <!-- App Details -->
          <div class="space-y-3">
            <h4 class="text-base font-medium">
              {{ app.name }}
            </h4>

            <p class="text-sm text-slate-600">
              {{ app.description }}
            </p>

            <!-- Selected Icon -->
            <div
              v-if="selected.filter((a) => a === app.id).length === 1"
              class="w-full px-4 text-white"
            >
              <div class="inline-flex items-center gap-2 px-2 py-1 rounded bg-indigo-600">
                <span>Selected</span>
                <i class="bi bi-check-circle text-xl leading-none"></i>
              </div>
            </div>
            <!-- END Selected Icon -->
          </div>
          <!-- END App Details -->
        </AppInputLabel>

        <!-- Actions -->
        <div class="flex items-stretch flex-wrap -space-x-1 ml-auto bg-slate-50">
          <!-- Features Icon -->
          <AppButton
            class="items-center rounded-l-none px-4 text-center"
            @click="$eventBus.emit('show-app-details', app)"
          >
            <i class="bi bi-info-circle text-xl"></i>
          </AppButton>
          <!-- END Features Icon -->
        </div>
        <!-- END Actions -->
      </div>
      <!-- END App -->

      <div class="flex justify-end gap-3 py-2">
        <!-- Clear -->
        <AppButton
          v-if="selected.length > 0"
          theme="outline-secondary"
          @click.prevent="selected = []"
          class="inline-flex items-center gap-1"
          ><i class="bi bi-x-circle leading-none"></i>{{ __('app.labels.clear') }}</AppButton
        >
        <!-- END Clear -->

        <!-- Cancel -->
        <AppButton
          theme="outline-info"
          @click.prevent="selecting = false"
          >{{ __('app.labels.cancel') }}</AppButton
        >
        <!-- END Cancel -->

        <!-- Done -->
        <AppButton
          v-if="selected.length > 0"
          theme="success"
          @click="selecting = false"
          ><span v-if="selected.length">({{ selected.length }})</span> {{ __('app.labels.done') }}</AppButton
        >
        <!-- END Done -->
      </div>
    </div>
    <!-- END Selector Section -->

    <AppDetailsModal />
  </div>
</template>
