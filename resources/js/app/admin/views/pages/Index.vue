<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { Head, Link } from "@inertiajs/vue3";
  import Page from "@/components/admin/pages/Page.vue";

  defineProps([
    'pages'
  ]);
</script>

<template>
  <Head title="Pages | Admin" />
  
  <div class="wrapper relative">
    <!-- heading area -->
    <section class="w-full flex justify-between px-6 md:px-8 py-4">
      <div class="flex flex-col gap-4">
      	<!-- Heading -->
      	<h1 class="text-slate-800 text-2xl font-hairline leading-tight">
      	  <span class="font-semibold">
      	    Pages
      	  </span>
      	</h1>
      	
      	<!-- info -->
      	<p class="text-sm text-slate-800 mb-4">
      	  Manage different site pages.
      	</p>
      </div>

      <div v-show="false">
        <Link
          :href="route('admin.pages.create')"
          class="inline-flex px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
        >
          Add new page
        </Link>
      </div>
    </section>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <div class="flex flex-col gap-4">
        <Page
          v-for="page in pages.data"
          :key="page.id"
          :page-data="page"
        />
      </div>
    </div>
  </div>
</template>
