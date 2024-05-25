<script>
  export default {
    pageLayout: 'company',
  };
</script>

<script setup>
  import { ref, onMounted, reactive, toRefs, computed, watch, inject } from 'vue';
  import { Head } from '@inertiajs/vue3';
  import DataTable from './partials/DataTable.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import { useFilters } from '@/composables/filters.js';
  import { useFlatpickr } from '@/composables/flatpickr.js';

  const layoutComponents = {
    datatable: DataTable,
  };

  const props = defineProps(['model']);

  const { model } = toRefs(props);

  const filters = computed(() => model.value.filters);

  const state = reactive({
    range: {
      from: '',
      to: '',
    },
    searchTerm: '',
    searchPlaceholder: 'Enter name, address or project id...then press enter',
    defaultSort: {
      field: 'created_at',
      type: 'desc',
    },
  });

  // filter helpers setup
  const {
    selectedFilters,
    withFilter,
    withoutFilter,
    withoutAllFilters,
    applyFilters,
    hasFilter,
    hasSelectedFilters,
    selectedLabels,
  } = useFilters(model.value.filters, 'restore.projects.index');

  // flatpickr setup
  useFlatpickr({
    startDate: {
      maxDate: state.range.to,
    },
    endDate: {
      minDate: state.range.from,
    },
  });

  const onSearch = (params) => {
    const { searchTerm } = params;

    withFilter('name', searchTerm);
  };

  const showFilters = ref(false);
  const $scrollTo = inject('$scrollTo');

  onMounted(() => {
    watch(showFilters, (val) => {
      if (val == true) {
        $scrollTo('#filtersWrapper', { container: '#app' });
      }
    });

    watch(selectedFilters, (val) => {
      $scrollTo('body', { container: '#app' });
    });

    // set initial filters
    state.range = _.pick(selectedFilters.value, ['from', 'to']);

    // search term
    state.searchTerm = _.get(selectedFilters.value, 'name');

    // initial sort
    if (_.has(selectedFilters.value, 'sort_by')) {
      state.defaultSort = {
        field: _.get(selectedFilters.value, 'sort_by')?.key,
        type: _.get(selectedFilters.value, 'sort_by')?.value,
      };
    }
  });
</script>

<template>
  <Head title="Projects | Restore" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto dark:text-primary">
        <span class="font-semibold">
          {{ __('tenant.labels.projects') }}
        </span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppSuccessButton :href="route('restore.projects.create')">
          <i class="bi bi-person-plus"></i> {{ __('tenant.labels.start_new_project') }}
        </AppSuccessButton>

        <AppButton @click.prevent="showFilters = !showFilters">
          <i
            v-if="showFilters"
            class="bi bi-filter-left"
          ></i>
          <i
            v-else
            class="bi bi-filter"
          ></i>
          {{ showFilters ? 'Hide Filters' : 'Filters' }}
        </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Date Range Picker -->
      <div class="grid grid-cols-3 gap-6 mb-4">
        <div class="col-md-3">
          <div class="form-group">
            <label for="from_date">From</label>
            <AppInput
              id="from_date"
              type="text"
              class="form-control datepicker-from"
              v-model="state.range.from"
            />
          </div>
        </div>
        <!-- /from -->

        <div class="col-md-3">
          <div class="form-group">
            <label for="to_date">To</label>
            <AppInput
              id="to_date"
              type="text"
              class="form-control datepicker-to"
              v-model="state.range.to"
            />
          </div>
        </div>
        <!-- /to -->

        <div class="col-md-3">
          <div class="flex items-center justify-start gap-2 mt-4 pt-2">
            <AppButton
              type="button"
              class="btn btn-success"
              @click="applyFilters(state.range)"
            >
              Search
            </AppButton>

            <!-- Clear date range -->
            <button
              v-if="hasFilter('from') || hasFilter('to')"
              @click.prevent="withoutFilter(Object.keys(state.range))"
              class="text-sm font-semibold hover:text-slate-700 focus:text-slate-700"
            >
              <i class="bi bi-x"></i> Clear
            </button>
          </div>
        </div>
      </div>
      <!-- /Date Range Picker -->

      <!-- Search -->
      <div class="py-4 mb-4">
        <label
          for="searchInput"
          class="block text-xs font-semibold mb-2"
        >
          {{ __('tenant.labels.search_projects') }}
        </label>

        <!-- Input Group -->
        <AppInputGroup custom>
          <template #default="{ inputStyles }">
            <AppInput
              v-model="state.searchTerm"
              id="searchInput"
              :class="inputStyles"
              class="flex-1"
              :placeholder="state.searchPlaceholder"
              @keyup.enter="withFilter('name', state.searchTerm)"
            />
          </template>

          <template #end>
            <!-- Search -->
            <AppButton
              :class="{ 'rounded-r-none': hasFilter('name') }"
              class="pt-2.5 pb-2.5 !mt-0 rounded-l-none"
              @click="withFilter('name', state.searchTerm)"
            >
              <i class="bi bi-search"></i>
              <span class="hidden md:inline-flex md:ml-2">Search</span>
            </AppButton>

            <!-- Clear Search -->
            <AppLightButton
              v-if="hasFilter('name')"
              class="pt-2.5 pb-2.5 !mt-0 rounded-l-none"
              @click="withoutFilter('name')"
            >
              <i class="bi bi-x-lg"></i>
            </AppLightButton>
          </template>
        </AppInputGroup>
      </div>
      <!-- /Search -->

      <!-- Filters -->
      <div
        v-if="showFilters || selectedLabels.length"
        id="filtersWrapper"
        class="card mb-4"
      >
        <!-- selectedFiltersLabels -->
        <div
          v-if="selectedLabels.length"
          class="p-4"
        >
          <div class="flex items-baseline gap-2">
            <div class="text-sm font-semibold">Filtered by:</div>
            <span
              class="px-2 py-1 rounded-full bg-blue-600 text-white text-sm"
              v-for="(label, index) in selectedLabels"
              :key="index"
            >
              {{ label }}
            </span>
          </div>
        </div>
        <!-- /selectedFiltersLabels -->

        <!-- Filters Mapping -->
        <div
          v-if="showFilters"
          class="p-4 bg-white"
        >
          <!-- grid -->
          <div class="grid md:grid-cols-3 gap-4">
            <!-- Filter Map -->
            <div
              :key="`filterMap${key}`"
              v-for="(filterMap, key) in filters"
              class="col-span full md:col-span-1"
            >
              <!-- Filter Map Heading -->
              <p class="font-semibold text-sm py-2">
                {{ filterMap.heading }}
              </p>
              <!-- /Filter Map Heading -->

              <hr />

              <!-- Filter's Values Map -->
              <div class="flex flex-col gap-2 py-3">
                <!-- Filter Button -->
                <AppLightButton
                  v-for="(filter, value) in filterMap.map"
                  :key="`filterItem${value}`"
                  outline
                  :active="hasFilter(key) && selectedFilters[key] == value"
                  :class="{
                    'bi bi-check': hasFilter(key) && selectedFilters[key] == value,
                  }"
                  href="#"
                  @click.prevent="withFilter(key, value)"
                >
                  {{ filter }}
                </AppLightButton>
                <!-- /Filter Button -->

                <!-- Clear Filter Button -->
                <div class="dropdown-item px-0">
                  <a
                    v-if="hasFilter(key)"
                    class="btn btn-block btn-xs btn-flush-secondary text-start"
                    href="#"
                    @click.prevent="withoutFilter(key)"
                  >
                    <i class="bi bi-x"></i> Clear filter
                  </a>
                </div>
                <!-- /Clear Filter Button -->
              </div>
              <!-- /Filter's Values Map -->
            </div>
            <!-- /Filter Map -->
          </div>
          <!-- /grid -->
        </div>
        <!-- /Filters Mapping -->
      </div>
      <!-- /Filters -->

      <!-- DataTable -->
      <DataTable :model="model" />
      <!--/ DataTable -->
    </div>
  </div>
</template>
