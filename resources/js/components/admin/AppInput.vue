<script setup>
  import { ref, watch } from 'vue';
  
  const props = defineProps({
    modelValue: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
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
  })

  watch(() => inputVal.value, (value) => {
    emit('update:modelValue', value);
  })
</script>

<template>
  <input
    v-model="inputVal"
    type="type"
    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
  />
</template>
