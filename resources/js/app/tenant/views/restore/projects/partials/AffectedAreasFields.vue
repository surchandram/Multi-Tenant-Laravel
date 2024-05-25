<script setup>
  import { onMounted, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import FormSectionDivider from '@/components/FormSectionDivider.vue';

  const props = defineProps({
    modelValue: {
      type: Array,
      default: function () {
        return [];
      },
    },
    errors: {
      type: Object,
      default: function () {
        return {};
      },
    },
    data: {
      type: Object,
      default: function () {
        return {};
      },
    },
  });

  const emit = defineEmits(['update:modelValue']);

  const form = useForm({
    affected_areas: props.modelValue,
    selectInput: '',
    showCreatorForm: false,
  });

  var choicesJS;

  const addItem = () => {
    const inputVal = _.startCase(form.selectInput);

    choicesJS.setChoices([
      {
        value: inputVal,
        label: inputVal,
        selected: true,
      },
    ]);

    form.affected_areas.push(inputVal);

    choicesJS?.clearInput();

    form.selectInput = '';
    form.showCreatorForm = false;
  };

  const toggleCreatorForm = () => {
    form.showCreatorForm = !form.showCreatorForm;
  };

  var inputField;

  const onBooted = function (choiceJSInstance) {
    choicesJS = choiceJSInstance;
    inputField = choiceJSInstance.input.element;
    inputField.addEventListener('input', (event) => {
      form.selectInput = event.target.value;
    });
  };

  onMounted(() => {
    // Object.keys(props.modelValue).forEach(function (field) {
    //   form[field] = props.modelValue[field];
    // });
    form.affected_areas = props.modelValue;

    watch(
      () => _.cloneDeep(form),
      () => {
        emit('update:modelValue', form.affected_areas);
      },
    );
  });
</script>

<template>
  <div>
    <FormSectionDivider value="Affected Areas" />

    <!-- Affected Areas -->
    <div class="mt-4">
      <AppInputLabel
        for="affected_areas"
        class="block mb-2"
      >
        Affected Areas
      </AppInputLabel>

      <div class="flex items-baseline gap-2">
        <div class="flex-1">
          <p
            v-if="form.showCreatorForm"
            class="text-xs font-semibold text-slate-500 mb-2"
          >
            Are you sure you want to add item to affected areas?
          </p>

          <!-- Add Item Input -->
          <AppInput
            v-show="form.showCreatorForm"
            v-model="form.selectInput"
            class="w-full"
          />
          <!-- /Add Item Input -->

          <!-- Select Wrapper -->
          <div v-show="!form.showCreatorForm">
            <select
              id="affected_areas"
              v-model="form.affected_areas"
              v-choicesjs="{
                addItems: true,
                removeItemButton: true,
                duplicateItemsAllowed: false,
                editItems: true,
                onBooted: onBooted,
              }"
              multiple
              class="w-full mt-2"
              name="affected_areas"
            >
              <option value="">Pick or add affected areas</option>
              <option
                v-for="affected_area in data.affected_areas"
                :key="affected_area.name"
                :value="affected_area.name"
              >
                {{ affected_area.name }}
              </option>
            </select>
          </div>
          <!-- /Select Wrapper -->
        </div>

        <!-- Button Group -->
        <div
          :class="{
            'my-auto': !form.showCreatorForm,
            'mt-auto': form.showCreatorForm,
          }"
        >
          <div
            v-if="form.showCreatorForm"
            class="flex items-baseline gap-2"
          >
            <!-- Add Item Button -->
            <AppButton
              type="button"
              class="h-full"
              @click.prevent="addItem"
            >
              <i class="bi bi-check"></i>
            </AppButton>

            <!-- Cancel Button -->
            <AppLightButton
              type="button"
              @click.prevent="toggleCreatorForm"
            >
              <i class="bi bi-x-lg"></i>
            </AppLightButton>
          </div>

          <!-- Confirm Button -->
          <AppButton
            v-else
            type="button"
            class="h-full my-auto"
            @click.prevent="toggleCreatorForm"
          >
            <i class="bi bi-plus"></i>
          </AppButton>
        </div>
      </div>

      <AppInputError
        class="mt-2"
        :message="errors?.affected_areas"
      />
    </div>
  </div>
</template>
