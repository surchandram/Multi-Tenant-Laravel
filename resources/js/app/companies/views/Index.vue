<script>
  export default {
    pageLayout: 'auth',
  };
</script>

<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import LayoutSlot from '@/components/LayoutSlot.vue';
  import Stats from '../partials/Stats.vue';
  import Team from '../partials/Team.vue';

  const props = defineProps(['teams']);
</script>

<template>
  <Head title="Companies" />

  <div class="min-h-full">
    <!-- Top Header -->
    <div class="w-full relative py-6">
      <div class="flex items-center justify-between px-4">
        <div>
          <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Companies</h3>
          <div class="text-xs font-semibold text-slate-700">
            List of companies and the related apps you are a member of.
          </div>
        </div>

        <Link
          class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-2 rounded outline-none focus:outline-none mr-1 mb-1"
          style="transition: all 0.15s ease"
          :href="route('companies.create')"
        >
          Add new company <i class="bi bi-plus"></i>
        </Link>
      </div>
    </div>

    <div class="flex flex-wrap mt-1 relative">
      <div class="w-full mb-12 xl:mb-0 py-2">
        <div class="w-full min-w-0 flex flex-col mb-6 break-words bg-transparent relative py-2">
          <!-- Companies list -->
          <div
            v-for="team in teams"
            :key="team.id"
          >
            <!-- Team Name -->
            <div class="px-4 py-2 mb-3">
              <h3 class="text-lg font-semibold text-slate-700 tracking-wide">
                {{ team.name }}
              </h3>
            </div>

            <!-- Team Cards -->
            <div class="w-full flex gap-4 px-4 mt-4">
              <Team
                v-for="(role, index) in team.current_user_roles"
                :key="index"
                :company="team"
                :role="role"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
