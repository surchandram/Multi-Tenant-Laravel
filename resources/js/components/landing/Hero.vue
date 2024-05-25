<script setup>
  import { ref, onMounted } from "vue";
  import { Link, usePage } from "@inertiajs/vue3";

  const bannerStyle = ref({});

  onMounted(() => {
    const currentPageData = usePage().props.pageData;

    if (currentPageData?.has_main_image) {
      bannerStyle.value = {
        backgroundImage: `url('${ currentPageData.main_image }')`,
        backgroundPosition: 'center center',
        backgroundSize: 'cover',
        backgroundRepeat: 'no-repeat'
      }
    }
  });
</script>

<template>
  <div
    class="relative pt-16 pb-32 flex content-center items-center justify-center"
    style="min-height: 75vh"
  >
    <div
      class="absolute top-0 w-full h-full bg-center bg-cover"
      :style="bannerStyle"
    >
      <span
        id="blackOverlay"
        class="w-full h-full absolute opacity-75 bg-transparent"
      ></span>
    </div>

    <div class="container relative mx-auto">
      <div class="items-center flex flex-wrap">
        <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
          <div class="pr-12 pt-12">
            <h1 class="text-white font-semibold text-5xl">
              {{ $page.props.settings.tagline }}
            </h1>
            <p class="mt-4 text-lg text-gray-300">
              {{ $page.props.settings.subtitle }}
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <div
      class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
      style="height: 70px"
    >
      <svg
        class="absolute bottom-0 overflow-hidden"
        xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="none"
        version="1.1"
        viewBox="0 0 2560 100"
        x="0"
        y="0"
      >
        <polygon
          class="text-gray-300 fill-current"
          points="2560 0 2560 100 0 100"
        ></polygon>
      </svg>
    </div>
  </div>
</template>
