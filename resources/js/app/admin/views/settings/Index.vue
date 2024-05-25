<script>
  export default {
    pageLayout: "admin",
  };
</script>

<script setup>
  import { inject } from "vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';

  const props = defineProps([
    'settings',
  ]);

  const form = useForm({
    key: '',
    value: '',
  });

  const change = (setting) => {
    form.key = setting.key;
    form.value = setting.value;
    form.type = setting.type;
  };

  const humanReadable = (word) => {
    return _.startCase(word);
  };

  const store = () => {
    form.post(route('admin.settings.store'), {
      onSuccess: () => {
        form.reset();
      },
    });
  };
</script>

<template>
  <Head title="Settings - Admin" />
  
  <div class="flex flex-col gap-10 relative">
    <!-- heading area -->
    <div class="w-full flex flex-col mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
        <span class="font-semibold">
          Settings
        </span>
      </h1>
    </div>

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6 bg-white">
      <div v-if="form.key" class="flex flex-col">
        <form action="#" @submit.prevent="store">
          <div>
            <label
              v-if="form.type == 'boolean'"
             class="inline-flex items-center mb-3 block font-semibold text-sm text-black dark:text-white"
            >
              <input
                type="checkbox"
                class="mr-2"
                name="value"
                v-model="form.value"
              />

              <span>{{ humanReadable(form.key) }}</span>
            </label>
            
            <template v-else>
              <label class="mb-3 block font-semibold text-sm text-black dark:text-white">
                {{ humanReadable(form.key) }}
              </label>
              
              <AppInput class="mt-2" name="value" v-model="form.value" />
            </template>
            
            <AppInputError :message="form.errors.value" />
          </div>
        
          <div class="flex items-center justify-end gap-2 mt-4">
            <button type="button" class="px-4 py-2 hover:underline" @click.prevent="form.reset()">
              Cancel
            </button>

            <button
              type="submit"
              class="
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
                v-show="form.processing"
                class="animate-spin border border-t-0 w-6 h-6 mr-2 rounded-full"
                role="usable"
                aria-hidden="true"
              ></div>
              Save Changes
            </button>
          </div>
        </form>
      </div>

      <div v-else
        class="grid grid-cols-5 mt-4"
        :key="index"
        v-for="(setting, index) in settings"
      >
        <div class="col-span-full md:col-span-2">
          <h4 class="text-sm font-semibold text-slate-600">{{ humanReadable(setting.key) }}</h4>
        </div>
        <div class="col-span-full md:col-span-2">
          {{ setting.value }}
        </div>
        <div class="col-span-full md:col-span-1">
          <a href="#" class="hover:underline" @click.prevent="change(setting)">Change</a>
        </div>
      </div>
    </div>
  </div>
</template>
