<script setup>
  import { ref, watch } from 'vue';
  
  const props = defineProps({
    modelValue: {
      default: ''
    },
  });

  const emit = defineEmits([
    'update:modelValue'
  ])

  const inputVal = ref('');

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
</script>

<template>
  <input
    v-model="inputVal"
    type="checkbox"
    class="text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none focus:ring-blue-600"
  />
</template>
