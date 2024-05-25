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
  <!-- editor quote styles -->
  <div v-if="editor" class="flex items-center gap-2 px-2 py-1">
    <!-- code block -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('codeBlock') }"
      @click="editor.chain().focus().toggleCodeBlock().run()"
    >
      <i class="bi bi-code-slash text-xl leading-none"></i>
    </AppLightButton>

    <!-- blockquote -->
    <AppLightButton
      type="button"
      class="text-xs"
    :class="{ 'bg-slate-300': editor.isActive('blockquote') }"
      @click="editor.chain().focus().toggleBlockquote().run()"
    >
      <i class="bi bi-quote text-xl leading-none"></i>
    </AppLightButton>
  </div>
  <!-- /editor quote styles -->
</template>
