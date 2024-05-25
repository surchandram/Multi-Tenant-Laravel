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

  const props = defineProps(["pageData"]);

  const form = useForm({
    title: props.pageData.title,
    uri: props.pageData.uri,
    name: props.pageData.name,
    image: '',
    body: props.pageData.body,
    usable: props.pageData.usable,
    hidden: props.pageData.hidden,
    seo_title: props.pageData.seo_title,
    seo_description: props.pageData.seo_description,
  });

  const store = () => {
    form.patch(route('admin.pages.update', props.pageData), {
      onSuccess: () => {
        form.reset()
      }
    })
  };
</script>

<template>
  <Head title="Edit Page | Pages - Admin`" />

  <div>
    <!-- Form Wrapper -->
    <div id="pagesWrapper">
      <div class="mb-4 bg-white shadow rounded-md">
        <div class="p-6">
          <!-- header -->
          <div class="pb-3 border-b">
            <h4 class="text-slate-800 title-lg font-semibold">
              Editing page: {{ pageData.name }}
            </h4>

            <p class="mt-2 text-slate-500">Change the fields below to update page</p>
          </div>

          <form action="#" @submit.prevent="store">
            <!-- Title -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="title">
                Title
              </label>
              <AppInput id="title" v-model="form.title" type="text" class="form-control mt-2" name="title" />

              <AppInputError :message="form.errors.title" />
            </div>

            <!-- Uri -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="uri">
                Uri
              </label>
              <AppInput id="uri" v-model="form.uri" type="text" class="form-control mt-2" name="uri" />

              <AppInputError :message="form.errors.uri" />
            </div>

            <!-- Name -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="name">
                Route name
              </label>
              <AppInput id="name" v-model="form.name" type="text" class="form-control mt-2" name="name" />
              <AppInputError :message="form.errors.name" />
            </div>

            <!-- Body -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="body">
                Body
              </label>
              <Editor
                id="body"
                v-model="form.body"
                class="py-2 mb-5 mt-2 border-bottom"
                name="body"
                placeholder="Start typing here..."
              />

              <AppInputError :message="form.errors.body" />
            </div>

            <!-- Status and Homepage -->
            <!-- Status -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="usable">
                Usable
              </label>
              <select id="usable" v-model="form.usable" name="usable" class="form-control block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none focus:ring-blue-600">
                <option :value="true">active</option>
                <option :value="false">inactive</option>
              </select>
              <AppInputError :message="form.errors.usable" />
            </div>

            <!-- Hide from Menus -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="hidden">
                Hide from Menus
              </label>
              <select id="hidden" v-model="form.hidden" name="hidden" class="form-control block w-full px-3 py-2 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none focus:ring-blue-600">
                <option :value="false">no</option>
                <option :value="true">yes</option>
              </select>
              <AppInputError :message="form.errors.hidden" />
            </div>

            <!-- SEO title -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="seo_title">
                SEO Title
              </label>
              <AppInput id="seo_title" v-model="form.seo_title" type="text" name="seo_title" class="form-control mt-2" />
              <AppInputError :message="form.errors.seo_title" />
            </div>

            <!-- SEO description -->
            <div class="form-group mt-4">
              <label class="form-label inline-block mb-2 text-gray-800 font-semibold" for="seo_description">
                SEO Description
              </label>
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
    <!-- /#pagesWrapper -->
  </div>
</template>
