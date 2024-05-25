<script setup>
  import { ref, onMounted, computed, watch } from 'vue';
  import { useForm, usePage } from '@inertiajs/vue3';
  import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
  } from '@headlessui/vue';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppModal from '@/components/AppModal.vue';
  import ChevronDown from '@/components/ChevronDown.vue';

  const props = defineProps({
    id: {
      type: String,
      default: Date.now() + 'dropdownMenuButton',
    },
    label: {
      type: String,
      default: 'Actions',
    },
    triggerStyles: {
      type: [String, Array],
      default:
        'group inline-flex items-center focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75',
    },
    as: {
      type: String,
      default: '',
    },
  });

  const selectedLanguage = ref({});

  let query = ref('');

  let filteredLanguages = computed(() =>
    query.value === ''
      ? usePage().props.languages
      : usePage().props.languages.filter((language) =>
          language.label.toLowerCase().replace(/\s+/g, '').includes(query.value.toLowerCase().replace(/\s+/g, '')),
        ),
  );

  const form = useForm({
    language: usePage().props.language,
  });

  const changeLanguage = () => {
    form.post(route('language.store'), {
      onSuccess: () => {
        $eventBus.emit('close-modal', 'SiteLanguageModal');
      },
      onError: () => {
        //
      },
    });
  };

  onMounted(() => {
    selectedLanguage.value = _.find(usePage().props.languages, ['value', usePage().props.language]);

    watch(selectedLanguage, (lang) => {
      form.language = lang.value;
    });
  });
</script>

<template>
  <div>
    <!-- Modal Trigger Button -->
    <component
      :is="as ? as : AppLightButton"
      :class="triggerStyles"
      @click.prevent="$eventBus.emit('open-modal', 'SiteLanguageModal')"
    >
      <slot>
        <span>Lang</span>
        <ChevronDown
          :open="false"
          class="ml-2 h-5 w-5 text-orange-300 transition duration-150 ease-in-out group-hover:text-opacity-80"
          aria-hidden="true"
        />
      </slot>
    </component>
    <!-- END Modal Trigger Button -->

    <AppModal
      id="SiteLanguageModal"
      class="relative z-50"
      no-footer
      allow-overflow
      no-scroll
    >
      <template #header>Change Language</template>

      <form
        class="min-h-[50vh] md:min-h-fit"
        action="#"
        @submit.prevent="changeLanguage"
      >
        <div class="flex flex-col md:flex-row md:items-center gap-8 p-7">
          <Combobox
            v-model="selectedLanguage"
            as="div"
            class="flex-1"
          >
            <div class="relative">
              <div
                class="w-full cursor-default border border-slate-100 rounded-lg relative bg-slate-300 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
              >
                <ComboboxInput
                  class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                  :display-value="(language) => language.label"
                  @change="query = $event.target.value"
                />

                <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
                  <ChevronDown
                    :open="false"
                    class="h-5 w-5 text-gray-400"
                    aria-hidden="true"
                  />
                </ComboboxButton>
              </div>

              <TransitionRoot
                leave="transition ease-in duration-100"
                leave-from="opacity-100"
                leave-to="opacity-0"
                @after-leave="query = ''"
              >
                <ComboboxOptions
                  class="absolute z-[99999] mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                >
                  <ComboboxOption
                    v-for="language in filteredLanguages"
                    v-slot="{ active, selected }"
                    :key="language.label"
                    :value="language"
                  >
                    <li
                      class="relative cursor-default select-none py-2 pl-10 pr-4"
                      :class="{
                        'bg-teal-600 text-white': active,
                        'text-gray-900': !active,
                      }"
                    >
                      <span
                        class="block truncate"
                        :class="{ 'font-medium': selected, 'font-normal': !selected }"
                      >
                        {{ language.label }}
                      </span>
                      <span
                        v-if="selected"
                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
                      >
                        <i
                          class="bi bi-check h-5 w-5"
                          aria-hidden="true"
                        />
                      </span>
                    </li>
                  </ComboboxOption>
                </ComboboxOptions>
              </TransitionRoot>
            </div>
          </Combobox>

          <div class="md:col-span-1 self-end md:self-auto">
            <AppButton type="submit">Change</AppButton>
          </div>
        </div>
      </form>
    </AppModal>
  </div>
</template>
