<script setup>
  import { ref, onMounted, reactive, toRefs, watch } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import AppButton from '@/components/AppButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import DropdownMenu from '@/components/DropdownMenu.vue';
  import ChevronDown from '@/components/ChevronDown.vue';
  import { useFilters } from "@/composables/filters.js";

  import 'vue-good-table-next/dist/vue-good-table-next.css';
  import { VueGoodTable } from 'vue-good-table-next';

  const props = defineProps([
    "model",
  ]);

  const { model } = toRefs(props);

  const state = reactive({
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
    hasFilter,
    hasSelectedFilters,
  } = useFilters(model.value.filters, 'admin.plans.index');

  const columns = [
    {
      label: '#',
      field: 'id',
      filterable: false,
      sortable: false,
    },
    {
      label: 'Name',
      field: 'name',
      filterable: true,
    },
    {
      label: 'Per Seat',
      field: 'per_seat',
      filterable: true,
    },
    {
      label: 'Price',
      field: 'formatted_price',
      filterable: false,
    },
    {
      label: 'Synced',
      field: 'synced_to_provider',
      formatFn: (value) => {
        return value == true ? 'Synced' : 'Pending';
      },
      filterable: true,
    },
    {
      label: 'Status',
      field: 'usable',
      filterable: true,
    },
    {
      label: 'Subscribers',
      field: 'subscriptions',
      filterable: false,
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

    if (field == 'created_at') {
      key = 'created';
    }

    if (field == 'formatted_price') {
      key = 'price';
    }

    if (type == 'none') {
      withoutFilter('sort_by');
      return;
    }

    withFilter(`sort_by`, {
      key: key,
      value: type
    });
  };

  const onColumnFilter = (params) => {
    console.log(params);
    // withFilter('page', params.currentPage);
  };

  const confirmDelete = (data) => {
    $eventBus.emit('show-confirmation-dialog-modal', {
      title: `Delete Confirmation`,
      message: `Are you sure you want to delete '${data.name} (${data.formatted_interval})' from plans?`,
      callback: () => {
        destroyActionForm.delete(route('admin.plans.destroy', data), {
          onSuccess: () => {
            $eventBus.emit('hide-confirmation-dialog-modal')
          }
        });
      }
    });
  };

  const destroyActionForm = useForm({});

  const showFilters = ref(false);

  onMounted(() => {
    // initial sort
    if (_.has(selectedFilters.value, 'sort_by')) {
      state.defaultSort = {
        field: _.get(selectedFilters.value, 'sort_by')?.key,
        type: _.get(selectedFilters.value, 'sort_by')?.value,
      };
    }

    watch(showFilters, (val) => {
      $eventBus.emit('toggle-filters', val);
    });

    // listen to 'toggle-filters' event
    $eventBus.on('toggle-filters', (val) => showFilters.value = val);
  });
</script>

<template>
  <!-- Table -->
  <div
    class="datatable-wrapper"
  >
    <vue-good-table
      :columns="columns"
      :rows="model.plans.data"
      :total-rows="model.plans.meta.total"
      :pagination-options="{
        enabled: true,
        perPage: model.plans.meta.per_page,
        total: model.plans.meta.total,
        setCurrentPage: model.plans.meta.current_page,
        perPageDropdownEnabled: false,
        dropdownAllowAll: false,
      }"
      :sort-options="{
        enabled: true,
        multipleColumns: true,
      }"
      mode="remote"
      style-class="vgt-table striped"
      @page-change="onPageChange"
      @sort-change="onSortChange"
      @column-filter="onColumnFilter"
    >
      <!-- Table Actions -->
      <template #table-actions>
        <div class="flex items-center gap-2 px-2">
          <AppSuccessButton
            @click.prevent="showFilters = !showFilters"
          >
            <i v-if="showFilters" class="bi bi-filter-left"></i>
            <i v-else class="bi bi-filter"></i>
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
        <!-- Action column -->
        <div
          v-if="props.column.field == 'action'"
          class="flex items-center gap-2"
        >
          <DropdownMenu
            :positioned="false"
            content-wrapper="div"
            content-classes="w-64 flex flex-col gap-2 left-auto right-0"
          >
            <template #trigger="{ showDropdown, toggleDropdown }">
              <AppLightButton
                class="inline-flex items-center gap-2"
                type="button"
                @click="toggleDropdown"
              >
                Actions
                <div>
                  <ChevronDown :open="showDropdown" />
                </div>
              </AppLightButton>
            </template>

            <!-- Content -->
            <!-- Edit -->
            <AppButton
              class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
              :href="route('admin.plans.edit', props.row)"
              plain
            >
              <i class="bi bi-pencil"></i>
              Edit
            </AppButton>

            <!-- Delete -->
            <AppButton
              class="inline-flex items-center gap-2 hover:bg-red-200 rounded-none"
              type="button"
              plain
              @click.prevent="confirmDelete(props.row)"
            >
              <i class="bi bi-trash"></i>
              Delete
            </AppButton>
          </DropdownMenu>
        </div>

        <!-- Subscriptions Field -->
        <div v-else-if="props.column.field == 'subscriptions'">
          {{ props.row.teams ? props.row.team_subscribers_count : props.row.subscribers_count }}
        </div>

        <!-- Verified Field -->
        <div v-else-if="props.column.field == 'usable'">
          <span
            v-if="props.row.usable"
            class="px-2 py-1 text-xs font-semibold text-teal-100 bg-teal-600 rounded-full whitespace-nowrap"
          >
            Live
          </span>
          <span
            v-else
            class="px-2 py-1 text-xs font-semibold text-red-100 bg-red-600 rounded-full whitespace-nowrap"
          >
            Disabled
          </span>
        </div>

        <span
          v-else
          class="text-sm"
          :class="{
            'text-slate-700 font-semibold': props.column.field == 'key',
          }"
        >
          <div v-if="props.column.field == 'name'">
            <a
              href="#"
              @click.prevent="$eventBus.emit('show-plan', props.row)"
            >
              {{ props.formattedRow[props.column.field] }} <strong>({{ props.row.formatted_interval }})</strong>
            </a>
            <br><br>
            <span v-if="props.row.teams" class="inline px-2 py-1 mt-3 rounded-full bg-blue-600 text-white text-xs font-semibold">
              Team plan
            </span>
            <span v-else class="inline px-2 py-1 mt-3 rounded-full bg-teal-600 text-white text-xs font-semibold">
              Personal
            </span>
          </div>
          <template v-else>{{ props.formattedRow[props.column.field] }}</template>
        </span>
      </template>
    </vue-good-table>

  </div>
  <!--/ Table -->
</template>

<style>
.datatable-wrapper .vgt-responsive {
  position: static !important;
}
</style>
