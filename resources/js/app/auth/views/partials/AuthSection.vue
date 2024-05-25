<script setup>
  import { Carousel, Slide, Pagination } from 'vue3-carousel';
  import { ScrollArea } from '@/components/ui/scroll-area';
  import 'vue3-carousel/dist/carousel.css';
  import { computed } from 'vue';

  const today = computed(() => {
    const date = new Date();
    return date.toLocaleDateString('en-US', {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    });
  });

  const date = new Date().getFullYear();

  const slides = [
    {
      text: 'Restore has proven to be an invaluable tool, empowering us to respond swiftly to emergencies, enhance efficiency, and elevate our service quality.',
      author: 'Jonathon W.',
      title: 'Element Restoration, NM',
    },
    {
      text: 'Restore simplified our job workflow, making it quicker and more efficient.',
      author: 'Isaac S.',
      title: 'PNW Carpet & Restoration- OR',
    },
    {
      text: 'Thanks to Monitor, we can monitor all our facilities from one place, saving us time and resources on routine maintenance.',
      author: 'Samuel P.',
      title: 'OC Lighting & Design- CA',
    },
  ];
</script>

<template>
  <div class="lg:h-screen flex flex-col bg-white lg:overflow-hidden">
    <div class="w-full h-full">
      <div class="grid grid-cols-1 lg:grid-cols-2 h-full">
        <div class="flex justify-center h-screen lg:h-full">
          <div class="py-10 lg:py-20 lg:w-1/2 px-5 lg:px-0 flex flex-col justify-between h-full">
            <ScrollArea class="h-screen px-4 lg:pb-24">
              <slot />

              <div class="pt-12">
                <p class="text-sm text-black font-medium mb-3 text-center lg:text-start">
                  Copyright © {{ date }} {{ $page.props.appName }}. All Rights Reserved.
                </p>
              </div>
            </ScrollArea>
          </div>
        </div>

        <div class="hidden lg:block h-screen">
          <div class="h-[95%] m-6">
            <div class="h-full w-full relative">
              <div class="absolute top-0 left-0 h-full w-full carousel-gradient rounded-lg z-20"></div>
              <p class="text-2xl text-white font-bold mb-8 text-start absolute top-16 left-12 z-50">{{ today }}</p>
              <Carousel>
                <Slide
                  v-for="(slide, key) in slides"
                  :key="slide"
                  :items-to-show="1"
                >
                  <div
                    class="carousel__item h-full w-full relative rounded-lg bg-cover bg-no-repeat bg-center"
                    :style="`background-image: url('/images/auth/login-banner-${key + 1}.jpeg')`"
                  >
                    <div
                      class="h-full w-full lg:flex flex-col bg-gradient-to-t from-gray-600 to-transparent rounded-lg"
                    >
                      <div class="flex flex-col justify-start mt-auto pb-40 px-16">
                        <p class="text-2xl text-white font-bold mb-8 text-start">{{ slide.text }}</p>
                        <div>
                          <p class="text-2xl text-white font-light mb-3 text-start">{{ slide.author }}</p>
                          <p class="text-base text-white font-medium mb-0 text-start">{{ slide.title }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </Slide>
                <template #addons>
                  <Pagination />
                </template>
              </Carousel>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
  .carousel {
    width: 100%;
    height: 100%;
    position: relative;

    &__viewport {
      margin: unset !important;
      height: 100%;
      width: 100%;
    }

    &__track {
      height: 100% !important;
    }
  }

  .carousel-gradient {
    background: rgba(0, 0, 0, 0.15);
  }

  .carousel__pagination {
    position: absolute;
    bottom: 80px;
    left: 50%;
    z-index: 60;
  }

  .carousel__prev,
  .carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
  }

  .carousel__pagination-item {
    .carousel__pagination-button {
      width: 30px;
      height: 3px;

      &::after {
        width: 100%;
        background: #707070 !important;
      }

      &.carousel__pagination-button--active {
        &::after {
          background: white !important;
          width: 100%;
        }
      }
    }
  }
</style>
