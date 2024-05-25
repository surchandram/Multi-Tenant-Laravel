<script setup>
  import { computed, watch } from "vue";
  import { useEditor, EditorContent } from "@tiptap/vue-3";
  import StarterKit from "@tiptap/starter-kit";
  import Underline from "@tiptap/extension-underline";
  import Placeholder from "@tiptap/extension-placeholder";
  import { Mentionable } from "vue-mention";
  import EditorFixedMenus from "@/components/EditorFixedMenus.vue";

  const props = defineProps({
    modelValue: {
      type: String,
      default: "",
    },
    editorStyles: {
      type: String,
      default:
        "min-w-full w-full pb-6 text-gray-700 prose prose-sm lg:prose focus:outline-none",
    },
    extensions: {
      type: Array,
      default: () => [],
    },
    mentionableKeys: {
      type: Array,
      default: () => ["@"],
    },
    mentionableItems: {
      type: Array,
      default: () => ["@"],
    },
    menu: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "Write something...",
    },
  });

  const emit = defineEmits(["update:modelValue"]);

  const editor = useEditor({
    content: props.modelValue,
    extensions: _.concat(
      [
        StarterKit,
        Underline,
        Placeholder.configure({
          // Use a placeholder:
          placeholder: props.placeholder,
          // Use different placeholders depending on the node type:
          // placeholder: ({ node }) => {
          //   if (node.type.name === "heading") {
          //     return "What’s the title?";
          //   }

          //   return "Can you add some further context?";
          // },
        }),
      ],
      props.extensions
    ),

    editorProps: {
      attributes: {
        class: props.editorStyles,
      },
    },

    onUpdate: (context) => {
      emit("update:modelValue", context.editor.getHTML());
    },
  });

  const menus = {
    fixed: EditorFixedMenus,
  };

  const selectedMenu = computed(() => menus[props.menu]);

  watch(
    () => props.modelValue,
    (value) => {
      if (editor.value.getHTML() === value) {
        return;
      }

      editor.value.commands.setContent(props.modelValue);
    }
  );
</script>

<template>
  <div class="relative">
    <Mentionable :keys="mentionableKeys" :items="mentionableItems" offset="6">
      <!-- Editor Menu -->
      <component :is="selectedMenu" v-if="editor && menu" :editor="editor" />
      <!-- /Editor Menu -->
      <EditorContent :editor="editor" />
    </Mentionable>
  </div>
</template>

<style lang="scss" scoped>
/* Basic editor styles */
.ProseMirror {
  > * + * {
    margin-top: 0.75em;
  }
}
</style>
