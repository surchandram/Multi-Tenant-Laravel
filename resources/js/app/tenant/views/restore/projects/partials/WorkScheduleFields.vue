<script setup>
  import { onMounted, watch } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppInput from '@/components/AppInput.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import FormSectionDivider from '@/components/FormSectionDivider.vue';

  const props = defineProps(['modelValue', 'errors', 'data']);

  const emit = defineEmits(['update:modelValue']);

  const form = useForm({
    starts_at: props.modelValue.starts_at,
    ends_at: props.modelValue.ends_at,
    team_id: props.modelValue.team_id,
  });

  onMounted(() => {
    Object.keys(props.modelValue).forEach(function (field) {
      form[field] = props.modelValue[field];
    });

    watch(
      () => _.cloneDeep(form),
      () => {
        emit('update:modelValue', form.data());
      },
    );
  });
</script>

<template>
  <div>
    <FormSectionDivider value="Job Schedule and Details" />

    <!-- Project Dates -->
    <div class="grid grid-cols-2 gap-6 mb-4">
      <div class="col-md-3">
        <div class="form-group dark:text-secondary">
          <AppInputLabel for="from_date">Starts From</AppInputLabel>

          <AppInput
            id="from_date"
            v-model="form.starts_at"
            type="text"
            class="mt-2 datepicker-from"
          />

          <AppInputError
            class="mt-2"
            :message="errors?.starts_at"
          />
        </div>
      </div>
      <!-- /from -->

      <div class="col-md-3">
        <div class="form-group dark:text-secondary">
          <AppInputLabel for="to_date">Ends On</AppInputLabel>

          <AppInput
            id="to_date"
            v-model="form.ends_at"
            type="text"
            class="mt-2 datepicker-to"
          />

          <AppInputError
            class="mt-2"
            :message="errors?.ends_at"
          />
        </div>
      </div>
      <!-- /to -->
    </div>
    <!-- /Project Dates -->

    <!-- Team -->
    <div class="mt-4">
      <AppInputLabel
        for="team_id"
        class="block mb-2"
      >
        Team assigned
      </AppInputLabel>

      <select
        id="team_id"
        v-model="form.team_id"
        v-choicesjs
        class="w-full mt-2"
        name="team_id"
      >
        <option value="">Choose team</option>
        <option
          v-for="team in data.teams"
          :key="team.id"
          :value="team.id"
        >
          {{ team.name }}
        </option>
      </select>

      <AppInputError
        class="mt-2"
        :message="errors?.team_id"
      />
    </div>
  </div>
</template>
