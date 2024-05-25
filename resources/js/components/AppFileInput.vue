<script setup>
  import { ref, watch } from 'vue';
  
  const props = defineProps({
    modelValue: {
      type: [String, Number, Boolean, Object],
      default: ''
    },
    type: {
      type: String,
      default: 'file'
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

  const changed = (file) => {
    inputVal.value = file;
  };
</script>

<template>
  <input
    :type="props.type"
    class="cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter dark:file:bg-white/30 dark:file:text-white file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:focus:border-primary"
    @change="changed($event.target.files[0])"
  />
</template>
