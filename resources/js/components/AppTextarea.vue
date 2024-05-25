<script setup>
  import { ref, watch, onMounted } from 'vue';

  const props = defineProps({
    modelValue: {
      type: String,
      default: ''
    },
  });

  const emit = defineEmits([
    'update:modelValue'
  ])

  const inputVal = ref('');

  onMounted(() => {
    inputVal.value = props.modelValue;

    watch(() => props.modelValue, (value) => {
      if (inputVal.value === value) {
        return;
      }

      inputVal.value = props.modelValue
    });

    watch(() => inputVal.value, (value) => {
      emit('update:modelValue', value);
    });
  });

</script>

<template>
  <textarea
    v-model="inputVal"
    class="
      w-full
      border
      border-solid
      border-gray-300
      rounded
    text-gray-700
    bg-white
      bg-clip-padding
      transition
      ease-in-out
      focus:text-gray-700
      focus:bg-white
      focus:border-blue-600
      focus:outline-none
      focus:ring-blue-600
    "
  />
</template>
