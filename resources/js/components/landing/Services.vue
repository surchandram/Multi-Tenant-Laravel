<script setup>
  import { Link } from "@inertiajs/vue3";
  import AppsPromoSlider from "@/components/landing/AppsPromoSlider.vue";

  defineProps([
    'services'
  ]);
</script>

<template>
  <section class="max-w-[100vw] pb-20 bg-gray-300 -mt-24">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap">
        <div class="pt-6 w-full md:w-4/12 px-4 text-center">
          <div
            class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
          >
            <div class="px-4 py-5 flex-auto">
              <div
                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-red-400"
              >
                <i class="bi bi-mortarboard"></i>
              </div>
              <h6 class="text-xl font-semibold">Devices and Log Access</h6>
              <p class="mt-2 mb-4 text-gray-600">
                Divide details about your product work into
                parts. A paragraph describing a feature will be enough.
              </p>
            </div>
          </div>
        </div>
        <div class="w-full md:w-4/12 px-4 text-center">
          <div
            class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
          >
            <div class="px-4 py-5 flex-auto">
              <div
                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-blue-400"
              >
                <i class="bi bi-person-add"></i>
              </div>
              <h6 class="text-xl font-semibold">Teams</h6>
              <p class="mt-2 mb-4 text-gray-600">
                Keep you user engaged by providing meaningful information.
                Remember that by this time, the user is curious.
              </p>
            </div>
          </div>
        </div>
        <div class="pt-6 w-full md:w-4/12 px-4 text-center">
          <div
            class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
          >
            <div class="px-4 py-5 flex-auto">
              <div
                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-400"
              >
                <i class="bi bi-credit-card"></i>
              </div>
              <h6 class="text-xl font-semibold">Simplified Billing</h6>
              <p class="mt-2 mb-4 text-gray-600">
                Write a few lines about each one. A paragraph describing a
                feature will be enough. Keep you user engaged!
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Apps Promo -->
      <div class="flex flex-wrap gap-8 md:gap-0 items-center mt-32">
        <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
          <div
            class="text-gray-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-gray-100"
          >
            <i class="bi bi-stack text-xl"></i>
          </div>
          <h3 class="text-3xl mb-2 font-semibold leading-normal">
            {{ $page.props.page_components.home_apps_promo.heading.value }}
          </h3>
          <article
            class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700"
            v-html="$page.props.page_components.home_apps_promo.overview.value"
          ></article>

          <!-- Apps Link -->
          <Link
            :href="route('apps.index')"
            class="inline-flex items-center gap-2 font-bold text-gray-800 mt-8"
          >
            Learn more <i class="bi bi-arrow-right text-2xl"></i>
          </Link>
        </div>

        <!-- Apps Slider -->
        <div class="w-full max-w-[100vw] md:w-4/12 px-4 mr-auto ml-auto">
          <AppsPromoSlider />
        </div>
      </div>
    </div>
  </section>
</template>