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
  <!-- editor text formats -->
  <div v-if="editor" class="flex items-center gap-2 px-2 py-1">
    <!-- bold -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().toggleBold().run()"
      :class="{ 'bg-slate-300': editor.isActive('bold') }"
      @click="editor.chain().focus().toggleBold().run()"
    >
      <i class="bi bi-type-bold text-xl leading-none"></i>
    </AppLightButton>

    <!-- italic -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().toggleItalic().run()"
      :class="{ 'bg-slate-300': editor.isActive('italic') }"
      @click="editor.chain().focus().toggleItalic().run()"
    >
      <i class="bi bi-type-italic text-xl leading-none"></i>
    </AppLightButton>

    <!-- strike -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().toggleStrike().run()"
      :class="{ 'bg-slate-300': editor.isActive('strike') }"
      @click="editor.chain().focus().toggleStrike().run()"
    >
      <i class="bi bi-type-strikethrough text-xl leading-none"></i>
    </AppLightButton>

    <!-- underline -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().toggleStrike().run()"
      :class="{ 'bg-slate-300': editor.isActive('underline') }"
      @click="editor.chain().focus().toggleUnderline().run()"
    >
      <i class="bi bi-type-underline text-xl leading-none"></i>
    </AppLightButton>
  </div>
  <!-- /editor text formats -->
</template>
