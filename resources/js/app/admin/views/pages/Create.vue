<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { ref, onMounted } from 'vue';
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AppInputError from '@/components/AppInputError.vue';
  import AppInput from '@/components/admin/AppInput.vue';
  import Editor from '@/components/Editor.vue';

  const form = useForm({
    name: '',
    image: '',
    overview: '',
    description: 'Start describing your package here...',
    usable: false,
    show_homepage: false,
    seo_title: '',
    seo_description: '',
  });

  const store = () => {
    form.post(route('admin.packages.store'), {
      onSuccess: () => {
        form.reset()
      }
    })
  };
</script>

<template>
  <Head title="Add a package" />

  <div>
    <!-- Form Wrapper -->
    <div id="packagesWrapper">
      <div class="mb-4 bg-white shadow rounded-md">
        <div class="p-6">
          <!-- header -->
          <div>
            <h4 class="text-slate-800 title-lg font-semibold">
              Add new package
            </h4>

            <p class="mt-2 text-slate-500">Fill in the fields below to create a new package</p>
          </div>

          <form action="#" @submit.prevent="store">
            <!-- Name and Thumbnail -->
            <!-- Name -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="name">Package name</label>
              <AppInput id="name" v-model="form.name" type="text" class="form-control mt-2" name="name" />
              <AppInputError :message="form.errors.name" />
            </div>

            <!-- Main Image -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold">
                Main Image
              </label>

              <input
                type="file"
                accept=".png, .jpg, .jpeg"
                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter dark:file:bg-white/30 dark:file:text-white file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:focus:border-primary"
                @change="($event) => form.image = $event.target.files[0]"
              />
              <AppInputError :message="form.errors.image" />
            </div>

            <!-- Overview -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="overview">Overview</label>
              <textarea
                id="overview"
                v-model="form.overview"
                name="overview"
                placeholder="something short and memorable"
                cols="30"
                rows="3"
                maxlength="200"
                class="form-control
                  block
                  w-full
                  px-3
                  py-1.5
                  text-base
                  font-normal
                  text-gray-700
                  bg-white bg-clip-padding
                  border border-solid border-gray-300
                  rounded
                  transition
                  ease-in-out
                  m-0
                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                "
              ></textarea>

              <AppInputError :message="form.errors.overview" />
            </div>

            <!-- Description -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="description">Description</label>
              <Editor
                id="description"
                v-model="form.description"
                class="py-2 mb-5 mt-2 border-bottom"
                name="description"
                placeholder="Start typing here..."
              />

              <AppInputError :message="form.errors.description" />
            </div>

            <!-- Status and Homepage -->
            <!-- Status -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="usable">Usable</label>
              <select id="usable" v-model="form.usable" name="usable" class="form-control block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none focus:ring-blue-600">
                <option :value="true">active</option>
                <option :value="false">inactive</option>
              </select>
              <AppInputError :message="form.errors.usable" />
            </div>

            <!-- Show on Homepage -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="show_home_page">Featured on homepage</label>
              <select id="show_home_page" v-model="form.show_homepage" name="show_homepage" class="form-control block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none focus:ring-blue-600">
                <option :value="false">no</option>
                <option :value="true">yes</option>
              </select>
              <AppInputError :message="form.errors.show_homepage" />
            </div>

            <!-- SEO title -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="seo_title">SEO Title</label>
              <AppInput id="seo_title" v-model="form.seo_title" type="text" name="seo_title" class="form-control mt-2" />
              <AppInputError :message="form.errors.seo_title" />
            </div>

            <!-- SEO description -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="seo_description">SEO Description</label>
              <textarea
                id="seo_description"
                v-model="form.seo_description"
                name="seo_description"
                cols="30"
                rows="3"
                class="form-control
                  block
                  w-full
                  px-3
                  py-1.5
                  text-base
                  font-normal
                  text-gray-700
                  bg-white bg-clip-padding
                  border border-solid border-gray-300
                  rounded
                  transition
                  ease-in-out
                  m-0
                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                "
              ></textarea>
              <AppInputError :message="form.errors.seo_description" />
            </div>

            <div class="flex items-center justify-end mt-4">
              <button
                type="submit"
                :disabled="form.processing"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1 disabled:opacity-25"
              >
                <div
                  v-show="form.processing"
                  class="animate-spin border border-t-0 w-6 h-6 rounded-full"
                  role="usable"
                  aria-hidden="true"
                ></div>
                Save
              </button>
            </div>
          </form>
        </div>
        <!-- /card-body -->
      </div>
      <!-- /card -->
    </div>
    <!-- /#packagesWrapper -->
  </div>
</template>
