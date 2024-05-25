<script>
export default {
  uId: Date.now() + 'dropdownMegaMenuButton',
};
</script>

<script setup>
  // import MegaMenuLink from './MegaMenuLink.vue';
  // import MegaMenuMediaLink from './MegaMenuMediaLink.vue';
  // import MegaMenuBigNewsLink from './MegaMenuBigNewsLink.vue';

  const props = defineProps({
    id: {
      type: String,
      default: Date.now() + 'dropdownMegaMenuButton'
    },
    label: {
      type: String,
      default: 'Mega Menu'
    }
  });
</script>

<template>
  <li class="nav-item dropdown static">
    <!-- trigger -->
    <a
      :id="props.id"
      class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out dropdown-toggle flex items-center whitespace-nowrap"
      href="#"
      data-mdb-ripple="true"
      data-mdb-ripple-color="light"
      type="button"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      <slot name="trigger">{{ props.label }}</slot>
      <svg  aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
        <path fill="currentColor" d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path>
      </svg>
    </a>

    <!-- dropdown menu -->
    <div
      class="dropdown-menu w-full mt-0 hidden shadow-lg bg-white absolute left-0 top-full"
      :aria-labelledby="props.id"
    >
      <div class="px-6 lg:px-8 py-5">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          <slot name="content">
            <!-- list with header -->
            <!-- <div class="bg-white text-gray-600"> -->
              <!-- <MegaMenuHeader label="" /> -->
              <!-- <MegaMenuLink /> -->
            <!-- </div> -->

            <!-- media list -->
            <!-- <div class="bg-white text-gray-600"> -->
              <!-- <MegaMenuHeader label="" /> -->
              <!-- <MegaMenuMediaLink /> -->
            <!-- </div> -->

            <!-- big news, image, short description -->
            <!-- <div class="bg-white"> -->
              <!-- <MegaMenuHeader label="" news /> -->
              <!-- <MegaMenuBigNewsLink /> -->
            <!-- </div> -->
          </slot>
        </div>
      </div>
    </div>
  </li>
</template> 
