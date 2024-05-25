<script setup>
  import colors from 'tailwindcss/colors';
  import { computed, ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import { isString, omitBy, omit, map, filter, includes } from 'lodash';
  import { useModal } from 'momentum-modal';

  import { Combobox, ComboboxButton, ComboboxInput, ComboboxOptions, ComboboxOption } from '@headlessui/vue';

  import Modal from '@/components/modals/Modal.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';

  const props = defineProps({
    model: {
      required: true,
      type: Object,
    },
  });

  const { redirect } = useModal();

  const form = useForm(props.model.settings);

  const store = () => {
    form.post(route(route().current()), {
      onSuccess: () => {
        redirect();
      },
    });
  };

  // Declare a flatten function that takes
  // object as parameter and returns the
  // flatten object
  const flattenObj = (ob) => {
    // The object which contains the
    // final result
    let result = {};

    // loop through the object "ob"
    for (const i in ob) {
      // We check the type of the i using
      // typeof() function and recursively
      // call the function again
      if (typeof ob[i] === 'object' && !Array.isArray(ob[i])) {
        const temp = flattenObj(ob[i]);
        for (const j in temp) {
          // Store temp in result
          result[i + ' ' + j] = temp[j];
        }
      }

      // Else store ob[i] in result directly
      else {
        result[i] = ob[i];
      }
    }
    return result;
  };

  var filteredColors = flattenObj(
    omit(
      omitBy(colors, (f) => isString(f)),
      ['lightBlue', 'warmGray', 'trueGray', 'coolGray', 'blueGray'],
    ),
  );

  filteredColors = map(filteredColors, (val, key) => Object.assign({}, { label: key, value: val }));

  const colorQuery = ref('');

  const filteredColorsCombo = computed(() =>
    colorQuery.value === ''
      ? filteredColors
      : filter(filteredColors, (color) => {
          return color.label.toLowerCase().includes(colorQuery.value.toLowerCase());
        }),
  );

  const getColor = (color) => {
    return filteredColors.find((c) => c.value === color)?.label;
  };
</script>

<template>
  <Modal
    size="max-w-sm"
    title="Project Type Settings"
  >
    <form
      class="py-3 space-y-6"
      action="#"
      @submit.prevent="store"
    >
      <div
        v-for="(type, key) in model.types"
        :key="key"
        class="space-y-3"
      >
        <AppInputLabel
          class="flex items-center gap-2"
          :for="type"
        >
          <span
            :style="{ backgroundColor: form[key], borderColor: form[key] }"
            class="w-4 h-4 border rounded-full"
          ></span>
          {{ type }}
        </AppInputLabel>

        <Combobox v-model="form[key]">
          <div class="relative">
            <ComboboxButton class="w-full flex items-center">
              <ComboboxInput
                class="w-full rounded border border-gray-300 py-2 pl-3 pr-10 text-sm leading-5 text-slate-900 focus:ring-1"
                :display-value="(color) => getColor(color)"
                @change="colorQuery = $event.target.value"
              />
            </ComboboxButton>

            <!-- ComboboxOptions -->
            <ComboboxOptions
              class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
              <!-- ComboboxOption -->
              <ComboboxOption
                v-for="color in filteredColorsCombo"
                :key="color.label"
                v-slot="{ selected, active }"
                :value="color.value"
                class="flex items-center gap-3 relative cursor-default select-none py-2 px-4"
              >
                <div
                  class="w-4 h-4 inline-block"
                  :style="{ backgroundColor: color.value }"
                ></div>

                <span :class="selected || active ? 'font-medium' : ''">{{ color.label }}</span>
              </ComboboxOption>
              <!-- END ComboboxOption -->
            </ComboboxOptions>
            <!-- END ComboboxOptions -->
          </div>
        </Combobox>

        <AppInputError :error="form.errors[key]" />
      </div>

      <div class="flex item-center gap-3">
        <AppButton
          class="ml-auto"
          theme="outline-secondary"
          @click.prevent="redirect"
        >
          Cancel
        </AppButton>

        <AppButton type="submit">Save</AppButton>
      </div>
    </form>
  </Modal>
</template>
