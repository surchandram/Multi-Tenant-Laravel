<script>
  export default {
    pageLayout: 'admin',
  };
</script>

<script setup>
  import { ref, onMounted, reactive, toRefs, computed, watch, inject } from 'vue';
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputGroup from '@/components/AppInputGroup.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import { useFilters } from '@/composables/filters.js';
  import { useFlatpickr } from '@/composables/flatpickr.js';

  import 'vue-good-table-next/dist/vue-good-table-next.css';
  import { VueGoodTable } from 'vue-good-table-next';

  const props = defineProps(['model']);

  const { model } = toRefs(props);

  const filters = computed(() => model.value.filters);

  const state = reactive({
    range: {
      from: '',
      to: '',
    },
    searchTerm: '',
    searchPlaceholder: 'Search by name, username or email...then press enter',
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
  } = useFilters(model.value.filters, 'admin.users.index');

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
      field: 'id',
      filterable: false,
      sortable: false,
    },
    {
      label: '',
      field: 'avatar',
      filterable: false,
      sortable: false,
    },
    {
      label: 'Name',
      field: 'name',
      filterable: true,
    },
    {
      label: 'Email',
      field: 'email',
      filterable: true,
    },
    {
      label: 'Companies',
      field: 'companies_count',
      filterable: true,
    },
    {
      label: 'Verified',
      field: 'email_verified_at',
      filterable: true,
    },
    {
      label: 'Joined',
      field: 'created_at',
      formatFn: (value) => {
        return moment(value).format('MM/DD/YYYY');
      },
      filterable: false,
      sortable: false,
    },
    {
      label: 'Action',
      field: 'action',
      sortable: false,
    },
  ];

  const onPageChange = (params) => {
    withFilter('page', params.currentPage);
  };

  const onSortChange = (params) => {
    const { field, type } = params[0];
    var key = field;

    if (field == 'name') {
      key = 'first_name';
    }

    if (field == 'created_at') {
      key = 'created';
    }

    if (type == 'none') {
      withoutFilter('sort_by');
      return;
    }

    withFilter(`sort_by`, {
      key: key,
      value: type,
    });
  };

  const onColumnFilter = (params) => {
    console.log(params);
    // withFilter('page', params.currentPage);
  };

  const onSearch = (params) => {
    const { searchTerm } = params;

    withFilter('name', searchTerm);
  };

  const showFilters = ref(false);
  const $scrollTo = inject('$scrollTo');

  onMounted(() => {
    watch(showFilters, (val) => {
      if (val == true) {
        $scrollTo('#filtersWrapper', { container: 'main' });
      }
    });

    watch(selectedFilters, (val) => {
      $scrollTo('body', { container: 'main' });
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
  <Head title="Users | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold"> Users </span>
      </h1>

      <!-- Aside -->
      <div class="flex items-center gap-3">
        <AppSuccessButton :href="route('admin.users.create')">
          <i class="bi bi-person-plus"></i> Add User
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
          Search table
        </label>
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

      <!-- Table -->
      <div>
        <vue-good-table
          :columns="columns"
          :rows="model.users.data"
          :totalRows="model.users.meta.total"
          :pagination-options="{
            enabled: true,
            perPage: model.users.meta.per_page,
            total: model.users.meta.total,
            setCurrentPage: model.users.meta.current_page,
            perPageDropdownEnabled: false,
            dropdownAllowAll: false,
          }"
          :sort-options="{
            enabled: true,
            multipleColumns: true,
          }"
          mode="remote"
          styleClass="vgt-table stripped"
          v-on:page-change="onPageChange"
          v-on:sort-change="onSortChange"
          v-on:column-filter="onColumnFilter"
        >
          <!-- Table Actions -->
          <template #table-actions>
            <div class="flex items-center gap-2 px-2">
              <AppSuccessButton @click.prevent="showFilters = !showFilters">
                <i
                  v-if="showFilters"
                  class="bi bi-filter-left"
                ></i>
                <i
                  v-else
                  class="bi bi-filter"
                ></i>
              </AppSuccessButton>

              <!-- Clear Sorting -->
              <AppLightButton
                v-if="hasFilter('sort_by')"
                size="xs"
                @click.prevent="withoutFilter('sort_by')"
              >
                <i class="bi bi-x"></i> Clear Sorting
              </AppLightButton>

              <!-- Clear Filters -->
              <AppLightButton
                v-if="hasSelectedFilters"
                @click.prevent="withoutAllFilters"
              >
                <i class="bi bi-x"></i> Clear filters
              </AppLightButton>
              <!-- /Clear Filters -->
            </div>
          </template>

          <!-- Row Slot -->
          <template #table-row="props">
            <!-- Avatar column -->
            <div
              v-if="props.column.field == 'avatar'"
              class="flex items-center justify-center"
            >
              <img
                v-if="props.row.has_avatar"
                class="h-[64px]"
                :src="props.row.avatar"
                alt="..."
              />
              <i
                v-else
                class="bi bi-person text-3xl text-center"
              ></i>
            </div>

            <!-- Action column -->
            <div
              v-else-if="props.column.field == 'action'"
              class="flex items-center gap-2"
            >
              <!-- Impersonate -->
              <AppLightButton :href="route('admin.users.impersonate.index')">
                <i class="bi bi-box-arrow-in-right text-xl leading-normal"></i>
              </AppLightButton>

              <!-- View -->
              <AppSuccessButton :href="route('admin.users.show', props.row)">
                <i class="bi bi-eye"></i>
              </AppSuccessButton>

              <!-- Edit -->
              <AppButton :href="route('admin.users.edit', props.row)">
                <i class="bi bi-pencil"></i>
              </AppButton>
            </div>

            <!-- Verified Field -->
            <div v-else-if="props.column.field == 'email_verified_at'">
              <span
                v-if="props.row.email_verified_at"
                class="px-2 py-1 text-xs font-semibold text-teal-100 bg-teal-600 rounded-full whitespace-nowrap"
              >
                Verified
              </span>
              <span
                v-else
                class="px-2 py-1 text-xs font-semibold text-red-100 bg-red-600 rounded-full whitespace-nowrap"
              >
                Not Verified
              </span>
            </div>

            <span
              v-else
              class="text-sm"
              :class="{
                'text-slate-700 font-semibold': props.column.field == 'key',
              }"
            >
              <a
                href="#"
                v-if="props.column.field == 'name'"
              >
                {{ props.formattedRow[props.column.field] }}
              </a>
              <template v-else>{{ props.formattedRow[props.column.field] }}</template>
            </span>
          </template>
        </vue-good-table>
      </div>
      <!--/ Table -->
    </div>
  </div>
</template>
