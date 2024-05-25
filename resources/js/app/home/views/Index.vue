<script>
export default {
  pageLayout: "landing",
};
</script>

<script setup>
  import { ref, onMounted } from "vue";
  import { Head, Link, usePage } from "@inertiajs/vue3";
  import Hero from "@/components/landing/Hero.vue";
  import Services from "@/components/landing/Services.vue";

  const bannerStyle = ref({});

  onMounted(() => {
    // setup page banner
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
  <div class="wrapper">
    <!-- Hero -->
    <Hero />

    <!-- Services Promo -->
    <Services />
    
    <!-- About Section -->
    <section class="relative py-20">
      <div
        class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
        style="height: 80px"
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
            class="text-white fill-current"
            points="2560 0 2560 100 0 100"
          ></polygon>
        </svg>
      </div>
      <div class="grid container mx-auto px-4">
        <div class="items-center flex flex-wrap">
          <div class="w-full md:w-4/12 ml-auto mr-auto px-4">
            <img
              alt="..."
              class="max-w-full rounded-lg shadow-lg"
              src="https://images.unsplash.com/photo-1555212697-194d092e3b8f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=634&amp;q=80"
            />
          </div>
          <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
            <div class="md:pr-12">
              <div
                class="text-pink-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-pink-300"
              >
                <i class="bi bi-rocket text-xl"></i>
              </div>
              <h3 class="text-3xl font-semibold">{{ $page.props.appName }}</h3>
              <p class="mt-4 text-lg leading-relaxed text-gray-600">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, quia!
              </p>
              <ul class="list-none mt-6">
                <li class="py-2">
                  <div class="flex items-center">
                    <div>
                      <span
                        class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                        ><i class="bi bi-fingerprint"></i
                      ></span>
                    </div>
                    <div>
                      <h4 class="text-gray-600">
                        Unified dashboard
                      </h4>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="flex items-center">
                    <div>
                      <span
                        class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                        ><i class="bi bi-gear"></i
                      ></span>
                    </div>
                    <div>
                      <h4 class="text-gray-600">Robust Features</h4>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="flex items-center">
                    <div>
                      <span
                        class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                        ><i class="bi bi-credit-card"></i
                      ></span>
                    </div>
                    <div>
                      <h4 class="text-gray-600">Flexible Billing</h4>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Team -->
    <section class="pt-20 pb-48">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center text-center mb-24">
          <div class="w-full lg:w-6/12 px-4">
            <h2 class="text-4xl font-semibold">
              {{ $page.props.page_components.home_team_section.heading.value }}
            </h2>
            <p class="text-lg leading-relaxed m-4 text-gray-600">
              {{ $page.props.page_components.home_team_section.subtitle.value }}
            </p>
          </div>
        </div>
        <div class="flex flex-wrap">
          <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
            <div class="px-6">
              <img
                alt="..."
                src="/assets/img/team-1-800x800.jpg"
                class="shadow-lg rounded-full max-w-full mx-auto"
                style="max-width: 120px"
              />
              <div class="pt-6 text-center">
                <h5 class="text-xl font-bold">Ryan Tompson</h5>
                <p
                  class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                >
                  Web Developer
                </p>
                <div class="mt-6">
                  <button
                    class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-twitter"></i></button
                  ><button
                    class="bg-blue-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-facebook"></i></button
                  ><button
                    class="bg-pink-500 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-dribbble"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
            <div class="px-6">
              <img
                alt="..."
                src="/assets/img/team-2-800x800.jpg"
                class="shadow-lg rounded-full max-w-full mx-auto"
                style="max-width: 120px"
              />
              <div class="pt-6 text-center">
                <h5 class="text-xl font-bold">Romina Hadid</h5>
                <p
                  class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                >
                  Marketing Specialist
                </p>
                <div class="mt-6">
                  <button
                    class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-google"></i></button
                  ><button
                    class="bg-blue-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-facebook"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
            <div class="px-6">
              <img
                alt="..."
                src="/assets/img/team-3-800x800.jpg"
                class="shadow-lg rounded-full max-w-full mx-auto"
                style="max-width: 120px"
              />
              <div class="pt-6 text-center">
                <h5 class="text-xl font-bold">Alexa Smith</h5>
                <p
                  class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                >
                  UI/UX Designer
                </p>
                <div class="mt-6">
                  <button
                    class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-google"></i></button
                  ><button
                    class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-twitter"></i></button
                  ><button
                    class="bg-gray-800 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-instagram"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
            <div class="px-6">
              <img
                alt="..."
                src="/assets/img/team-4-470x470.png"
                class="shadow-lg rounded-full max-w-full mx-auto"
                style="max-width: 120px"
              />
              <div class="pt-6 text-center">
                <h5 class="text-xl font-bold">Jenna Kardi</h5>
                <p
                  class="mt-1 text-sm text-gray-500 uppercase font-semibold"
                >
                  Founder and CEO
                </p>
                <div class="mt-6">
                  <button
                    class="bg-pink-500 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-dribbble"></i></button
                  ><button
                    class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-google"></i></button
                  ><button
                    class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-twitter"></i></button
                  ><button
                    class="bg-gray-800 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                  >
                    <i class="bi bi-instagram"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- More Promo -->
    <section class="pb-20 relative block bg-gray-900">
      <div
        class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
        style="height: 80px"
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
            class="text-gray-900 fill-current"
            points="2560 0 2560 100 0 100"
          ></polygon>
        </svg>
      </div>
      <div class="container mx-auto px-4 lg:pt-24 lg:pb-64">
        <div class="flex flex-wrap text-center justify-center">
          <div class="w-full lg:w-6/12 px-4">
            <h2 class="text-4xl font-semibold text-white">
              Build something
            </h2>
            <p class="text-lg leading-relaxed mt-4 mb-4 text-gray-500">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium nihil recusandae voluptate vero, illum fugiat aliquid alias, aspernatur adipisci ipsa numquam doloribus ea suscipit exercitationem minus quae eius incidunt labore.
            </p>
          </div>
        </div>
        <div class="flex flex-wrap mt-12 justify-center">
          <div class="w-full lg:w-3/12 px-4 text-center">
            <div
              class="text-gray-900 p-3 w-12 h-12 shadow-lg rounded-full bg-white inline-flex items-center justify-center"
            >
              <i class="bi bi-stack text-xl"></i>
            </div>
            <h6 class="text-xl mt-5 font-semibold text-white">
              Unified Services
            </h6>
            <p class="mt-2 mb-4 text-gray-500">
              All the services you need under one dashboard.
            </p>
          </div>
          <div class="w-full lg:w-3/12 px-4 text-center">
            <div
              class="text-gray-900 p-3 w-12 h-12 shadow-lg rounded-full bg-white inline-flex items-center justify-center"
            >
              <i class="bi bi-bar-chart text-xl"></i>
            </div>
            <h5 class="text-xl mt-5 font-semibold text-white">
              Grow your market
            </h5>
            <p class="mt-2 mb-4 text-gray-500">
              Save time and refocus your energy on growing your business.
            </p>
          </div>
          <div class="w-full lg:w-3/12 px-4 text-center">
            <div
              class="text-gray-900 p-3 w-12 h-12 shadow-lg rounded-full bg-white inline-flex items-center justify-center"
            >
              <i class="bi bi-activity text-xl"></i>
            </div>
            <h5 class="text-xl mt-5 font-semibold text-white">
              Hustle Free Setup
            </h5>
            <p class="mt-2 mb-4 text-gray-500">
              Never lose sanity on managing your devices again.
            </p>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Contact -->
    <section class="relative block py-24 lg:pt-0 bg-gray-900">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center lg:-mt-64 -mt-48">
          <div class="w-full lg:w-6/12 px-4">
            <div
              class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300"
            >
              <div class="flex-auto p-5 lg:p-10">
                <h4 class="text-2xl font-semibold">
                  Want to work with us?
                </h4>
                <p class="leading-relaxed mt-1 mb-4 text-gray-600">
                  Complete this form and we will get back to you in 24
                  hours.
                </p>
                <div class="relative w-full mb-3 mt-8">
                  <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="full-name"
                    >Full Name</label
                  ><input
                    type="text"
                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                    placeholder="Full Name"
                    style="transition: all 0.15s ease 0s"
                  />
                </div>
                <div class="relative w-full mb-3">
                  <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="email"
                    >Email</label
                  ><input
                    type="email"
                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                    placeholder="Email"
                    style="transition: all 0.15s ease 0s"
                  />
                </div>
                <div class="relative w-full mb-3">
                  <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="message"
                    >Message</label
                  ><textarea
                    rows="4"
                    cols="80"
                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                    placeholder="Type a message..."
                  ></textarea>
                </div>
                <div class="text-center mt-6">
                  <button
                    class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                    type="button"
                    style="transition: all 0.15s ease 0s"
                  >
                    Send Message
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
