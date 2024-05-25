<script setup>
  import { ref } from "vue";
  import { useModal } from "momentum-modal";
  import AppLightButton from "@/components/AppLightButton.vue";

  defineProps({
    contentClasses: {
      type: [String, Array],
      default: "",
    },
    drawerLeft: {
      type: Boolean,
      default: false,
    },
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
  <div v-if="show">
    <Transition
      ref="modalRef"
      appear
      :show="show"
      enter="duration-300 ease-out"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <div class="w-full h-full">
        <!-- The backdrop, rendered as a fixed sibling to the panel container -->
        <Transition
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 z-[99999] bg-slate-800/75" aria-hidden="true" />
        </Transition>

        <!-- Full-screen scrollable container -->
        <div
          :class="[
            drawerLeft ? 'left-0' : 'right-0',
            size ? 'sm:' + size : 'sm:max-w-sm xl:max-w-lg'
          ]"
          class="w-full h-screen flex fixed top-0 z-[99999] overflow-hidden"
        >
          <div class="min-w-full h-full overflow-y-auto">
            <!-- Container to center the panel -->
            <div :class="contentClasses" class="p-7 bg-white dark:bg-slate-800">
              <!-- Transition  -->
              <Transition
                enter="duration-300 ease-out"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
              >
                <!-- The actual dialog panel -->
                <div as="div" v-bind="$attrs" class="space-y-4 transition-all">
                  <div class="flex items-center justify-between gap-3">
                    <div class="flex-1">
                      <slot name="header" :close="close">
                        <h3
                          v-if="!$slots.header"
                          class="text-lg text-slate-700 font-medium"
                        >{{ title }}</h3>
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
                  <slot :close="close" />
                </div>
                <!-- END DialogPanel -->
              </Transition>
              <!-- END Transition  -->
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>
