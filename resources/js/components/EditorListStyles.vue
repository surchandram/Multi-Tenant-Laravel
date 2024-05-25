<script setup>
  import AppLightButton from '@/components/AppLightButton.vue';

  defineProps({
    editor: {
      type: Object,
      required: true,
    }
  });
</script>

<template>
  <!-- editor list styles -->
  <div v-if="editor" class="flex items-center gap-2 px-2 py-1">
    <!-- bullet list -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('bulletList') }"
      @click="editor.chain().focus().toggleBulletList().run()"
    >
      <i class="bi bi-list-ul text-xl leading-none"></i>
    </AppLightButton>

    <!-- ordered list -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('orderedList') }"
      @click="editor.chain().focus().toggleOrderedList().run()"
    >
      <i class="bi bi-list-ol text-xl leading-none"></i>
    </AppLightButton>
  </div>
  <!-- /editor list styles -->
</template>
