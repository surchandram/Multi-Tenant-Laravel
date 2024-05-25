<script>
  export default {
    pageLayout: "landing",
  };
</script>

<script setup>
  import { ref, onMounted } from "vue";
  import { Head, Link, usePage } from "@inertiajs/vue3";

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
  <Head :title="$page.props.settings.about_us_label" />
  
  <div class="wrapper">
    <!-- heading area -->
    <section
      class="w-full min-h-[500px] px-6 md:px-16 py-16 hero flex justify-between bg-gray-800"
      :style="bannerStyle"
    >
      <div class="w-full grid grid-cols-5 gap-6">
        <div class="col-span-full md:col-span-3 relative">
          <div class="w-full w-3/4 md:min-w-[256px] md:max-w-[360px] min-h-[164px] p-8 bg-orange-600 rounded-3xl">
            <div class="w-5/6 md:max-w-[360px] px-12 py-6 ml-auto mt-3 bg-white absolute left-12 rounded-3xl">
              <!-- Heading -->
              <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
                <span class="font-semibold">
                  {{ $page.props.settings.about_us_label }}
                </span>
              </h1>

              <!-- Excerpt -->
              <p class="text-sm text-slate-800 mb-4">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
              </p>
            </div>
          </div>
        </div>

        <div class="flex lg:items-start justify-center col-span-full md:col-span-2 mt-[256px] md:mt-0">
          <div class="w-[256px] h-[256px] rounded-full bg-slate-200" v-html="$page.props.logoData.logo_html"></div>
        </div>
      </div>
    </section>

    <!-- Content Area -->
    <div class="w-full min-w-full grid grid-cols-1 px-6 md:px-16 py-16 bg-white prose prose-lg lg:prose-2xl">
      <!-- Full body -->
      <div class="col-span-full" v-html="$page.props.pageData.body">
      </div>
    </div>
  </div>
</template>
