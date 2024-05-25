<script setup>
  import { ref, onMounted } from "vue";
  import { Link, usePage } from "@inertiajs/vue3";

  import Glide from '@glidejs/glide';

  var glide = new Glide('.apps__promo__slider', {
    type: 'slider',
    perView: 1,
    bound: true
  });

  const apps = [1, 2]/*usePage().props.apps*/;

  onMounted(() => {
    glide.mount();
  });  
</script>

<template>
  <div class="glide apps__promo__slider">
    <div data-glide-el="track" class="glide__track">
      <ul class="glide__slides">
        <li
          v-for="(app, index) in apps"
          :key="index"
          class="glide__slide"
        >
          <div
            class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded-lg bg-pink-600"
          >
            <!-- todo: revisit later -->
            <!-- <img
              alt="..."
              src=""
              class="w-full align-middle rounded-t-lg"
            /> -->
            <blockquote class="relative p-8 mb-4">
              <svg
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 583 95"
                class="absolute left-0 w-full block"
                style="height: 95px; top: -94px"
              >
                <polygon
                  points="-30,95 583,95 583,65"
                  class="text-pink-600 fill-current"
                ></polygon>
              </svg>

              <h4 class="inline-flex items-center gap-2 text-xl font-bold text-white">
                <i class="bi" :class="`bi-${app}-circle`"></i> App {{ app }}
              </h4>

              <p class="text-md font-light mt-2 text-white">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cumque voluptates minima placeat nihil, amet vitae numquam, dolorum facere odit laborum earum exercitationem dignissimos. Atque odio, explicabo consectetur. Provident, corrupti minus.
              </p>
            </blockquote>
          </div>
        </li>
        <!-- /.glide__slide -->
      </ul>
      <!-- /.glide__slides -->
    </div>
    <!-- /.glide__track -->

    <div class="glide__arrows relative flex items-center md:justify-end" data-glide-el="controls">
      <button class="glide__arrow glide__arrow--left !bg-pink-600" data-glide-dir="<">prev</button>
      <button class="glide__arrow glide__arrow--right !bg-pink-600" data-glide-dir=">">next</button>
    </div>
    <!-- /.glide__arrows -->

    <div class="glide__bullets" data-glide-el="controls[nav]">
      <button
        v-for="(app, index) in apps"
        class="glide__bullet !w-[16px] !h-[16px]"
        :key="index"
        :data-glide-dir="`=${index}`"
      ></button>
    </div>
    <!-- /.glide__arrows -->
  </div>
</template>