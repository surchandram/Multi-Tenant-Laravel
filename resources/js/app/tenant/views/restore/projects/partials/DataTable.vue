<script setup>
  import { ref, onMounted, reactive } from "vue";
  import { Link } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import AppSuccessButton from "@/components/AppSuccessButton.vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import DropdownMenu from "@/components/DropdownMenu.vue";
  import ChevronDown from "@/components/ChevronDown.vue";
  import { useFilters } from "@/composables/filters.js";
  import { useMomentJS } from "@/composables/momentjs.js";

  import "vue-good-table-next/dist/vue-good-table-next.css";
  import { VueGoodTable } from "vue-good-table-next";

  const props = defineProps(["model"]);

  const { dateFormat } = useMomentJS();

  const state = reactive({
    defaultSort: {
      field: "created_at",
      type: "desc",
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
  } = useFilters(props.model.filters, "restore.projects.index");

  const columns = [
    {
      label: "#",
      field: "id",
      filterable: false,
      sortable: false,
    },
    {
      label: "Name",
      field: "name",
      filterable: true,
    },
    {
      label: "Owner",
      field: function (project) {
        return project.owner ? project.owner.name : "unknown";
      },
      filterable: true,
    },
    {
      label: "Address",
      field: "address.address_1",
      filterable: true,
    },
    {
      label: "Type",
      field: "type.name",
      filterable: true,
    },
    {
      label: "Team",
      field: "team.name",
      filterable: true,
    },
    {
      label: "Status",
      field: "status.name",
      filterable: true,
    },
    {
      label: "Created",
      field: "created_at",
      formatFn: (value) => {
        return dateFormat(value, "MM/DD/YYYY");
      },
      filterable: false,
      sortable: false,
    },
    {
      label: "Action",
      field: "action",
      sortable: false,
    },
  ];

  const statusMatches = (projectData) => {
    const statuses = {
      Draft: "text-slate-700 bg-slate-200",
      Ongoing: "text-teal-100 bg-teal-600",
    };

    return statuses[projectData.name] || statuses["Draft"];
  };

  const fieldPresent = (keys, field) => {
    return _.includes(_.castArray(keys), field);
  };

  const onPageChange = (params) => {
    withFilter("page", params.currentPage);
  };

  const onSortChange = (params) => {
    const { field, type } = params[0];
    var key = field;

    if (field == "name") {
      key = "first_name";
    }

    if (field == "created_at") {
      key = "created";
    }

    if (type == "none") {
      withoutFilter("sort_by");
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

  const showFilters = ref(false);

  onMounted(() => {
    // initial sort
    if (_.has(selectedFilters.value, "sort_by")) {
      state.defaultSort = {
        field: _.get(selectedFilters.value, "sort_by")?.key,
        type: _.get(selectedFilters.value, "sort_by")?.value,
      };
    }
  });
</script>

<template>
  <!-- Table -->
  <div class="datatable-wrapper">
    <vue-good-table
      :columns="columns"
      :rows="model.projects.data"
      :total-rows="model.projects.meta.total"
      :pagination-options="{
        enabled: true,
        perPage: model.projects.meta.per_page,
        total: model.projects.meta.total,
        setCurrentPage: model.projects.meta.current_page,
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
          <AppSuccessButton @click.prevent="showFilters = !showFilters">
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
          <AppLightButton v-if="hasSelectedFilters" @click.prevent="withoutAllFilters">
            <i class="bi bi-x"></i> Clear filters
          </AppLightButton>
          <!-- /Clear Filters -->
        </div>
      </template>

      <!-- Row Slot -->
      <template #table-row="props">
        <!-- Avatar column -->
        <div v-if="props.column.field == 'avatar'" class="flex items-center justify-center">
          <img v-if="props.row.has_avatar" class="h-[64px]" :src="props.row.avatar" alt="..." />
          <i v-else class="bi bi-person text-3xl text-center"></i>
        </div>

        <!-- Action column -->
        <div v-else-if="props.column.field == 'action'" class="flex items-center gap-2">
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
                {{ __('app.labels.actions') }}
                <div>
                  <ChevronDown :open="showDropdown" />
                </div>
              </AppLightButton>
            </template>

            <!-- Dropdown Menu Content -->
            <!-- Send for Approval -->
            <AppButton
              v-if="props.row.not_approved"
              class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
              :href="route('restore.projects.invitations.customer.store', props.row)"
              plain
              as="button"
              method="post"
            >
              <i class="bi bi-send"></i>
              {{ __('tenant.project.customer_invite_button') }}
            </AppButton>
            <!-- END Send for Approval -->

            <!-- View -->
            <AppButton
              class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
              :href="route('restore.projects.show', props.row)"
              plain
            >
              <i class="bi bi-eye"></i>
              {{ __('app.labels.view') }}
            </AppButton>
            <!-- END View -->

            <!-- Edit -->
            <AppButton
              class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
              :href="route('restore.projects.edit', props.row)"
              plain
            >
              <i class="bi bi-pencil-square"></i>
              {{ __('app.labels.edit') }}
            </AppButton>
            <!-- END Edit -->

            <!-- Moisture Map -->
            <AppButton
              v-if="props.row.affected_areas_count > 0"
              class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
              :href="route('restore.projects.moisture-map.index', props.row)"
              plain
            >
              <i class="bi bi-moisture"></i>
              {{ __('tenant.labels.moisture_map') }}
            </AppButton>
            <!-- END Moisture Map -->

            <!-- Psychrometric Report -->
            <AppButton
              v-if="props.row.affected_areas_count > 0"
              class="inline-flex items-center gap-2 hover:bg-slate-200 rounded-none"
              :href="route('restore.projects.psychrometric-report.index', props.row)"
              plain
            >
              <i class="bi bi-thermometer-half"></i>
              {{ __('tenant.labels.psychrometric_report') }}
            </AppButton>
            <!-- END Psychrometric Report -->
          </DropdownMenu>
        </div>

        <!-- Status -->
        <div v-else-if="props.column.field == 'status.name'">
          <span
            class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap"
            :class="statusMatches(props.row)"
          >{{ props.formattedRow[props.column.field] }}</span>
        </div>

        <Link
          v-else-if="props.column.field == 'name'"
          :href="route('restore.projects.show', props.row)"
          class="text-sm text-teal-600 hover:underline focus:underline font-semibold"
        >{{ props.formattedRow[props.column.field] }}</Link>

        <span
          v-else
          class="text-sm"
          :class="{
            'text-slate-700 font-semibold': fieldPresent([
              'address.address_1',
              'team.name',
            ], props.column.field),
          }"
        >{{ props.formattedRow[props.column.field] }}</span>
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
