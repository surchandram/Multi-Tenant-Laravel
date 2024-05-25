<script setup>
  import { ref, onMounted } from "vue";
  import { router, usePage } from "@inertiajs/vue3";

  defineProps({
    custom: {
      type: String,
      default: "",
    },
  });

  const flashStyles = {
    status: "text-green-600 bg-green-200",
    success: "text-teal-600 bg-teal-200",
    error: "text-red-600 bg-red-200",
    info: "text-blue-600 bg-blue-200",
    warning: "text-yellow-600 bg-yellow-200",
  };

  const messages = ref(usePage().props.flash);

  const clearMessage = (index) => {
    messages.value[index] = null;
  };

  onMounted(() => {
    router.on("start", () => {
      messages.value = {};
    });

    router.on("finish", () => {
      messages.value = usePage().props.flash;
    });
  });
</script>

<template>
  <div class="w-full flex flex-col">
    <div
      v-for="(message, index) in messages"
      v-show="message"
      :key="index"
      class="inline-flex items-center px-4 py-2 font-medium text-sm relative"
      :class="[
        custom ? custom : 'w-11/12 md:my-5 my-2 mx-auto rounded',
        flashStyles[index] || 'text-slate-600 bg-slate-200'
      ]"
    >
      <div class="flex-1">{{ message }}</div>

      <a
        href="#"
        class="block px-2 py-1 text-slate-700 focus:ring"
        @click.prevent="clearMessage(index)"
      >&times;</a>
    </div>
  </div>
</template>
