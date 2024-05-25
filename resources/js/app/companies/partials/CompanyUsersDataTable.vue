<script setup>
  import { ref, onMounted, reactive, toRefs, computed, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppSuccessButton from '@/components/AppSuccessButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import { useFilters } from '@/composables/filters.js';

  import 'vue-good-table-next/dist/vue-good-table-next.css';
  import { VueGoodTable } from 'vue-good-table-next';

  const props = defineProps(['model']);

  const emit = defineEmits(['toggle-filters']);

  const { model } = toRefs(props);

  const state = reactive({
    defaultSort: {
      field: 'created_at',
      type: 'desc',
    },
  });

  const form = useForm({});

  // filter helpers setup
  const { selectedFilters, withFilter, withoutFilter, withoutAllFilters, hasFilter, hasSelectedFilters } = useFilters(
    model.value.filters,
    'companies.users.index',
  );

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
      label: 'Role',
      field: 'role',
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
    var updatedType = type;

    if (hasFilter('sort_by')) {
      console.log(selectedFilters.value);
      const { key, value } = selectedFilters.value.sort_by;

      if (field == key && type == 'asc' && value == 'asc') {
        updatedType = 'desc';
      } else if (field == key && type == 'desc' && value == 'desc') {
        updatedType = 'none';
      }
    }

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
      value: updatedType,
    });
  };

  const onColumnFilter = (params) => {
    console.log(params);
    // withFilter('page', params.currentPage);
  };

  const disableButtons = computed(() => form.processing);

  const userShowLink = (user) => {
    if (form.processing) {
      return '';
    }

    return route('companies.users.show', [model.value.company, user]);
  };

  const confirmDelete = (user) => {
    if (!confirm(`Are you sure you want to remove ${user.name} from team?`)) {
      return;
    }

    form.delete(route('companies.users.destroy', [model.value.company, user]), {
      //
    });
  };

  const showFilters = ref(false);

  onMounted(() => {
    // initial sort
    if (_.has(selectedFilters.value, 'sort_by')) {
      state.defaultSort = {
        field: _.get(selectedFilters.value, 'sort_by')?.key,
        type: _.get(selectedFilters.value, 'sort_by')?.value,
      };
    }

    watch(showFilters, () => {
      emit('toggle-filters', showFilters.value);
    });
  });
</script>

<template>
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
      <template
        v-if="model.filters.length"
        #table-actions
      >
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
          <!-- View -->
          <AppSuccessButton
            :href="userShowLink(props.row)"
            :disabled="disableButtons"
          >
            <i class="bi bi-eye"></i>
          </AppSuccessButton>

          <!-- Delete -->
          <AppButton
            @click="confirmDelete(props.row)"
            :disabled="disableButtons"
          >
            <i class="bi bi-trash"></i>
          </AppButton>
        </div>

        <!-- Role Field -->
        <div v-else-if="props.column.field == 'role'">
          <span
            v-if="props.row.role"
            class="px-2 py-1 text-xs font-semibold text-teal-100 bg-teal-600 rounded-full whitespace-nowrap"
          >
            {{ props.row.role }}
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
</template>
