<script setup>
  import { onMounted, onUnmounted, ref, toRefs, computed } from 'vue';

  const props = defineProps({
    slot: {
      type: String,
      required: true
    },
    replace: {
      type: Boolean,
      required: false
    }
  });

  const { slot, replace } = toRefs(props);

  const mounted = ref(false);

  const updateReplaceableElements = (hide = false) => {
    [].forEach.call(
      document.querySelector(to.value)?.querySelectorAll('[data-replace]'),
      (el) => {
        if (hide) {
          el.style.display = 'none';
        }
        else {
          el.style.display = 'block';
        }
      }
    );
  };

  onMounted(() => {
    updateReplaceableElements(props.replace);

    mounted.value = true;
  });

  onUnmounted(() => {
    updateReplaceableElements();

    mounted.value = true;
  });

  const to = computed(() => {
    return `[data-slot="${slot.value}"]`;
  });
</script>

<template>
  <Teleport :to="to" v-if="mounted">
    <slot :replace="replace" />
  </Teleport>
</template>
