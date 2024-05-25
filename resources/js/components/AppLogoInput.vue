<script setup>
  import { watch, computed, onMounted, ref } from "vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import AppFileInput from "@/components/AppFileInput.vue";
  import AppInputError from "@/components/AppInputError.vue";

  const props = defineProps({
    modelValue: {
      type: Object,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    error: {
      type: String,
      default: "",
    },
    currentLogo: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "logo",
    },
  });

  const emit = defineEmits(["update:modelValue"]);

  const logo = ref(null);
  const id = ref(null);

  const logoPreview = computed(() => {
    if (!logo.value) {
      return;
    }
    return URL.createObjectURL(logo.value);
  });

  const resetLogo = () => {
    logo.value = null;
  };

  const generateRandomString = (length = 6) =>
    Math.random().toString(20).substr(2, length);

  onMounted(() => {
    watch(logo, (value) => {
      emit("update:modelValue", value);
    });

    id.value = generateRandomString(12);
  });
</script>

<template>
  <div class="flex flex-col md:flex-row md:items-center gap-4">
    <div>
      <img v-if="logoPreview" :src="logoPreview" alt class="max-w-[250px] max-h-[250px]" />

      <img v-else :src="currentLogo ? currentLogo : `https://placehold.co/250x250?text=${placeholder}`" alt class="w-40 h-40" />
    </div>

    <div class="form-group space-y-2">
      <AppLightButton v-if="logoPreview" @click="resetLogo">{{ __('app.labels.clear') }}</AppLightButton>

      <label
        v-else
        :for="`logo${id}`"
        class="block px-2 py-2 text-sm font-semibold cursor-pointer text-blue-500 hover:text-indigo-500 focus:ring"
      >{{ label || __('app.labels.add_logo') }}</label>

      <div class="sr-only">
        <AppFileInput
          :id="`logo${id}`"
          type="file"
          class="w-full"
          accept=".png, .jpg, .jpeg"
          @change="($event) => logo = $event.target.files[0]"
        />
      </div>

      <AppInputError v-if="error" :message="error" />
    </div>
  </div>
</template>
