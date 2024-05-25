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
  <!-- editor spacing styles -->
  <div v-if="editor" class="flex items-center gap-2 px-2 py-1">
    <!-- horizontal rule -->
    <AppLightButton
      type="button"
      class="text-xs"
      @click="editor.chain().focus().setHorizontalRule().run()"
    >
      <i class="bi bi-dash-square-dotted text-xl leading-none"></i>
    </AppLightButton>

    <!-- hard break -->
    <AppLightButton
      type="button"
      class="text-xs"
      @click="editor.chain().focus().setHardBreak().run()"
    >
      <span class="bi text-xl leading-none lowercase">br</span>
    </AppLightButton>
  </div>
  <!-- /editor spacing styles -->
</template>
