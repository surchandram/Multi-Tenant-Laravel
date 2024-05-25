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
  <!-- editor node actions -->
  <div v-if="editor" class="flex items-center gap-2 px-2 py-1">
    <!-- undo -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().undo().run()"
      @click="editor.chain().focus().undo().run()"
    >
      <div class="rotate-180"><i class="bi bi-arrow-return-right text-xl leading-none"></i></div>
    </AppLightButton>

    <!-- redo -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().redo().run()"
      @click="editor.chain().focus().redo().run()"
    >
      <div class="rotate-180"><i class="bi bi-arrow-return-left text-xl leading-none"></i></div>
    </AppLightButton>
    <!-- /editing actions -->
  </div>
  <!-- /editor node actions -->
</template>
