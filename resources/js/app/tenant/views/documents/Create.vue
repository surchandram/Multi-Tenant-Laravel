<script>
  export default {
    pageLayout: "company_settings",
  };
</script>

<script setup>
  import { inject, onMounted, reactive, watch, computed, ref } from "vue";
  import { Head, useForm, Link } from "@inertiajs/vue3";
  import Editor from "@/components/Editor.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppCheckbox from "@/components/AppCheckbox.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import AppButton from "@/components/AppButton.vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import AppSpinner from "@/components/AppSpinner.vue";
  import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
  import ChevronDown from "@/components/ChevronDown.vue";
  import DocumentPreviewModal from "@/components/documents/DocumentPreviewModal.vue";

  const typeId = ref(null);
  const documentData = ref(null);


  const props = defineProps(["model"]);

  const form = useForm({
    title: props.document?.title || '',
    type_id: props.document?.type_id || '',
    body: props.document?.body || '',
    is_editable: true,
    usable: false,
  });

  const documentName = computed(() => form.title || "Untitled");

  onMounted(() => {
    // listen to 'show-document' event
    $eventBus.on('show-document', (document) => {
      documentData.value = document;
    });
  });

  const $scrollTo = inject("$scrollTo");

  const scrollTo = (el = "body") => {
    $scrollTo(el, { container: "body" });
  };

  const store = () => {
    form.clearErrors();
    scrollTo();

    form
      .transform((data) => ({
        ...data,
      }))
      .post(route("tenant.documents.store"), {
        //
      });
  };
</script>

<template>
  <Head :title="`New Document | ${$page.props.tenant.name}`" />

  <div class="flex flex-col gap-10 relative">
    <!-- Heading Area -->
    <div class="w-full flex md:items-center mb-3">
      <!-- Heading -->
      <h1 class="text-slate-800 text-2xl font-hairline leading-tight mr-auto">
        <span class="font-semibold">{{ documentName }}</span>
      </h1>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-center gap-3">
        <div class="flex items-center gap-2">
          <p></p>

          <!-- Actions -->
          <Menu v-slot="{ open }" as="div" class="relative inline-block text-left">
            <div class="inline-flex items-center rounded-l-md">
              <!-- Save Button -->
              <div class="flex items-center justify-end lg:justify-start">
                <AppButton
                  type="submit"
                  class="inline-flex items-center gap-2 rounded-r-none"
                  :disabled="form.processing"
                  @click.prevent="store"
                >
                  <AppSpinner v-show="form.processing" :size="4" />
                  <i v-show="!form.processing" class="bi bi-check"></i>
                  Save
                </AppButton>
              </div>

              <!-- MenuButton -->
              <MenuButton
                class="
                  w-full
                  inline-flex
                  items-center
                  justify-center
                  gap-1
                  rounded-r-md
                  bg-teal-500
                  px-4
                  py-2
                  text-sm
                  font-medium
                  text-white
                  hover:bg-teal-700
                  focus:outline-none
                  focus:ring-2
                  focus-visible:ring-2
                  focus-visible:ring-white
                  focus-visible:ring-opacity-75
                "
              >
                <ChevronDown :open="open" />
              </MenuButton>
            </div>

            <transition
              enter-active-class="transition duration-100 ease-out"
              enter-from-class="transform scale-95 opacity-0"
              enter-to-class="transform scale-100 opacity-100"
              leave-active-class="transition duration-75 ease-in"
              leave-from-class="transform scale-100 opacity-100"
              leave-to-class="transform scale-95 opacity-0"
            >
              <MenuItems
                class="flex flex-col w-56 px-1 py-1 mt-2 rounded-md absolute shadow-lg right-0 origin-top-right bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <!-- Preview Button -->
                <MenuItem v-slot="{ active }">
                  <AppButton
                    type="button"
                    class="inline-flex items-center gap-2 px-1 py-2 text-sm font-semibold"
                    :class="{ 'bg-slate-200': active }"
                    plain
                    @click="$eventBus.emit('show-document', form.data())"
                  >
                    <i class="bi bi-eye"></i>
                    Preview
                  </AppButton>
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
          <!-- /Actions -->
        </div>
      </div>
    </div>
    <!-- /Heading Area -->

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 py-6">
      <!-- Form -->
      <div>
        <form action="#" @submit.prevent="store">
          <AppValidationErrors :errors="form.errors" />

          <div class="mt-2">
            <AppInputLabel class="inline-flex items-center gap-1">
              <AppCheckbox v-model="form.usable" />
              Live
            </AppInputLabel>
          </div>

          <!-- Title -->
          <div class="mt-4">
            <AppInputLabel for="title">Title</AppInputLabel>

            <AppInput id="title" v-model="form.title" class="w-full mt-2" name="title" />

            <AppInputError class="mt-2" :message="form.errors.title" />
          </div>

          <!-- Type -->
          <div class="mt-4 relative">
            <AppInputLabel for="type_id" class="block mb-2">Type</AppInputLabel>

            <div class="z-[99] sticky">
              <select
                id="type_id"
                ref="typeId"
                v-model="form.type_id"
                v-choicesjs
                class="w-full mt-2"
                name="type_id"
              >
                <option value>Choose type</option>
                <option
                  v-for="type in model.document_types"
                  :key="type.id"
                  :value="type.id"
                >{{ type.name }}</option>
              </select>
            </div>

            <AppInputError class="mt-2" :message="form.errors.type_id" />
          </div>

          <!-- Body -->
          <div>
            <!-- divider -->
            <div class="flex items-center flex-nowrap gap-2 py-2 mt-5">
              <div class="w-12">
                <div class="w-full h-0 border-t-2 border-blue-600">&nbsp;</div>
              </div>
              <p class="text-lg font-semibold">Body</p>
            </div>

            <div class="pt-4">
              <div
                class="
                  px-1
                  py-1
                  mt-3
                  border
                  border-dotted
                  border-slate-500
                  rounded
                  relative
                "
              >
                <Editor
                  v-model="form.body"
                  menu="fixed"
                  :mentionable-keys="['%']"
                  :mentionable-items="model.replacements"
                />
              </div>
            </div>
          </div>

          <div class="mt-4">
            <div class="flex items-baseline justify-end gap-3">
              <!-- Preview Button -->
              <AppLightButton
                type="button"
                @click="$eventBus.emit('show-document', form.data())"
              >
                <i class="bi bi-eye"></i>
                Preview
              </AppLightButton>

              <!-- Save Button -->
              <AppButton type="submit" class="flex items-center gap-2" :disabled="form.processing">
                <AppSpinner v-show="form.processing" :size="4" />
                <i v-show="!form.processing" class="bi bi-check"></i>
                Save
              </AppButton>
            </div>
          </div>
        </form>
      </div>
      <!--/ Form -->

      <!-- DocumentPreviewModal -->
      <DocumentPreviewModal :replacements="model.replacements_dummy" />
      <!-- /DocumentPreviewModal -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
