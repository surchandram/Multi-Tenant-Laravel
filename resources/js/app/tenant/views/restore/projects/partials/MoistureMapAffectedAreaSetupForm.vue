<script setup>
  import { ref } from 'vue';
  import { useForm } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import AppLightButton from "@/components/AppLightButton.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";

  const props = defineProps({
    modelValue: { 
      type: Array,
      default: function () {
        return [];
      }
    },
    affectedArea: { 
      type: Object,
      default: function () {
        return {};
      }
    },
    errors: { 
      type: Object,
      default: function () {
        return {};
      }
    },
    data: { 
      type: Object,
      default: function () {
        return {};
      }
    },
    opened: { 
      type: Boolean,
      default: false
    },
  });

  const emit = defineEmits([
    'update:modelValue',
    'input',
  ]);

  const form = useForm({
    affected_area_id: props.affectedArea.id,
    structure: '',
    material: '',
  });

  const showCreatorForm = ref(props.opened);
  const structureDraft = ref('');
  const materialDraft = ref('');

  var structureChoicesJS;
  var materialChoicesJS;

  const addToMap = () => {
    form.clearErrors();

    _.keys(form.data()).forEach( function(key) {
      if (form[key] == '') {
        form.setError(key, "Field is required");
      }
    });

    if (!_.isEmpty(form.errors)) {
      return;
    }

    emit('update:modelValue', form.data());
    emit('input', form.data());

    structureChoicesJS?.clearInput();
    structureChoicesJS?.setChoiceByValue('');
    materialChoicesJS?.clearInput();
    materialChoicesJS?.setChoiceByValue('');

    form.reset();

    if (!props.opened) {
      toggleCreatorForm();
    }
  };

  const toggleCreatorForm = () => {
    showCreatorForm.value = !showCreatorForm.value;
  };

  const addItem = (type) => {
    if (type == 'structure') {
      form.structure = _.startCase(structureDraft.value);
      
      structureChoicesJS.setChoices([
        {
          value: form.structure,
          label: form.structure,
          selected: true
        },
      ]);

      structureDraft.value = '';
    }
    else if (type == 'material') {
      form.material = _.startCase(materialDraft.value);
      
      materialChoicesJS.setChoices([
        {
          value: form.material,
          label: form.material,
          selected: true
        },
      ]);

      materialDraft.value = '';
    }
  };

  const onStructureSelectBooted = function (choiceJSInstance) {
    structureChoicesJS = choiceJSInstance;
    var inputField = choiceJSInstance.input.element;

    inputField.addEventListener('input', (event) => {
      structureDraft.value = event.target.value;
    });
  };

  const onMaterialSelectBooted = function (choiceJSInstance) {
    materialChoicesJS = choiceJSInstance;
    var inputField = choiceJSInstance.input.element;

    inputField.addEventListener('input', (event) => {
      materialDraft.value = event.target.value;
    });
  };
</script>

<template>
  <div>
    <slot
      :start-opened="opened"
      :show-form="showCreatorForm"
      :toggle-form="toggleCreatorForm"
    ></slot>

    <form
      v-if="showCreatorForm"
      action="#"
      @submit.prevent="addToMap"
    >
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
        <div
          class="px-2 py-3 border-2 border-blue-500 border-dotted"
        >
          <AppInputLabel class="block mb-2" value="Structure" />
      
          <select
            v-model="form.structure"
            v-choicesjs="{ onBooted: onStructureSelectBooted }"
          >
            <option value="">Choose structure</option>
            <option
              v-for="structure in data.structures"
              :key="structure.id"
              :value="structure.name"
            >
              {{ structure.name }}
            </option>
          </select>

          <AppInputError :message="form.errors.structure" class="mt-2" />
    
          <p
            v-if="structureDraft"
            class="text-xs font-semibold text-slate-400"
          >
            Define 
            <span class="text-slate-700">{{ structureDraft }}</span> 
            as new structure.
            <a
              href="#"
              class="text-sm text-blue-500 hover:underline"
              @click.prevent="addItem('structure')"
            >
              Add
            </a>
          </p>
        </div>
      
        <div
          class="
            px-2
            py-3
            border-2
            border-blue-500
            border-dotted
          "
        >
          <AppInputLabel class="block mb-2" value="Material" />
      
          <select
            v-model="form.material"
            v-choicesjs="{ onBooted: onMaterialSelectBooted }"
          >
            <option value="">Choose material</option>
            <option
              v-for="material in data.materials"
              :key="material.id"
              :value="material.name"
            >
              {{ material.name }} ({{ material.dry_goal }}%)
            </option>
          </select>

          <AppInputError :message="form.errors.material" class="mt-2" />
    
          <p
            v-if="materialDraft"
            class="text-xs font-semibold text-slate-400"
          >
            Define 
            <span class="text-slate-700">{{ materialDraft }}</span> 
            as new material.
            <a
              href="#"
              class="text-sm text-blue-500 hover:underline"
              @click.prevent="addItem('material')"
            >
              Add
            </a>
          </p>
        </div>
      
        <div
          class="flex items-end gap-3 px-2 py-3 border-2 border-transparent"
        >
          <!-- Add Button -->
          <AppButton type="submit">
            <i class="bi bi-check"></i> Add
          </AppButton>

          <!-- Cancel Button -->
          <AppLightButton type="button" class="md:hidden" @click="showCreatorForm = false">
            <i class="bi bi-x"></i> Cancel
          </AppLightButton>
        </div>
      </div>
    </form>
  </div>
</template>
