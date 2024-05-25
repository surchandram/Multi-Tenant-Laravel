<script setup>
  import AppButton from "@/components/AppButton.vue";
  import AppInputGroup from "@/components/AppInputGroup.vue";
</script>

<template>
  <form
    class="
      hidden
      md:flex
      flex-row
      flex-wrap
      items-center
      lg:ml-auto
      mr-3
    "
  >
    <AppInputGroup
      class="shadow rounded-l rounded-r"
      custom
    >
      <template #end>
        <AppButton>
          <i class="bi bi-search"></i >
        </AppButton>
      </template>

      <template #default="{ inputStyles }">
        <input
          type="text"
          placeholder="Search here..."
          :class="inputStyles"
          class="
            w-full
            px-3
            pl-10
            border-0
            rounded
            text-blueGray-600
            placeholder-blueGray-300
            bg-white
            text-sm
            outline-none
            focus:outline-none
            focus:ring
          "
        />
      </template>
    </AppInputGroup>
  </form>
</template>
