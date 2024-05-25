<script setup>
  import EditorTextFormats from './EditorTextFormats.vue';
  import EditorNodeActions from './EditorNodeActions.vue';
  import EditorParagraphStyles from './EditorParagraphStyles.vue';
  import EditorListStyles from './EditorListStyles.vue';
  import EditorQuoteStyles from './EditorQuoteStyles.vue';
  import EditorSpacingStyles from './EditorSpacingStyles.vue';
  import EditorEditActions from './EditorEditActions.vue';

  defineProps({
    editor: {
      type: Object,
      required: true,
    }
  });
</script>

<template>
  <div
    class="
      w-full
      flex
      items-center
      md:flex-wrap
      gap-2
      gap-y-1
      mb-5
      bg-slate-50
      text-slate-600
      sticky
      top-0
      z-50
      overflow-x-auto
      overflow-y-hidden
    "
  >
    <EditorTextFormats :editor="editor" />

    <EditorNodeActions :editor="editor" />

    <EditorParagraphStyles :editor="editor" />

    <EditorListStyles :editor="editor" />

    <EditorQuoteStyles :editor="editor" />

    <EditorSpacingStyles :editor="editor" />

    <EditorEditActions :editor="editor" />
  </div>
</template>
