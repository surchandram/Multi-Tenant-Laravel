<script>
  export default {
    pageLayout: 'company',
  };
</script>

<script setup>
  import { Head } from '@inertiajs/vue3';
  import StatCard from '@/components/stats/StatCard.vue';
  import ProjectGridWrapper from '@/components/projects/ProjectGridWrapper.vue';
  import ProjectGridCard from '@/components/projects/ProjectGridCard.vue';
  import AppButton from '@/components/AppButton.vue';

  defineProps(['tenant', 'model']);

  const titleCase = (value) => _.startCase(value);
</script>

<template>
  <Head :title="`Dashboard - ${$page.props.tenant.name}`" />

  <div>
    <!-- Projects Stats -->
    <div>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-12 md:gap-6">
        <!-- Card Item Start -->
        <StatCard
          v-for="(value, key) in model.new_projects_count"
          :key="key"
          :label="titleCase(key) + ' | Projects'"
          :value="value"
          theme="admin"
        />
        <!-- Card Item End -->
      </div>
    </div>
    <!-- /Projects Stats -->

    <!-- Projects -->
    <div class="py-12 space-y-6">
      <div class="flex items-center justify-between">
        <h3 class="mb-4 text-sm text-slate-700 font-semibold dark:text-slate-200">
          {{ __('tenant.labels.projects') }}
        </h3>

        <AppButton
          native
          :href="route('restore.projects.create')"
        >
          {{ __('tenant.labels.start_new_project') }}
        </AppButton>
      </div>

      <!-- Projects Grid -->
      <ProjectGridWrapper>
        <!-- Project Card -->
        <ProjectGridCard
          v-for="(project, index) in model.all_projects"
          :key="index"
          :project="project"
        />
        <!-- END Project Card -->
      </ProjectGridWrapper>
      <!-- END Projects Grid -->
    </div>
    <!-- END Projects -->
  </div>
</template>
