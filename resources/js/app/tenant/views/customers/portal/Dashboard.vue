<script>
  export default {
    pageLayout: "customer",
  };
</script>

<script setup>
  import { watch } from "vue";
  import { Head, Link } from "@inertiajs/vue3";
  import { useMomentJS } from '@/composables/momentjs';

  defineProps([
    'tenant',
    'model'
  ]);

  const titleCase = (value) => _.startCase(value);

  const { formatDateZone } = useMomentJS();
</script>

<template>
  <Head :title="`Customer Portal - ${$page.props.tenant.name}`" />

  <!-- Page Section -->
  <div
    class="container px-4 py-8 mx-auto space-y-10 lg:space-y-16 lg:px-8 lg:py-12 xl:max-w-7xl"
  >
    <div>
      <h2 class="mb-2 text-3xl font-semibold">
        Overview
      </h2>
      <h3 class="mb-8 text-sm font-medium text-slate-500">
        {{ __('customer.dashboard.greeting', { name: $page.props.auth.user.first_name }) }}
      </h3>

      <!-- Projects -->
      <div class="mb-8">
        <div
          class="
            grid
            grid-cols-1
            gap-4
            md:grid-cols-2
            md:gap-6
            lg:grid-cols-3
            2xl:gap-7.5
          "
        >
          <!-- Card Item Start -->
          <div
            v-for="project in model.projects"
            :key="project.id"
            class="w-full p-4 bg-white rounded-md shadow-md"
          >
            <Link
              :href="route('tenant.customers.portal.projects.show', project)"
              class="text-blue-500 hover:text-slate-600 focus:text-slate-600"
            >
              <h4 class="mb-3 text-sm font-semibold">{{ project.name }}</h4>
            </Link>

            <div class="mb-4">
              <p class="mb-2 text-sm font-medium text-slate-400">Property</p>
              <p class="text-sm font-semibold">
                {{ project.address.address_1 }}, {{ project.address.city }}, {{ project.address.state }}
              </p>
            </div>

            <div class="flex items-center justify-between mb-8">
              <div>
                <p class="mb-2 text-sm font-medium uppercase text-slate-400">Start</p>
                <p class="text-sm">{{ formatDateZone(project.starts_at) }}</p>
              </div>
              <!-- Deadline -->
              <div>
                <p class="mb-2 text-sm font-medium uppercase text-slate-400">Deadline</p>
                <p class="text-sm">{{ formatDateZone(project.ends_at) }}</p>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="inline-flex flex-wrap items-center gap-2">
                <p class="text-xs font-semibold">Status</p>
                <div class="px-2 py-1 text-sm text-center text-white bg-blue-500 rounded-md">
                  {{ project.status.name }}
                </div>
              </div>
            </div>
          </div>
          <!-- Card Item End -->
        </div>
      </div>
      <!-- /Projects -->
    </div>
  </div>
  <!-- END Page Section -->
</template>
