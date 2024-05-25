<script setup>
  import { computed } from 'vue';
  import { Link } from '@inertiajs/vue3';

  const props = defineProps(['company', 'role']);

  const logoStyles = computed(() => {
    return {
      backgroundImage: `url('${props.company.logo}')`,
      backgroundPosition: 'center center',
      backgroundSize: 'cover',
    };
  });

  const resolvedRoute = computed(() => {
    return 'tenant.switch';
  });
</script>

<template>
  <div
    v-permission="['view company dashboard', `company:${company.id}`]"
    class="w-full lg:w-6/12 xl:w-4/12 px-4"
  >
    <div class="flex flex-col min-w-0 break-words bg-white hover:bg-slate-200 rounded mb-6 xl:mb-0 shadow-lg relative">
      <div class="flex-auto p-4">
        <div class="flex items-start justify-between gap-3">
          <!-- Team Summary -->
          <div class="flex flex-wrap gap-2 items-start">
            <!-- Dashboard | App Logo -->
            <div class="relative w-auto flex-initial">
              <div
                class="text-slate-800 p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-lightBlue-500"
                :style="logoStyles"
              >
                <i
                  v-if="!company.has_logo"
                  class="bi bi-stack"
                ></i>
              </div>
            </div>

            <!-- Team Details -->
            <div class="flex flex-col flex-1 gap-2">
              <h5
                v-if="role.scope"
                class="text-slate-400 uppercase font-bold text-xs"
              >
                {{ company.name }}
              </h5>

              <h5
                v-else
                class="text-slate-400 uppercase font-bold text-xs"
              >
                Dashboard
              </h5>

              <div>
                <span class="px-2 py-1 font-semibold text-xs text-white bg-blue-600 rounded-full">
                  {{ role.name }}
                </span>
              </div>
            </div>
          </div>
          <!-- /Team Summary -->

          <!-- Settings -->
          <div
            v-permission="['update company', `company:${company.id}`]"
            class="relative w-auto flex-initial"
          >
            <Link
              :href="route('companies.show', company)"
              class="text-slate-800 text-center inline-flex items-center justify-center w-12 h-12 rounded-full bg-lightBlue-500"
            >
              <i class="bi bi-gear text-lg"></i>
            </Link>
          </div>
        </div>

        <div class="flex items-baseline justify-between py-4 mt-4">
          <!-- User's last activity -->
          <p class="text-sm text-slate-400">
            <span class="text-emerald-500 mr-2"> <i class="bi bi-activity"></i> 12% </span>
            <span class="whitespace-nowrap"> Since last month </span>
          </p>

          <a
            :href="route(resolvedRoute, company)"
            class="inline-flex items-center gap-2 text-sm font-semibold text-pink-600 hover:text-slate-600"
          >
            Go <i class="bi bi-arrow-right text-lg"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
