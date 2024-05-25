<script>
  export default {
    pageLayout: 'admin',
  };
</script>

<script setup>
  import { ref, onMounted, reactive } from 'vue';
  import { Head, Link } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import { useFilters } from '@/composables/filters.js';
  import { useFlatpickr } from '@/composables/flatpickr.js';

  import 'vue-good-table-next/dist/vue-good-table-next.css';
  import { VueGoodTable } from 'vue-good-table-next';

  const props = defineProps(['model']);

  const state = reactive({
    range: {
      from: '',
      to: '',
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
  } = useFilters(props.model.filters, 'admin.apps.index');

  // flatpickr setup
  useFlatpickr({
    startDate: {
      maxDate: state.range.to,
    },
    endDate: {
      minDate: state.range.from,
    },
  });

  const columns = [
    {
      label: '#',
      field: function (row) {
        return props.model.apps.meta.from + row.originalIndex;
      },
      filterable: false,
      sortable: false,
    },
    {
      label: '',
      field: 'logo',
      filterable: false,
      sortable: false,
    },
    {
      label: 'Name',
      field: 'name',
      filterable: true,
    },
    {
      label: 'Key',
      field: 'key',
      filterable: true,
    },
    {
      label: 'Features',
      field: 'features_count',
      filterable: true,
    },
    {
      label: 'Plans',
      field: 'plans_count',
      filterable: true,
    },
    {
      label: 'Teams',
      field: 'teams_count',
      filterable: true,
    },
    {
      label: 'Status',
      field: 'usable',
      filterable: true,
    },
    {
      label: 'Action',
      field: 'action',
      sortable: false,
    },
  ];

  const onPageChange = (params) => {
    console.log(params);
    // router.get(route('admin.apps.index', withFilter('page', params.currentPage)));
    withFilter('page', params.currentPage);
  };

  const onSortChange = (params) => {
    console.log(params);
    // router.get(route('admin.apps.index', withFilter('page', params.currentPage)));
  };

  const onColumnFilter = (params) => {
    console.log(params);
    // router.get(route('admin.apps.index', withFilter('page', params.currentPage)));
  };

  const onPerPageChange = (params) => {
    console.log(params);
    // router.get(route('admin.apps.index', withFilter('page', params.currentPage)));
  };

  const showFilters = ref(false);

  onMounted(() => {
    // set initial filters
    state.range = _.pick(selectedFilters.value, ['from', 'to']);
  });
</script>

<template>
  <Head title="Apps - Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold"> Apps </span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppSuccessButton :href="route('admin.apps.create')"> Add App </AppSuccessButton>

        <AppButton> Filters </AppButton>
      </div>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Search -->
      <div class="grid grid-cols-3 gap-6 mb-4">
        <div class="col-md-3">
          <div class="form-group">
            <label for="from_date">From</label>
            <AppInput
              id="from_date"
              v-model="state.range.from"
              type="text"
              class="form-control datepicker-from"
            />
          </div>
        </div>
        <!-- /from -->

        <div class="col-md-3">
          <div class="form-group">
            <label for="to_date">To</label>
            <AppInput
              id="to_date"
              v-model="state.range.to"
              type="text"
              class="form-control datepicker-to"
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
              class="text-sm font-semibold hover:text-slate-700 focus:text-slate-700"
              @click.prevent="withoutFilter(Object.keys(state.range))"
            >
              <i class="bi bi-x"></i> Clear
            </button>
          </div>
        </div>
      </div>
      <!-- /Search -->

      <div
        v-if="showFilters || selectedLabels.length"
        class="card mb-4"
      >
        <div
          v-if="selectedLabels.length"
          class="p-4"
        >
          <div class="flex items-baseline gap-2">
            <div class="text-sm font-semibold">Filtered by:</div>
            <span
              v-for="(label, index) in selectedLabels"
              :key="index"
              class="px-2 py-1 rounded-full bg-blue-600 text-white text-sm"
            >
              {{ label }}
            </span>
          </div>
        </div>
        <!-- /selectedFiltersLabels -->

        <!-- Filters section -->
        <div
          v-if="showFilters"
          class="p-4 bg-white"
        >
          <div class="grid md:grid-cols-3 gap-4">
            <div
              v-for="(filterMap, key) in model.filters"
              :key="`filterMap${key}`"
              class="col-span full md:col-span-1"
            >
              <p class="font-semibold text-sm py-2">{{ filterMap.heading }}</p>
              <hr />
              <div class="flex flex-col gap-2 py-3">
                <AppLightButton
                  v-for="(filter, value) in filterMap.map"
                  :key="`filterItem${value}`"
                  outline
                  :active="hasFilter(key) && selectedFilters[key] == value"
                  :class="{ 'bi bi-check': hasFilter(key) && selectedFilters[key] == value }"
                  href="#"
                  @click.prevent="withFilter(key, value)"
                >
                  {{ filter }}
                </AppLightButton>
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
              </div>
            </div>
          </div>
        </div>
        <!-- /filters -->
      </div>

      <!-- Table -->
      <div>
        <vue-good-table
          :columns="columns"
          :rows="model.apps.data"
          :total-rows="model.apps.total"
          :search-options="{
            enabled: true,
          }"
          :pagination-options="{
            enabled: true,
            perPage: model.apps.per_page,
            total: model.apps.total,
            setCurrentPage: model.apps.current_page,
            perPageDropdownEnabled: false,
            dropdownAllowAll: false,
          }"
          :sort-options="{
            enabled: true,
            multipleColumns: true,
          }"
          mode="remote"
          style-class="vgt-table stripped"
          @page-change="onPageChange"
          @sort-change="onSortChange"
          @column-filter="onColumnFilter"
          @per-page-change="onPerPageChange"
        >
          <!-- Table Actions -->
          <template #table-actions>
            <div class="flex items-center gap-2 px-2">
              <AppSuccessButton
                class="bg-success"
                @click.prevent="showFilters = !showFilters"
              >
                <i class="bi bi-filter"></i>
              </AppSuccessButton>

              <!-- Clear Filters -->
              <Link
                v-if="hasSelectedFilters"
                :href="route('admin.apps.index', withoutAllFilters)"
                class="text-sm font-semibold hover:text-slate-700 focus:text-slate-700"
              >
                <i class="bi bi-x"></i> Clear filters
              </Link>
              <!-- /Clear Filters -->
            </div>
          </template>

          <!-- Row Slot -->
          <template #table-row="rowProps">
            <!-- Logo column -->
            <div
              v-if="rowProps.column.field == 'logo'"
              class="flex items-center justify-center"
            >
              <img
                v-if="rowProps.row.has_logo"
                class="h-[64px]"
                :src="rowProps.row.logo"
                alt="..."
              />
              <i
                v-else
                class="bi bi-stack text-3xl text-center"
              ></i>
            </div>

            <!-- Action column -->
            <div
              v-else-if="rowProps.column.field == 'action'"
              class="flex items-center gap-2"
            >
              <!-- View -->
              <AppSuccessButton :href="route('admin.apps.show', rowProps.row)">
                <i class="bi bi-eye"></i>
              </AppSuccessButton>

              <!-- Edit -->
              <AppButton :href="route('admin.apps.edit', rowProps.row)">
                <i class="bi bi-pencil"></i>
              </AppButton>
            </div>

            <!-- Payment Status Field -->
            <div v-else-if="rowProps.column.field == 'usable'">
              <span
                v-if="rowProps.row.usable"
                class="px-2 py-1 text-xs font-semibold text-teal-100 bg-teal-600 rounded-full"
              >
                Live
              </span>
              <span
                v-else
                class="px-2 py-1 text-xs font-semibold text-red-100 bg-red-600 rounded-full"
              >
                Disabled
              </span>
            </div>

            <span
              v-else
              class="text-sm"
              :class="{
                'text-slate-700 font-semibold': rowProps.column.field == 'key',
              }"
            >
              <a
                v-if="rowProps.column.field == 'name'"
                href="#"
              >
                {{ rowProps.formattedRow[rowProps.column.field] }}
              </a>
              <template v-else>{{ rowProps.formattedRow[rowProps.column.field] }}</template>
            </span>
          </template>
        </vue-good-table>
      </div>
      <!--/ Table -->
    </div>
  </div>
</template>
