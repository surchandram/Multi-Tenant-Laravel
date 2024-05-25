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
  <!-- editor paragraph styles -->
  <div v-if="editor" class="flex items-center gap-2 px-2 py-1">
    <!-- paragraph -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('paragraph') }"
      @click="editor.chain().focus().setParagraph().run()"
    >
      <i class="bi bi-paragraph text-xl leading-none"></i>
    </AppLightButton>

    <!-- h1 -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('heading', { level: 1 }) }"
      @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
    >
      <i class="bi bi-type-h1 text-xl leading-none"></i>
    </AppLightButton>

    <!-- h2 -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('heading', { level: 2 }) }"
      @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
    >
      <i class="bi bi-type-h2 text-xl leading-none"></i>
    </AppLightButton>

    <!-- h3 -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('heading', { level: 3 }) }"
      @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
    >
      <i class="bi bi-type-h3 text-xl leading-none"></i>
    </AppLightButton>

    <!-- todo: wrap in dropdown -->
    <!-- h4 -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('heading', { level: 4 }) }"
      @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
    >
      <i class="text-base leading-none font-medium not-italic">h4</i>
    </AppLightButton>

    <!-- h5 -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('heading', { level: 5 }) }"
      @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
    >
      <i class="text-base leading-none font-medium not-italic">h5</i>
    </AppLightButton>

    <!-- h6 -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('heading', { level: 6 }) }"
      @click="editor.chain().focus().toggleHeading({ level: 6 }).run()"
    >
      <i class="text-base leading-none font-medium not-italic">h6</i>
    </AppLightButton>
  </div>
  <!-- /editor paragraph styles -->
</template>
