<script setup>
  import { ref } from "vue";
  import { useModal } from "momentum-modal";
  import { Dialog, DialogPanel, TransitionRoot } from "@headlessui/vue";

  import AppLightButton from "@/components/AppLightButton.vue";

  defineProps({
    title: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "",
    },
  });

  const { show, redirect } = useModal();

  const modalRef = ref(null);

  const close = () => {
    redirect();
  };
</script>

<template>
  <TransitionRoot
    ref="modalRef"
    :show="show"
    enter="duration-300 ease-out"
    enter-from="opacity-0"
    enter-to="opacity-100"
    leave="duration-200 ease-in"
    leave-from="opacity-100"
    leave-to="opacity-0"
  >
    <Dialog class="relative z-[99999]" :open="show" as="div" @close="close">
      <!-- The backdrop, rendered as a fixed sibling to the panel container -->
      <div class="fixed inset-0 bg-slate-800 bg-opacity-50" aria-hidden="true" />

      <!-- Full-screen scrollable container -->
      <div class="fixed inset-0 overflow-y-auto">
        <!-- Container to center the panel -->
        <div class="min-h-screen flex items-center justify-center p-4">
          <!-- The actual dialog panel -->
          <DialogPanel
            as="div"
            v-bind="$attrs"
            :class="[
              size ? 'sm:' + size : 'md:max-w-4xl xl:max-w-7xl'
            ]"
            class="w-full px-4 py-8 lg:px-8 lg:py-12 rounded bg-white dark:bg-slate-800 dark:text-white transition-all"
          >
            <!-- Header -->
            <div class="flex items-center justify-between gap-3">
              <div class="flex-1">
                <slot name="header" :close="close">
                  <h3 v-if="!$slots.header" class="text-lg text-slate-700 font-medium">{{ title }}</h3>
                </slot>
              </div>

              <aside class="flex items-center gap-3">
                <!-- Close -->
                <AppLightButton @click="close">
                  <i class="bi bi-x-lg"></i>
                </AppLightButton>
                <!-- END Close -->
              </aside>
            </div>
            <!-- END Header -->

            <slot />
          </DialogPanel>
          <!-- END DialogPanel -->
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
