<script setup>
  const props = defineProps({
    address: {
      type: Object,
      default: (() => {})
    },
    without: {
      type: Array,
      default: (() => [])
    }
  });

  const isVisible = ((key) => !_.includes(props.without, key));
</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
  >

    <h4
      v-if="isVisible('name')"
      class="text-title-md font-bold text-black dark:text-white"
    >
      {{ address.name }}
    </h4>

    <!-- Line 1 -->
    <p class="text-sm font-medium mt-3">
      {{ address.address_1 }}, {{ address.city }}
    </p>

    <!-- Code/State -->
    <p class="text-sm font-medium mt-3">
      {{ address.state }}, {{ address.postal_code }}
    </p>

    <!-- Country -->
    <p class="text-sm font-medium mt-3">
      {{ address?.country?.name }}
    </p>

    <slot
      name="bottom"
      :address="address"
      :without="without"
      :is-visible="isVisible"
    ></slot>
  </div>
</template>
