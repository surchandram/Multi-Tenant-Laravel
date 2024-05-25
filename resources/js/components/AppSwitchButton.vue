<script setup>
  import { ref, defineProps, defineEmits } from 'vue';

  const props = defineProps({
    label: String,
    value: Boolean,
    end: {
      type: Boolean,
      default: false,
    },
  });

  const internalValue = ref(props.value);

  const emit = defineEmits(['update:modelValue']);

  const toggleSwitch = () => {
    internalValue.value = !internalValue.value;
    emit('update:modelValue', internalValue.value);
  };
</script>

<template>
  <div>
    <input
      type="checkbox"
      v-model="internalValue"
      class="hidden"
    />
    <label
      class="w-12 h-6 flex items-center rounded-full p-1 cursor-pointer font-medium"
      :class="{ 'bg-blue-600': internalValue, 'bg-gray-200': !internalValue, 'order-last': end }"
      @click="toggleSwitch"
    >
      <span
        :class="{ 'translate-x-6': internalValue, 'translate-x-0': !internalValue }"
        class="inline-block w-5 h-5 bg-white rounded-full shadow-md transform transition-transform"
      ></span>
    </label>
    <span
      :class="[end ? '' : 'ml-2']"
      class="font-medium"
      >{{ label }}</span
    >
  </div>
</template>
