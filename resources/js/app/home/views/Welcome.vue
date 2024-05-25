<script setup>
  import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Multi-tenant SaaS Boilerplate" />

  <!-- Hero -->
  <section class="mb-40 background-radial-gradient overflow-hidden">
    <div class="px-6 py-12 lg:py-24 md:px-12 text-center lg:text-left">
      <div class="container mx-auto xl:px-32 text-gray-800">
        <div class="grid lg:grid-cols-2 gap-12 flex items-center">
          <div class="mt-12 lg:mt-0" style="z-index: 10;">
            <h1 class="text-5xl md:text-6xl xl:text-7xl font-bold tracking-tight mb-12" style="color: hsl(218, 81%, 95%);">
              The best starter kit <br /><span style="color: hsl(218, 81%, 75%);">for your SaaS business</span>
            </h1>
            <p class="mb-12 opacity-70" style="color: hsl(218, 81%, 85%)">
              {{ $page.props.appName }} is a feature packed starter kit for building Multi-tenant SaaS applications <br>
              that require separation of client data and functionality into multiple database and storage <br> while sharing
              the same source code.
            </p>
          </div>
          <div class="lg:mb-0 relative">
            <div id="radius-shape-1" class="absolute rounded-full shadow-lg"></div>
            <div id="radius-shape-2" class="absolute shadow-lg"></div>
            <div class="block rounded-lg px-6 py-12 md:px-12 sticky z-30">
              <!-- Login Demo CTA -->
              <Link
                class="inline-block px-7 py-3 mr-2 bg-gray-200 text-gray-700 font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-yellow-300 hover:shadow-lg focus:bg-yellow-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                :href="route('login')"
                role="button"
              >
                Demo
              </Link>

              <!-- Docs button -->
              <a
target="_blank"
                class="inline-flex items-center gap-1 px-7 py-3 bg-transparent text-white font-medium text-sm leading-snug uppercase border border-teal-300 rounded hover:bg-teal-700 focus:bg-teal-700 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                :href="route('docs.index')"
                role="button"
              >
                Learn more
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                  <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Promo -->
  <section class="mb-32 text-gray-800 text-center">
    <div class="px-6 py-12 lg:py-24 md:px-12">
      <h2 class="text-3xl font-bold mb-12">Why is it so<u class="text-blue-600"> great?</u></h2>
      <div class="grid md:grid-cols-3 lg:gap-x-12">
        <div class="mb-12 md:mb-0">
          <div class="p-4 bg-blue-600 rounded-lg shadow-lg inline-block mb-6">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path
fill="currentColor"
                d="M192 208c0-17.67-14.33-32-32-32h-16c-35.35 0-64 28.65-64 64v48c0 35.35 28.65 64 64 64h16c17.67 0 32-14.33 32-32V208zm176 144c35.35 0 64-28.65 64-64v-48c0-35.35-28.65-64-64-64h-16c-17.67 0-32 14.33-32 32v112c0 17.67 14.33 32 32 32h16zM256 0C113.18 0 4.58 118.83 0 256v16c0 8.84 7.16 16 16 16h16c8.84 0 16-7.16 16-16v-16c0-114.69 93.31-208 208-208s208 93.31 208 208h-.12c.08 2.43.12 165.72.12 165.72 0 23.35-18.93 42.28-42.28 42.28H320c0-26.51-21.49-48-48-48h-32c-26.51 0-48 21.49-48 48s21.49 48 48 48h181.72c49.86 0 90.28-40.42 90.28-90.28V256C507.42 118.83 398.82 0 256 0z">
              </path>
            </svg>
          </div>
          <h5 class="text-lg font-bold mb-4">Team Focused</h5>
          <p class="text-gray-500">
            Laudantium totam quas cumque pariatur at doloremque hic quos quia eius. Reiciendis
            optio minus mollitia rerum labore facilis inventore voluptatem ad, quae quia sint.
            Ullam.
          </p>
        </div>
      
        <div class="mb-12 md:mb-0">
          <div class="p-4 bg-blue-600 rounded-lg shadow-lg inline-block mb-6">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path
fill="currentColor"
                d="M466.5 83.7l-192-80a48.15 48.15 0 0 0-36.9 0l-192 80C27.7 91.1 16 108.6 16 128c0 198.5 114.5 335.7 221.5 380.3 11.8 4.9 25.1 4.9 36.9 0C360.1 472.6 496 349.3 496 128c0-19.4-11.7-36.9-29.5-44.3zM256.1 446.3l-.1-381 175.9 73.3c-3.3 151.4-82.1 261.1-175.8 307.7z">
              </path>
            </svg>
          </div>
          <h5 class="text-lg font-bold mb-4">Multi-database Tenancy Support</h5>
          <p class="text-gray-500">
            Eum nostrum fugit numquam, voluptates veniam neque quibusdam ullam aspernatur odio
            soluta, quisquam dolore animi mollitia a omnis praesentium, expedita nobis!
          </p>
        </div>
      
        <div class="mb-12 md:mb-0">
          <div class="p-4 bg-blue-600 rounded-lg shadow-lg inline-block mb-6">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
              <path
fill="currentColor"
                d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z">
              </path>
            </svg>
          </div>
          <h5 class="text-lg font-bold mb-4">On the Fly Migration and Seeding</h5>
          <p class="text-gray-500">
            Enim cupiditate, minus nulla dolor cumque iure eveniet facere ullam beatae hic
            voluptatibus dolores exercitationem? Facilis debitis aspernatur amet nisi?
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Description With Feature List Icons -->
  <section class="mb-32 text-gray-800">
    <div class="flex flex-wrap items-center px-6 py-12 lg:py-24 md:px-12">
      <div class="grow-0 shrink-0 basis-auto w-full lg:w-4/12 mb-6 md:mb-0 px-3">
        <h2 class="text-3xl font-bold mb-6">
          What's<u class="text-blue-600"> included?</u>
        </h2>

        <p class="text-gray-500 mb-12">
          On top of team focused functionality, we've also built the most necessary SaaS features
        </p>
      </div>

      <div class="grow-0 shrink-0 basis-auto w-full lg:w-8/12 mb-6 mb-md-0 px-3">
        <div class="flex flex-wrap">
          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Support 24/7</p>
                <p class="text-gray-500">
                  Pellentesque mollis, metus nec fringilla aliquam. Donec consequat orci quis
                  volutpat imperdiet.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Tracking</p>
                <p class="text-gray-500">
                  Magna lacus iaculis elit, quis pharetra varius. Aenean lectus ex, placerat id
                  tellus in eros.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Reporting</p>
                <p class="text-gray-500">
                  Pellentesque varius ex vel consequat quis. Sed mauris ex, imperdiet sit amet
                  nisl ac, ultrices.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Analytics</p>
                <p class="text-gray-500">
                  Vestibulum gravida iaculis nisl, vel lobortis eros. Praesent vulputate lacus
                  bibendum augue.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Huge community</p>
                <p class="text-gray-500">
                  Praesent vulputate lacus bibendum augue. Pellentesque mollis, metus nec
                  fringilla aliquam.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Easy to use</p>
                <p class="text-gray-500">
                  Sed mauris ex, imperdiet sit amet nisl ac, ultrices. Magna lacus iaculis elit,
                  quis pharetra varius.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Frequent updates</p>
                <p class="text-gray-500">
                  Aenean lectus ex, placerat id tellus in eros. Pellentesque varius ex vel
                  consequat quis. Sed mauris ex
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
            <div class="flex">
              <div class="shrink-0 mt-1">
                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path
fill="currentColor"
                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                  </path>
                </svg>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Responsive</p>
                <p class="text-gray-500">
                  Donec consequat orci quis volutpat imperdiet. Vestibulum gravida iaculis nisl,
                  vel lobortis eros.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Three Column FAQ List -->
  <section class="mb-32 text-gray-800">
    <div class="flex flex-wrap items-center px-6 py-12 lg:py-24 md:px-12">
      <div class="grow-0 shrink-0 basis-auto w-full lg:w-4/12 mb-6 md:mb-0 px-3">
        <p class="uppercase text-blue-600 font-bold mb-6">FAQs</p>
        <h2 class="text-3xl font-bold mb-6">
          Why is it so<u class="text-blue-600"> great?</u>
        </h2>

        <p class="text-gray-500 mb-12">
          Nunc tincidunt vulputate elit. Mauris varius purus malesuada neque iaculis malesuada.
          Aenean gravida magna orci, non efficitur est porta id. Donec magna diam.
        </p>
      </div>

      <div class="grow-0 shrink-0 basis-auto w-full lg:w-8/12 mb-6 mb-md-0 px-3">
        <div class="flex flex-wrap">
          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12 px-3">
            <div class="flex">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-lg">
                  <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
fill="currentColor"
                      d="M192 208c0-17.67-14.33-32-32-32h-16c-35.35 0-64 28.65-64 64v48c0 35.35 28.65 64 64 64h16c17.67 0 32-14.33 32-32V208zm176 144c35.35 0 64-28.65 64-64v-48c0-35.35-28.65-64-64-64h-16c-17.67 0-32 14.33-32 32v112c0 17.67 14.33 32 32 32h16zM256 0C113.18 0 4.58 118.83 0 256v16c0 8.84 7.16 16 16 16h16c8.84 0 16-7.16 16-16v-16c0-114.69 93.31-208 208-208s208 93.31 208 208h-.12c.08 2.43.12 165.72.12 165.72 0 23.35-18.93 42.28-42.28 42.28H320c0-26.51-21.49-48-48-48h-32c-26.51 0-48 21.49-48 48s21.49 48 48 48h181.72c49.86 0 90.28-40.42 90.28-90.28V256C507.42 118.83 398.82 0 256 0z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Support 24/7</p>
                <p class="text-gray-500">
                  Pellentesque mollis, metus nec fringilla aliquam. Donec consequat orci quis
                  volutpat imperdiet.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12 px-3">
            <div class="flex">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-lg">
                  <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
fill="currentColor"
                      d="M466.5 83.7l-192-80a48.15 48.15 0 0 0-36.9 0l-192 80C27.7 91.1 16 108.6 16 128c0 198.5 114.5 335.7 221.5 380.3 11.8 4.9 25.1 4.9 36.9 0C360.1 472.6 496 349.3 496 128c0-19.4-11.7-36.9-29.5-44.3zM256.1 446.3l-.1-381 175.9 73.3c-3.3 151.4-82.1 261.1-175.8 307.7z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Safe and solid</p>
                <p class="text-gray-500">
                  Magna lacus iaculis elit, quis pharetra varius. Aenean lectus ex, placerat id
                  tellus in eros.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12 px-3">
            <div class="flex">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-lg">
                  <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path
fill="currentColor"
                      d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Extremely fast</p>
                <p class="text-gray-500">
                  Pellentesque varius ex vel consequat quis. Sed mauris ex, imperdiet sit amet
                  nisl ac, ultrices.
                </p>
              </div>
            </div>
          </div>

          <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12 px-3">
            <div class="flex">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-lg">
                  <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path
fill="currentColor"
                      d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-4">
                <p class="font-bold mb-1">Money back guarantee</p>
                <p class="text-gray-500">
                  Vestibulum gravida iaculis nisl, vel lobortis eros. Praesent vulputate lacus
                  bibendum augue.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style>
.background-radial-gradient {
  background-color: hsl(218, 41%, 15%);
  background-image: radial-gradient(
    650px circle at 0% 0%,
    hsl(218, 41%, 35%) 15%,
    hsl(218, 41%, 30%) 35%,
    hsl(218, 41%, 20%) 75%,
    hsl(218, 41%, 19%) 80%,
    transparent 100%
  ),
  radial-gradient(
    1250px circle at 100% 100%,
    hsl(218, 41%, 45%) 15%,
    hsl(218, 41%, 30%) 35%,
    hsl(218, 41%, 20%) 75%,
    hsl(218, 41%, 19%) 80%,
    transparent 100%
  );
}

#radius-shape-1 {
  height: 220px;
  width: 220px;
  top: -60px;
  left: -130px;
  background: radial-gradient(#44006b, #ad1fff);
  overflow: hidden;
}

#radius-shape-2 {
  border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
  bottom: -60px;
  right: -110px;
  width: 300px;
  height: 300px;
  background: radial-gradient(#44006b, #ad1fff);
  overflow: hidden;
}

.bg-glass {
  background-color: hsla(0, 0%, 100%, 0.9);
  backdrop-filter: saturate(200%) blur(25px);
}

@media (min-width: 992px) {
  .rotate-lg-6 {
    transform: rotate(6deg);
  }
}
</style>
