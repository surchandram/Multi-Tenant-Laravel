<script setup>
  import { reactive, ref, onMounted, inject, computed, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import { useModal } from 'momentum-modal';

  import { DialogTitle, TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';

  import Modal from '@/components/modals/Modal.vue';

  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';

  import formatDocument from '@/helpers/documentFormatter';

  import { find } from 'lodash';

  const props = defineProps(['model']);

  const { redirect } = useModal();

  const documentsRef = ref([]);
  const authorizeButtonRef = ref(null);
  const isOpen = ref(false);
  const selectedTab = ref(0);

  const form = useForm({
    documents: [],
  });

  const tabsOutOfBound = computed(
    () => selectedTab.value >= 0 && selectedTab.value + 1 >= _.size(props.model.authorization_documents),
  );

  const setIsOpen = (value) => {
    isOpen.value = value;

    if (!value) {
      form.reset();
      selectedTab.value = 0;
      redirect();
    }
  };

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body') => {
    $scrollTo(el, { container: '#app', duration: 500, offset: 0 });
  };

  const formatBody = (text) => formatDocument(text, props.model.replacements);

  const changeTab = (index) => {
    selectedTab.value = index;

    setTimeout(() => {
      scrollTo(`body`);
    }, 500);
  };

  const isAccepted = (docId) => {
    return _.find(form.documents, (d) => d.document_id === docId);
  };

  // signature
  const state = reactive({
    showSignPad: false,
    option: {
      penColor: 'rgb(0, 0, 0)',
      backgroundColor: 'rgb(255,255,255)',
    },
    disabled: false,
  });

  const signaturePadRef = ref(null);

  const remove = (document) => {
    form.documents = form.documents.filter((d) => d.document_id !== document.id);
    clear();
    state.disabled = false;
  };

  const save = (t) => {
    if (signaturePadRef.value[0].isEmpty()) {
      return;
    }

    const img = signaturePadRef.value[0].save(t);

    const doc = props.model.authorization_documents[selectedTab.value];

    form.documents = form.documents.filter((a) => a.document_id !== doc.id);

    form.documents.push({
      document_id: doc.id,
      signature: img,
    });

    state.disabled = true;
  };

  const clear = () => {
    signaturePadRef.value ? signaturePadRef.value[0].clear() : null;
  };

  const undo = () => {
    signaturePadRef.value ? signaturePadRef.value[0].undo() : null;
  };

  const signatureFromDataURL = (url) => {
    signaturePadRef.value ? signaturePadRef.value[0].fromDataURL(url) : null;
  };
  // END signature

  const store = () => {
    form.post(route('restore.projects.authorization.store', props.model.project), {
      onSuccess: () => setIsOpen(false),
    });
  };

  const resetTabSignature = (tabIndex) => {
    if (typeof tabIndex === 'undefined' || tabIndex < 0) {
      return;
    }

    clear();
    state.disabled = false;

    setTimeout(() => {
      const doc = props.model.authorization_documents[tabIndex];

      const data = find(form.documents, (document) => document.document_id == doc.id);

      if (doc && data?.signature) {
        signatureFromDataURL(data.signature);
      }
    }, 500);
  };

  onMounted(() => {
    watch(selectedTab, (tabIndex) => {
      setTimeout(() => {
        resetTabSignature(tabIndex);
      }, 500);
    });

    resetTabSignature(selectedTab.value);
  });
</script>

<template>
  <div>
    <Modal class="overflow-auto">
      <DialogTitle
        as="div"
        class="flex items-start justify-between py-2 mb-6"
      >
        <div class="space-y-3">
          <h2 class="font-semibold text-lg text-slate-600">{{ __('tenant.labels.authorization') }}</h2>

          <p class="text-sm font-medium">{{ __('tenant.labels.project_authorization_agreement_prompt') }}</p>

          <div class="text-xs font-semibold text-slate-700">
            {{ model.project.address.address_1 }}, {{ model.project.address.city }},
            {{ model.project.address.postal_code }},
            {{ model.project.address.state }}
          </div>
        </div>

        <AppLightButton
          type="button"
          @click="setIsOpen(false)"
        >
          <i class="bi bi-x"></i>
        </AppLightButton>
      </DialogTitle>

      <form
        id="pjAuthTabPanels"
        action="#"
        @submit.prevent="store"
      >
        <span id="pjAuthHeader"></span>
        <AppValidationErrors
          :errors="form.errors"
          :class="{ 'mb-6': form.errors }"
        />

        <TabGroup
          class="flex flex-col gap-1 mb-1 lg:flex-row overflow-hidden"
          as="div"
          :selected-index="selectedTab"
          @change="changeTab"
        >
          <TabList class="flex flex-row lg:flex-col overflow-x-auto w-full lg:w-1/3 bg-slate-50">
            <Tab
              v-for="document in model.authorization_documents"
              :key="document.id"
              v-slot="{ selected }"
              as="template"
              class="focus:outline-none"
            >
              <button
                type="button"
                :class="{
                  'bg-blue-200 text-blue-600': selected,
                }"
                class="w-auto lg:w-full inline-flex items-center justify-start gap-2 px-4 py-3 text-sm md:text-lg whitespace-nowrap font-semibold"
              >
                <span class="hidden lg:inline-block text-sm">
                  <i
                    v-if="selected"
                    class="bi bi-chevron-up"
                  ></i>
                  <i
                    v-else
                    class="bi bi-chevron-down"
                  ></i>
                </span>
                {{ document.type.name }}
                <span
                  v-if="isAccepted(document.id)"
                  class="ml-auto text-teal-600"
                >
                  <i class="bi bi-check-circle"></i>
                </span>
              </button>
            </Tab>
          </TabList>

          <TabPanels
            as="div"
            class="w-full md:flex-1"
          >
            <TabPanel
              v-for="(document, index) in model.authorization_documents"
              :id="`pjAuthTab${index}`"
              :key="document.id"
              ref="documentsRef"
              as="div"
              class="px-4 py-2 bg-slate-50"
            >
              <div
                class="w-full px-6 text-gray-700 prose prose-sm lg:prose"
                v-html="formatBody(document.body)"
              />

              <div class="mt-12 border-t-2 border-indigo-200"></div>

              <div
                v-if="document.signed && !state.showSignPad"
                class="break-words"
              >
                <img
                  :src="document?.signature"
                  class="w-full"
                />

                <div class="mt-8 border-t-2 border-indigo-200"></div>

                <div class="mt-8">
                  <AppButton @click.prevent="state.showSignPad = true">{{
                    __('customer.buttons.change_document_sign')
                  }}</AppButton>
                </div>
              </div>

              <div
                v-else-if="state.showSignPad"
                class="px-2 py-3 mt-12 space-y-6 rounded-md shadow-sm bg-slate-200"
              >
                <AppInputLabel value="Sign here" />

                <Vue3Signature
                  ref="signaturePadRef"
                  :sig-option="state.option"
                  :disabled="state.disabled"
                  :height="'400px'"
                  class="mx-0"
                />

                <div class="flex flex-wrap md:items-center gap-3 mt-4">
                  <template v-if="form.documents.find((d) => d.document_id === document.id)">
                    <AppLightButton
                      type="button"
                      @click.prevent="remove(document)"
                      >Clear</AppLightButton
                    >
                  </template>

                  <template v-else>
                    <AppButton
                      type="button"
                      theme="info"
                      @click.prevent="save('image/png')"
                      >{{ __('app.labels.i_agree') }}</AppButton
                    >

                    <AppLightButton
                      type="button"
                      @click.prevent="clear"
                      >{{ __('app.labels.clear') }}</AppLightButton
                    >

                    <AppLightButton
                      type="button"
                      @click.prevent="undo"
                      >{{ __('app.labels.undo') }}</AppLightButton
                    >

                    <div class="w-full grow md:w-auto md:grow-0 md:ml-auto">
                      <AppButton
                        theme="danger"
                        class
                        @click.prevent="state.showSignPad = false"
                        >{{ __('app.buttons.cancel') }}</AppButton
                      >
                    </div>
                  </template>
                </div>
              </div>

              <div
                v-else
                class="mt-6"
              >
                <AppButton @click.prevent="state.showSignPad = true">{{
                  __('customer.buttons.sign_document')
                }}</AppButton>
              </div>
            </TabPanel>
          </TabPanels>
        </TabGroup>

        <div class="flex items-center justify-end gap-2 mt-12">
          <AppLightButton
            v-if="selectedTab != 0"
            type="button"
            class="border border-slate-100"
            @click="changeTab(selectedTab - 1)"
            >Prev.</AppLightButton
          >

          <AppLightButton
            v-if="!tabsOutOfBound"
            type="button"
            class="border border-slate-100"
            @click="changeTab(selectedTab + 1)"
            >Next</AppLightButton
          >

          <AppLightButton
            type="button"
            @click="setIsOpen(false)"
            >{{ __('app.buttons.cancel') }}</AppLightButton
          >

          <!-- Use `initialFocus` to force initial focus to a specific ref. -->
          <AppButton
            v-if="form.documents.length > 0 && form.documents.length <= model.authorization_documents.length"
            ref="authorizeButtonRef"
            type="submit"
            >{{ __('tenant.labels.authorize') }}</AppButton
          >
        </div>
      </form>
    </Modal>
  </div>
</template>
