<script>
  export default {
    pageLayout: 'admin',
  };
</script>

<script setup>
  import { inject, computed } from 'vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import AppCheckbox from '@/components/AppCheckbox.vue';
  import AppInput from '@/components/AppInput.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppTextarea from '@/components/AppTextarea.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import AppButton from '@/components/AppButton.vue';
  import AppSpinner from '@/components/AppSpinner.vue';

  const props = defineProps(['model']);

  const form = useForm({
    name: props.model.plan.name,
    interval: props.model.plan.interval,
    description: props.model.plan.description,
    provider_id: props.model.plan.provider_id,
    price: props.model.plan.price,
    teams: props.model.plan.teams,
    per_seat: props.model.plan.per_seat,
    team_limit: props.model.plan.team_limit,
    usable: props.model.plan.usable,
  });

  const formattedPrice = computed(() => currencyFormatter(form.price, { fromCents: true }).format());

  const $scrollTo = inject('$scrollTo');

  const scrollTo = (el = 'body') => {
    $scrollTo(el, { container: 'main' });
  };

  const store = () => {
    form.clearErrors();
    scrollTo();

    form
      .transform((data) => ({
        ...data,
      }))
      .patch(route('admin.plans.update', props.model.plan), {
        //
      });
  };
</script>

<template>
  <Head title="Edit Billing Plan | Admin" />

  <div class="flex flex-col gap-10 relative">
    <!-- Heading Area -->
    <div class="w-full flex md:items-center justify-between px-6 mb-3">
      <!-- Heading -->
      <div class="mr-auto">
        <h1 class="text-slate-800 text-2xl font-hairline leading-tight">Edit Billing Plan</h1>

        <p>Only some fields are editable, to prevent affecting any subscribed users.</p>
      </div>

      <!-- Aside -->
      <div class="flex flex-col md:flex-row md:items-center gap-3">
        <div class="flex items-center gap-2">
          <!-- Actions -->
          <div class="inline-flex items-center">
            <!-- Save Button -->
            <div class="flex items-center justify-end lg:justify-start">
              <AppButton
                type="submit"
                class="inline-flex items-center gap-2"
                :disabled="form.processing"
                @click.prevent="store"
              >
                <AppSpinner
                  v-show="form.processing"
                  :size="4"
                />
                <i
                  v-show="!form.processing"
                  class="bi bi-check"
                ></i>
                Save
              </AppButton>
            </div>
          </div>
          <!-- /Actions -->
        </div>
      </div>
    </div>
    <!-- /Heading Area -->

    <!-- Content Area -->
    <div class="w-full min-w-full px-6 md:px-8 pb-6">
      <!-- Form -->
      <form
        action="#"
        @submit.prevent="store"
      >
        <AppValidationErrors :errors="form.errors" />

        <!-- Name -->
        <div class="mt-4">
          <AppInputLabel for="name">Name</AppInputLabel>

          <AppInput
            id="name"
            v-model="form.name"
            class="w-full mt-2"
            name="name"
            disabled
          />

          <AppInputError
            class="mt-2"
            :message="form.errors.name"
          />
        </div>

        <!-- Plan Interval -->
        <div class="mt-4">
          <AppInputLabel
            for="interval"
            class="block mb-2"
            >Plan Interval</AppInputLabel
          >

          <select
            id="interval"
            v-model="form.interval"
            v-choicesjs
            class="w-full mt-2"
            name="interval"
            disabled
          >
            <option value>Choose</option>
            <option
              v-for="(interval, key) in model.intervals"
              :key="key"
              :value="key"
            >
              {{ interval }}
            </option>
          </select>

          <AppInputError
            class="mt-2"
            :message="form.errors.interval"
          />
        </div>

        <!-- Provider Id -->
        <div class="mt-4">
          <AppInputLabel for="provider_id">Provider Id</AppInputLabel>

          <AppInput
            id="provider_id"
            v-model="form.provider_id"
            class="w-full mt-2"
            name="provider_id"
            disabled
          />

          <p class="text-sm font-semibold text-slate-500 mt-2">
            Provider id is used to identify the plan in your prefered payment provider.
          </p>

          <AppInputError
            class="mt-2"
            :message="form.errors.provider_id"
          />
        </div>

        <!-- Price -->
        <div class="mt-4">
          <AppInputLabel for="price">Price</AppInputLabel>

          <AppInput
            id="price"
            v-model.number="form.price"
            class="w-full mt-2"
            name="price"
            disabled
          />

          <p class="text-sm font-semibold text-slate-500 mt-2">
            The plan's price will be
            <span class="text-slate-700">{{ formattedPrice }}</span>
          </p>

          <AppInputError
            class="mt-2"
            :message="form.errors.price"
          />
        </div>

        <div class="mt-4">
          <AppInputLabel class="inline-flex items-center gap-2">
            <AppCheckbox
              v-model="form.teams"
              disabled
            />For Teams
          </AppInputLabel>

          <p class="text-sm font-semibold text-slate-500">Leave unchecked if it is a user plan</p>
        </div>

        <div class="mt-4">
          <AppInputLabel class="inline-flex items-center gap-2">
            <AppCheckbox
              v-model="form.per_seat"
              disabled
            />Per Seat
          </AppInputLabel>

          <p class="text-sm font-semibold text-slate-500">Charge subscription based on every user added.</p>
        </div>

        <!-- Team Limit -->
        <div
          v-if="form.teams && !form.per_seat"
          class="mt-4"
        >
          <AppInputLabel for="team_limit">Team Limit</AppInputLabel>

          <AppInput
            id="team_limit"
            v-model.number="form.team_limit"
            type="number"
            min="2"
            class="w-full mt-2"
            name="team_limit"
            disabled
          />

          <p class="text-sm font-semibold text-slate-600 mt-2">Only applies if plan is for teams</p>

          <AppInputError
            class="mt-2"
            :message="form.errors.price"
          />
        </div>

        <!-- Description -->
        <div class="mt-4">
          <AppInputLabel for="description">Description</AppInputLabel>

          <AppTextarea
            id="description"
            v-model="form.description"
            class="mt-2"
            placeholder="Brief details about the plan..."
            name="description"
          />

          <AppInputError
            class="mt-2"
            :message="form.errors.description"
          />
        </div>

        <div class="mt-4">
          <AppInputLabel class="inline-flex items-center gap-2">
            <AppCheckbox v-model="form.usable" />Active
          </AppInputLabel>
        </div>

        <div class="mt-4">
          <div class="flex items-baseline justify-end gap-3">
            <!-- Save Button -->
            <AppButton
              type="submit"
              class="flex items-center gap-2"
              :disabled="form.processing"
            >
              <AppSpinner
                v-show="form.processing"
                :size="4"
              />
              <i
                v-show="!form.processing"
                class="bi bi-check"
              ></i>
              Save
            </AppButton>
          </div>
        </div>
      </form>
      <!--/ Form -->
    </div>
    <!-- /Content Area -->
  </div>
</template>
