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
    <!-- code -->
    <AppLightButton
      type="button"
      class="text-xs"
      :disabled="!editor.can().chain().focus().toggleCode().run()"
      :class="{ 'bg-slate-300': editor.isActive('code') }"
      @click="editor.chain().focus().toggleCode().run()"
    >
      <i class="bi bi-code text-xl leading-none leading-none"></i>
    </AppLightButton>

    <!-- clear marks -->
    <AppLightButton
      type="button"
      class="text-xs line-through"
      @click="editor.chain().focus().unsetAllMarks().run()"
    >
      <div class="relative">
        <i class="bi bi-type text-xl leading-none"></i>
        <div class="w-full h-full absolute -left-2 bottom-1.5 text-slate-500">
          <i class="bi bi-dash-lg text-4xl leading-none"></i>
        </div>
      </div>
    </AppLightButton>

    <!-- clear nodes -->
    <AppLightButton
      type="button"
      class="text-xs"
      @click="editor.chain().focus().clearNodes().run()"
    >
      <div class="inline-block relative">
        <i class="bi bi-x-octagon text-xl leading-none"></i>
      </div>
    </AppLightButton>
  </div>
  <!-- /editor node actions -->
</template>
