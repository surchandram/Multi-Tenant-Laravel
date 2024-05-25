<script setup>
  import { onMounted, watch, ref, computed } from 'vue';
  import { useForm } from "@inertiajs/vue3";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputGroup from "@/components/AppInputGroup.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import FormSectionDivider from "@/components/FormSectionDivider.vue";
  import autoComplete from "@tarekraafat/autocomplete.js";
  import { useAutoComplete } from "@/composables/autocompletejs.js";

  import '@tarekraafat/autocomplete.js/dist/css/autoComplete.02.css';

  const props = defineProps([
    'modelValue',
    'errors',
    'data'
  ]);

  const emit = defineEmits([
    'update:modelValue',
  ]);

  const form = useForm(props.modelValue);

  const autoCompleteCompany = ref(null);
  var autoCompleteAgent;
  var autoCompleteAdjuster;

  const selectedCompany = computed(
    () => _.find(props.data.insurance_companies, ['id', form.company?.id])
  );

  const agents = computed(
    () => selectedCompany.value?.users?.filter((u) => u.role == 'insurance_agent')
  );

  const adjusters = computed(
    () => selectedCompany.value?.users?.filter((u) => u.role == 'insurance_adjuster')
  );

  const formatted_deductible = computed(
    () => currencyFormatter(form.deductible, { fromCents: false }).format()
  );

  const setupAutoCompleteForAgent = function () {
    if (typeof autoCompleteAgent?.autoCompleteJS === 'undefined') {
      autoCompleteAgent = useAutoComplete(
        '#insurance_agent_name',
        agents.value || [],
        {
          srcKey: ["name"],
          onKeyup: () => {
            // reset agent id if name changed
            form.agent.id = null;
          },
          onSelection: (selection) => {
            // set company details on selection
            form.agent = _.pick(
              selection,
              ['id', 'name', 'email', 'phone']
            )
          },
        }
      );
    }
  };

  const setupAutoCompleteForAdjuster = function () {
    if (typeof autoCompleteAdjuster?.autoCompleteJS === 'undefined') {
      autoCompleteAdjuster = useAutoComplete(
        '#insurance_adjuster_name',
        adjusters.value || [],
        {
          srcKey: ["name"],
          onKeyup: () => {
            // reset adjuster id if name changed
            form.adjuster.id = null;
          },
          onSelection: (selection) => {
            // set company details on selection
            form.adjuster = _.pick(
              selection,
              ['id', 'name', 'email', 'phone']
            )
          },
        }
      );
    }
  };

  const setupAutoCompleteForCompany = function () {
    autoCompleteCompany.value = new autoComplete({
      selector: "#insurance_company_name",
      placeHolder: "Search for companies or enter name...",
      data: {
        src: props.data.insurance_companies,
        cache: true,
        filter: (list) => {
          const results = list.filter((item) => {
            const inputValue = autoCompleteCompany.value.input.value.toLowerCase();
            const itemValue = item.value.name.toLowerCase();

            if (itemValue.startsWith(inputValue)) {
                return item.value;
            }
          });

          return results;
        },
        keys: ["name"],
      },
      resultItem: {
        highlight: true,
      },
      threshold: 0,
      resultsList: {
        maxResults: undefined
      },
      noResults: false,
      events: {
        input: {
          keyup: () => {
            const name = autoCompleteCompany.value.input.value;

            form.company.name = name;
            form.company.id = null;
          },
          selection: (event) => {
            const selection = event.detail.selection.value;

            autoCompleteCompany.value.input.value = selection.name;

            // set company details on selection
            form.company = _.pick(
              selection,
              ['id', 'name', 'email', 'phone']
            );

            setupAutoCompleteForAgent();
            setupAutoCompleteForAdjuster();
          }
        }
      },
    });
  };

  onMounted(() => {
    watch(() => _.cloneDeep(form), () => {
      emit('update:modelValue', form.data());
    });

    setupAutoCompleteForCompany();

    // setup autoComplete for agent input
    if (form.company.id) {
      setupAutoCompleteForAgent();
      setupAutoCompleteForAdjuster();
    }
  });
</script>

<template>
  <div>
    <FormSectionDivider value="Insurance Details" />

    <!-- Insurance Company -->
    <section>
      <!-- Company Name -->
      <div>
        <AppInputLabel for="insurance_company_name">
          Company Name
        </AppInputLabel>

        <div class="w-full flex flex-col">
          <AppInput
            id="insurance_company_name"
            v-model="form.company.name"
            type="text"
            dir="ltr"
            spellcheck=false
            autocorrect="off"
            autocomplete="off"
            autocapitalize="off"
            maxlength="2048"
            tabindex="1"
            class="w-full mt-2"
            name="insurance_company_name"
          />
        </div>

        <AppInputError
          :message="errors?.company?.name"
          class="mt-2"
        />
      </div>

      <!-- Contact Email -->
      <div class="mt-4">
        <AppInputLabel for="insurance_company_email">
          Contact Email
        </AppInputLabel>

        <AppInput
          id="insurance_company_email"
          v-model="form.company.email"
          type="email"
          class="w-full mt-2"
          name="insurance_company_email"
        />

        <AppInputError
          :message="errors?.company?.email"
          class="mt-2"
        />
      </div>

      <!-- Contact Phone -->
      <div class="mt-4">
        <AppInputLabel for="insurance_company_phone">
          Contact Phone
        </AppInputLabel>

        <AppInput
          id="insurance_company_phone"
          v-model="form.company.phone"
          type="text"
          class="w-full mt-2"
          name="insurance_company_phone"
        />

        <AppInputError
          :message="errors?.company?.phone"
          class="mt-2"
        />
      </div>
    </section>

    <!-- Claim Details -->
    <section class="mt-4">
      <FormSectionDivider value="Claim Details" />

      <!-- policy_no -->
      <div>
        <AppInputLabel for="insurance_policy_no">
          Policy #
        </AppInputLabel>

        <div class="w-full flex flex-col">
          <AppInput
            id="insurance_policy_no"
            v-model="form.policy_no"
            class="w-full mt-2"
            name="insurance_policy_no"
          />
        </div>

        <AppInputError
          :message="errors?.policy_no"
          class="mt-2"
        />
      </div>

      <!-- claim_no -->
      <div class="mt-4">
        <AppInputLabel for="insurance_claim_no">
          Claim #
        </AppInputLabel>

        <AppInput
          id="insurance_claim_no"
          v-model="form.claim_no"
          class="w-full mt-2"
          name="insurance_claim_no"
        />

        <AppInputError
          :message="errors?.claim_no"
          class="mt-2"
        />
      </div>

      <!-- deductible -->
      <div class="mt-4">
        <AppInputLabel for="insurance_deductible">
          Deductible amount
        </AppInputLabel>

        <AppInputGroup class="mt-2" :end="formatted_deductible">
          <template #default="{ inputStyles }">
            <AppInput
              id="insurance_deductible"
              v-model="form.deductible"
              type="number"
              :class="inputStyles"
              class="w-full"
              max="99999"
              name="insurance_deductible"
            />
          </template>
        </AppInputGroup>

        <AppInputError
          :message="errors?.deductible"
          class="mt-2"
        />
      </div>
    </section>

    <!-- Insurance Agent -->
    <section class="mt-4">
      <FormSectionDivider value="Agent Details" />

      <!-- Agent Name -->
      <div>
        <AppInputLabel for="insurance_agent_name">
          Agent Name
        </AppInputLabel>

        <div class="w-full flex flex-col">
          <AppInput
            id="insurance_agent_name"
            v-model="form.agent.name"
            type="text"
            dir="ltr"
            spellcheck=false
            autocorrect="off"
            autocomplete="off"
            autocapitalize="off"
            maxlength="2048"
            tabindex="1"
            class="w-full mt-2"
            name="insurance_agent_name"
          />
        </div>

        <AppInputError
          :message="errors?.agent?.name"
          class="mt-2"
        />
      </div>

      <!-- Agent Email -->
      <div class="mt-4">
        <AppInputLabel for="insurance_agent_email">
          Agent Email
        </AppInputLabel>

        <AppInput
          id="insurance_agent_email"
          v-model="form.agent.email"
          type="email"
          class="w-full mt-2"
          name="insurance_agent_email"
        />

        <AppInputError
          :message="errors?.agent?.email"
          class="mt-2"
        />
      </div>

      <!-- Agent Phone -->
      <div class="mt-4">
        <AppInputLabel for="insurance_agent_phone">
          Agent Phone
        </AppInputLabel>

        <AppInput
          id="insurance_agent_phone"
          v-model="form.agent.phone"
          type="text"
          class="w-full mt-2"
          name="insurance_agent_phone"
        />

        <AppInputError
          :message="errors?.agent?.phone"
          class="mt-2"
        />
      </div>
    </section>

    <!-- Insurance Adjuster -->
    <section class="mt-4">
      <FormSectionDivider value="Adjuster Details" />

      <!-- Adjuster Name -->
      <div>
        <AppInputLabel for="insurance_adjuster_name">
          Adjuster Name
        </AppInputLabel>

        <div class="w-full flex flex-col">
          <AppInput
            id="insurance_adjuster_name"
            v-model="form.adjuster.name"
            type="text"
            dir="ltr"
            spellcheck=false
            autocorrect="off"
            autocomplete="off"
            autocapitalize="off"
            maxlength="2048"
            tabindex="1"
            class="w-full mt-2"
            name="insurance_adjuster_name"
          />
        </div>

        <AppInputError
          :message="errors?.adjuster?.name"
          class="mt-2"
        />
      </div>

      <!-- Adjuster Email -->
      <div class="mt-4">
        <AppInputLabel for="insurance_adjuster_email">
          Adjuster Email
        </AppInputLabel>

        <AppInput
          id="insurance_adjuster_email"
          v-model="form.adjuster.email"
          type="email"
          class="w-full mt-2"
          name="insurance_adjuster_email"
        />

        <AppInputError
          :message="errors?.adjuster?.email"
          class="mt-2"
        />
      </div>

      <!-- Adjuster Phone -->
      <div class="mt-4">
        <AppInputLabel for="insurance_adjuster_phone">
          Adjuster Phone
        </AppInputLabel>

        <AppInput
          id="insurance_adjuster_phone"
          v-model="form.adjuster.phone"
          type="text"
          class="w-full mt-2"
          name="insurance_adjuster_phone"
        />

        <AppInputError
          :message="errors?.adjuster?.phone"
          class="mt-2"
        />
      </div>
    </section>
  </div>
</template>

<style scoped>
  .autoComplete_wrapper {
    width: 100% !important;
    display: flex !important;
  }

  .autoComplete_wrapper input {
    width: 100%;
  }
</style>
