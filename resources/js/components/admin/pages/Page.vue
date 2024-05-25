<script setup>
  import { Link } from "@inertiajs/vue3";

  defineProps([
    'pageData'
  ]);
</script>

<template>
  <div class="w-full flex flex-col items-center-center gap-8 px-8 py-6 mx-auto bg-white rounded-lg shadow-md">
    <div class="grid md:grid-cols-2 gap-8">
      <div class="w-full h-[256px] flex bg-slate-400 rounded-lg overflow-hidden">
        <Link
          v-if="!pageData.has_main_image"
          :href="route('admin.pages.images.index', pageData)"
          class="my-auto mx-auto"
        >
          Click to upload an image
        </Link>
        <img
          v-else-if="pageData.has_main_image && !pageData.main_image_html"
          class="w-full"
          :src="pageData.main_image"
          alt="..."
        />
        <p
          v-else
          class="text-center"
          :class="{
            'w-full h-full': pageData.has_main_image,
            'my-auto mx-auto': !pageData.has_main_image,
          }"
          v-html="pageData.main_image_htmlpageData.main_image_html"
        ></p>
      </div>

      <div>
        <Link :href="route('admin.pages.images.index', pageData)">
          <h4 class="mt-2 text-xl text-slate-600 font-semibold">
            {{ pageData.title }}
          </h4>
        </Link>

        <p class="mt-2 text-lg">
          Created on: {{ moment(pageData.created_at).format('MM/DD/YYYY') }}
        </p>
      </div>
    </div>

    <div class="flex items-center justify-end gap-2 mt-2">
      <Link :href="route('admin.pages.edit', pageData)" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-primary hover:opacity-90 uppercase rounded">
        Edit
      </Link>
      <Link :href="route('admin.pages.images.index', pageData)" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-meta-3 hover:opacity-90 uppercase rounded">
        Manage Images
      </Link>
    </div>
  </div>
</template>
