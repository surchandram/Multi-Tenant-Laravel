<script>
  export default {
    pageLayout: "landing",
  };
</script>

<script setup>
  import { ref, onMounted } from "vue";
  import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

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

  const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
    send_copy: true,
  });

  const store = () => {
    form.post(route('contact.store'), {
      onSuccess: () => {
        form.reset()
      }
    });
  };
</script>

<template>
  <Head :title="$page.props.settings.contact_us_label" />

  <div class="wrapper">
    <section
      class="w-full min-h-[500px] px-6 md:px-16 py-16 hero flex justify-between bg-gray-600"
      :style="bannerStyle"
    >
      <div class="w-full grid grid-cols-5 gap-6">
        <div class="col-span-full lg:col-span-2 relative">
          <div class="w-full w-3/4 md:min-w-[256px] md:max-w-[360px] min-h-[212px] md:min-h-[196px] p-8 bg-orange-600 rounded-3xl">
            <div class="w-5/6 md:max-w-[360px] px-12 py-6 ml-auto mt-3 bg-white absolute left-12 rounded-3xl">
              <!-- Heading -->
              <h1 class="text-slate-800 text-2xl font-hairline leading-tight">
                <span class="font-semibold">
                  {{ $page.props.settings.contact_us_label }}
                </span>
              </h1>

              <!-- Excerpt -->
              <p class="text-sm text-slate-800 mt-4">
                {{ $page.props.settings['pages.contact.info_label'] }}
              </p>
            </div>
          </div>
        </div>

        <div class="flex lg:items-start justify-center col-span-full lg:col-span-3 mt-12 md:mt-0">
          <div class="w-full px-4 py-6 bg-white rounded-lg">
            <form action="#" @submit.prevent="store">
              <div class="mb-6">
                <label for="name" class="inline-flex mb-2 text-sm font-semibold">
                  {{ $page.props.settings.contact_name_label || 'Full name' }}
                </label>
                <input
id="name"
                  v-model="form.name"
                  type="text" class="block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-orange-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-orange-600 focus:outline-none focus:ring-orange-600" placeholder="Your full name" />
              </div>

              <div class="mb-6">
                <label for="subject" class="inline-flex mb-2 text-sm font-semibold">
                  {{ $page.props.settings.contact_subject_label || 'Subject' }}
                </label>
                <input
id="subject"
                  v-model="form.subject"
                  type="text" class="block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-orange-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-orange-600 focus:outline-none focus:ring-orange-600" placeholder="Subject" />
              </div>

              <div class="mb-6">
                <label for="email" class="inline-flex mb-2 text-sm font-semibold">
                  {{ $page.props.settings.contact_email_label || 'Email Address' }}
                </label>
                <input
id="email"
                  v-model="form.email"
                  type="email" class="block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-orange-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-orange-600 focus:outline-none focus:ring-orange-600" placeholder="Email address" />
              </div>

              <div class="mb-6">
                <label for="message" class="inline-flex mb-2 text-sm font-semibold">
                  {{ $page.props.settings.contact_message_label || 'Message' }}
                </label>
                <textarea
                  id="message"
                  v-model="form.message" class="block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-orange-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-orange-600 focus:outline-none focus:ring-orange-600" rows="3" placeholder="Message"></textarea>
              </div>

              <div class="form-check text-center mb-6">
                <input
id="send_copy"
                  v-model="form.send_copy"
                  type="checkbox" class="form-check-input appearance-none h-4 w-4 border border-orange-300 rounded-sm bg-white checked:bg-orange-600 checked:border-orange-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer focus:ring-orange-600" />
                <label class="form-check-label inline-block text-gray-800" for="send_copy">
                  {{ $page.props.settings.send_message_copy_label }}
                </label>
              </div>

              <button
type="submit"
                class="w-full px-6 py-4 bg-orange-600 text-white font-medium text-lg leading-tight uppercase rounded-full shadow-md hover:bg-orange-700 hover:shadow-lg focus:bg-orange-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-orange-800 active:shadow-lg transition duration-150 ease-in-out disabled:opacity-25 disabled:cursor-blocked"
                :disabled="form.processing"
              >
                {{ $page.props.settings.send_label }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
