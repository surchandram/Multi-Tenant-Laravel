<script setup>
  import { onMounted, watch, computed } from "vue";
  import { useForm } from "@inertiajs/vue3";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppLightButton from "@/components/AppLightButton.vue";

  const props = defineProps({
    modelValue: {
      type: [String, Number],
      default: '',
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
    label: {
      type: String,
      default: "Project Authorization",
    },
  });

  const emit = defineEmits(["update:modelValue"]);

  const form = useForm({
    document: props.modelValue,
    selectInput: "",
    showCreatorForm: false,
  });

  const id = computed(() => slugify(props.label));

  onMounted(() => {
    // Object.keys(props.modelValue).forEach(function (field) {
    //   form[field] = props.modelValue[field];
    // });
    form.document = props.modelValue;

    watch(
      () => _.cloneDeep(form),
      () => {
        emit("update:modelValue", form.document);
      }
    );
  });
</script>

<template>
  <div>
    <!-- Project Authorization -->
    <div class="mt-4">
      <AppInputLabel
        :for="id"
        class="inline-flex items-center gap-2 mb-2"
      >
        {{ label }}
        <AppLightButton
          v-if="form.document"
          class="text-lg rounded-full"
          @click="$eventBus.emit('show-document', data.find((d) => d.id == form.document))"
        >
          <i class="bi bi-info-circle"></i>
        </AppLightButton>
      </AppInputLabel>

      <select
        :id="id"
        v-model.number="form.document"
        v-choicesjs
        class="w-full mt-2"
        :name="id"
      >
        <option value>Choose document</option>
        <option
          v-for="document in data"
          :key="document.id"
          :value="document.id"
          :disabled="!document.usable"
        >{{ document.title }}</option>
      </select>

      <AppInputError class="mt-2" :message="errors[id]" />
    </div>
  </div>
</template>
