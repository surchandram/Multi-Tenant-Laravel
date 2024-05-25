<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { ref } from "vue";
  import { Head, Link, useForm, router } from "@inertiajs/vue3";
  import NProgress from 'nprogress';
  import AppInputError from '@/components/AppInputError.vue';

  const props = defineProps([
    'pageData',
  ]);

  const form = useForm({
    image: '',
    images: ''
  });

  const uploadImage = () => {
    form.post(route('admin.pages.image.store', props.pageData), {
      onSuccess: () => {
        form.reset();
      },
    });
  };

  const uploadImages = () => {
    form.post(route('admin.pages.images.store', props.pageData), {
      onSuccess: () => {
        form.reset();
      },
    });
  };

  const deleting = ref(null);

  const destroy = function (image) {
    form.processing = true;
    NProgress.start();
    deleting.value = image.id;
    
    axios.delete(route('admin.pages.media.destroy', [props.pageData, image.id])).then((response) => {
      $eventBus.emit('images::removed', [props.pageData, image]);
      
      NProgress.done();
      form.processing = false;

      router.reload();
    }).catch((error) => {
      form.processing = false
      
      NProgress.done();
      
      console.log(error)
    });
  };
</script>

<template>
  <Head :title="`${pageData.title} | Pages - Admin`" />
  
  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex flex-col mb-6">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
        <span class="font-semibold">
          Manage Images for Page: <br> {{ pageData.title }}
        </span>
      </h1>
    </div>

    <!-- Main Image -->
    <div class="w-full min-w-full px-6 md:px-8 py-6 bg-white">
      <div class="grid grid-cols-5 gap-8">
        <div class="col-span-full md:col-span-3">
          <form action="#" @submit.prevent="uploadImage">
            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Upload main image
              </label>
              
              <input
                type="file"
                accept=".png, .jpg, .jpeg, .svg"
                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter dark:file:bg-white/30 dark:file:text-white file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:focus:border-primary"
                @change="($event) => form.image = $event.target.files[0]"
              />
              
              <AppInputError :message="form.errors.image" />
            </div>
          
            <div class="mt-4">
              <button
                type="submit"
                class="
                  w-full
                  inline-flex
                  items-center
                  justify-center
                  px-6
                  py-2.5
                  bg-blue-600
                  text-white
                  font-medium
                  text-xs
                  leading-tight
                  uppercase
                  rounded
                  shadow-md
                  hover:bg-blue-700 hover:shadow-lg
                  focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                  active:bg-blue-800 active:shadow-lg
                  transition
                  duration-150
                  ease-in-out
                  disabled:opacity-25
                "
                :disabled="form.processing"
              >
                <div
                  v-show="form.processing && form.image"
                  class="animate-spin border border-t-0 w-6 h-6 rounded-full"
                  role="usable"
                  aria-hidden="true"
                ></div>
                Upload
              </button>
            </div>
          </form>
        </div>
        <div class="col-span-full md:col-span-2 min-h-128px md:min-h-480px">
          <p v-html="pageData.main_image_html"></p>

          <p v-if="!form.processing" class="mt-1">
            <a href="#" class="mt-3 hover:underline" v-if="pageData.main_image_html" @click.prevent="destroy(pageData.media.find((f) => pageData.main_image == f.original_url))">
              Remove
            </a>
          </p>

          <p
            class="mt-2"
            v-if="form.processing && deleting === pageData.media.find((f) => pageData.main_image == f.original_url)?.id"
          >
            Deleting...
          </p>
        </div>
      </div>
    </div>

    <!-- Images -->
    <div class="w-full min-w-full flex flex-col px-6 md:px-8 py-6 bg-white">
      <h3 class="mb-4 text-xl text-slate-700 font-semibold">
        Other Images
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="(image, index) in pageData.images_html" :key="index" class="image-slider min-w-full min-h-[256px]">
          <div class="min-w-content min-h-full" v-html="image"></div>
        </div>
      </div>

      <div class="mt-8">
        <form action="#" @submit.prevent="uploadImages">
          <label class="mb-3 block font-semibold text-lg text-black dark:text-white">
            Add Other Images
          </label>
          
          <input
            type="file"
            accept=".png, .jpg, .jpeg, .svg"
            multiple
            class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter dark:file:bg-white/30 dark:file:text-white file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:focus:border-primary"
            @change="($event) => form.images = $event.target.files"
          />

          <AppInputError :message="form.errors.image" />

          <div class="mt-4">
            <button
              type="submit"
              class="
                w-full
                inline-flex
                items-center
                justify-center
                px-6
                py-2.5
                bg-blue-600
                text-white
                font-medium
                text-xs
                leading-tight
                uppercase
                rounded
                shadow-md
                hover:bg-blue-700 hover:shadow-lg
                focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                active:bg-blue-800 active:shadow-lg
                transition
                duration-150
                ease-in-out
                disabled:opacity-25
              "
              :disabled="form.processing"
            >
              <div
                v-show="form.processing && form.images"
                class="animate-spin border border-t-0 w-6 h-6 rounded-full"
                role="usable"
                aria-hidden="true"
              ></div>
              Upload
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
