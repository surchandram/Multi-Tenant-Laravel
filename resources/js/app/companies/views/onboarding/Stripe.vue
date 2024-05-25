<script setup>
  defineOptions({
    pageLayout: 'plain',
  });

  defineProps(['model']);
</script>

<template>
  <div
    class="min-w-full min-h-screen flex items-center justify-center flex-wrap mx-auto bg-slate-100 dark:bg-slate-800"
  >
    <div class="md:max-w-4xl p-4 space-y-4 mx-auto">
      <div
        class="overflow-hidden border border-gray-200 rounded-lg border-opacity-60 shadow bg-white dark:bg-indigo-800"
      >
        <div class="p-6 space-y-6 text-center">
          <h1 class="text-lg font-medium text-gray-900 title-font">Stripe Onboarding</h1>

          <p class="text-slate-700 leading-relaxed">
            Connect <span class="font-medium">{{ model.company.name }}</span> with Stripe to accept payments.
          </p>

          <div class="flex flex-wrap items-center justify-center">
            <a
              :href="route('companies.onboarding.stripe.redirect', model.company)"
              class="inline-flex items-center p-2 md:mb-2 lg:mb-0 rounded text-indigo-500 font-medium bg-indigo-200 hover:text-slate-600 hover:bg-indigo-100 focus:bg-indigo-100"
              >Proceed to Stripe
              <svg
                class="w-4 h-4 ml-2"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M5 12h14"></path>
                <path d="M12 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Dashboard Link -->
      <p class="text-center">
        <a
          :href="route('tenant.switch', model.company)"
          class="flex items-center justify-center gap-2 text-slate-600 font-medium hover:text-indigo-500 active:text-indigo-500"
          ><i class="bi bi-arrow-left text-lg"></i> Return to Dashboard</a
        >
      </p>
      <!-- END Dashboard Link -->
    </div>
  </div>
</template>
