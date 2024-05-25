<script>
  export default {
    pageLayout: "account",
  };
</script>

<script setup>
  import { computed, onMounted, ref } from "vue";
  import { Head, router, useForm } from "@inertiajs/vue3";
  import AppButton from "@/components/AppButton.vue";
  import AppInput from "@/components/AppInput.vue";
  import AppInputError from "@/components/AppInputError.vue";
  import AppInputLabel from "@/components/AppInputLabel.vue";
  import AppSpinner from "@/components/AppSpinner.vue";
  import AppValidationErrors from "@/components/AppValidationErrors.vue";
  import { AsYouType } from "libphonenumber-js";
  import { trim } from "lodash";
  import axios from "axios";
  import { useToast } from "vue-toastification";

  defineProps(["model"]);

  const qrCode = ref(null);
  const recoveryCodes = ref([]);

  const form = useForm({
    phone_number: "",
    dial_code: "",
  });

  const toast = useToast();

  const formattedPhone = computed(() =>
    form.phone_number
      ? new AsYouType().input(
          "+" + form.dial_code + " " + trim(form.phone_number, "+")
        )
      : ""
  );

  const enable2fa = () => {
    axios
      .post(route("two-factor.enable"))
      .then(() => {
        router.get(route("account.twofactor.index"));
      })
      .catch((error) => {
        if (error.response.status === 423) {
          router.get(route("password.confirm"));
        }
      });
  };

  const disable2fa = () => {
    router.delete(
      route("two-factor.disable"),
      {},
      {
        onSuccess: () => {
          router.get(route("account.twofactor.index"));
        },
      }
    );
  };

  const enableAuthy2fa = () => {
    form.post(route("twofactor.store"), {
      onSuccess: () => {
        form.reset();
      },
      onError: () => {
        form.reset("dial_code");
      },
    });
  };

  const fetchQrCode = () => {
    axios
      .get(route("two-factor.qr-code"))
      .then((response) => {
        qrCode.value = response.data.svg;
      })
      .catch((error) => {
        if (error.response.status === 423) {
          router.get(route("password.confirm"));
        }
      });
  };

  const fetchRecoveryCodes = () => {
    axios
      .get(route("two-factor.recovery-codes"))
      .then((response) => {
        recoveryCodes.value = response.data;
      })
      .catch((error) => {
        if (error.response.status === 423) {
          router.get(route("password.confirm"));
        }
      });
  };

  const confirmQrCodeForm = useForm({
    code: "",
  });

  const confirm2fa = () => {
    confirmQrCodeForm.post(route("two-factor.confirm"), {
      onSuccess: () => {
        router.get(route("account.twofactor.index"));
      },
    });
  };

  onMounted(() => {
    fetchQrCode();
  });
</script>

<template>
  <Head :title="__('app.labels.2fa')" />

  <div class="p-7 rounded-md shadow-sm bg-white space-y-6">
    <!-- Disable 2FA Section -->
    <template v-if="$page.props.auth.user.two_factor_enabled">
      <h3 class="text-lg text-slate-600 font-medium">{{ __('app.labels.2fa') }}</h3>

      <AppButton theme="danger" @click="disable2fa">{{ __('app.labels.2fa_disable') }}</AppButton>

      <hr class="border-slate-200" />

      <h3 class="text-lg text-slate-600 font-medium">{{ __('app.labels.recovery_codes') }}</h3>

      <AppButton
        v-if="!recoveryCodes.length"
        theme="info"
        @click="fetchRecoveryCodes"
      >{{ __('app.labels.show_recovery_codes') }}</AppButton>

      <div v-else class="p-2 space-y-3 rounded bg-slate-100 text-sm font-medium">
        <p v-for="recoveryCode in recoveryCodes" :key="recoveryCode">{{ recoveryCode }}</p>
      </div>
    </template>
    <!-- END Disable 2FA Section -->

    <!-- QR Code 2FA Section -->
    <template v-else>
      <h3 class="text-lg text-slate-600 font-medium">{{ __('app.labels.2fa_setup') }}</h3>

      <!-- Confirm 2FA Form -->
      <form v-if="qrCode" class="space-y-6" action="#" @submit.prevent="confirm2fa">
        <p class="block text-slate-500">{{ __('app.labels.2fa_qrcode_setup_prompt') }}</p>

        <div class="max-h-64" v-html="qrCode"></div>

        <div class="space-y-3">
          <AppInputLabel for="qr_code" class="dark:text-white">{{ __('app.labels.code') }}</AppInputLabel>

          <AppInput
            id="qr_code"
            v-model="confirmQrCodeForm.code"
            type="text"
            name="qr_code"
            placeholder
            class="py-2"
          />

          <AppInputError
            class="mt-2"
            :message="confirmQrCodeForm.errors.confirmTwoFactorAuthentication?.code"
          />
        </div>

        <div>
          <AppButton type="submit" theme="success">{{ __('app.labels.confirm') }}</AppButton>
        </div>
      </form>
      <!-- END Confirm 2FA Form -->

      <div v-else>
        <AppButton theme="outline-success" @click="enable2fa">{{ __('app.labels.2fa_enable') }}</AppButton>
      </div>
    </template>
    <!-- END QR Code 2FA Section -->

    <!-- Authy 2FA Section -->
    <template v-if="model.authy_enabled && !$page.props.auth.user.two_factor_enabled">
      <hr class="border-slate-300" />

      <h3 class="text-lg text-slate-600 font-medium">{{ __('app.labels.2fa_authy') }}</h3>

      <form action="#" @submit.prevent="enableAuthy2fa">
        <AppValidationErrors v-if="form.hasErrors" :errors="form.errors" class="mb-4" />

        <div class="mt-6 space-y-3">
          <AppInputLabel
            for="phone_number"
            class="block mb-2 dark:text-white"
          >{{ __('app.labels.phone') }}</AppInputLabel>

          <!-- Phone Number Input -->
          <div class="flex items-center gap-1">
            <!-- Dial Code -->
            <div class="w-80">
              <select
                id="dial_code"
                v-model="form.dial_code"
                v-choicesjs
                name="dial_code"
                class="w-full"
              >
                <option value></option>
                <option
                  v-for="country in model.countries"
                  :key="country.id"
                  :value="country.dial_code"
                >({{ country.dial_code }}) ({{ country.name }})</option>
              </select>
            </div>
            <!-- END Dial Code -->

            <AppInput
              id="phone"
              v-model="form.phone_number"
              type="text"
              name="phone"
              placeholder
              class="rounded-l-none py-2"
            />
          </div>
          <!-- END Phone Number Input -->

          <AppInputLabel class="block mt-2 dark:text-white">{{ formattedPhone }}</AppInputLabel>

          <AppInputError class="mt-2" :message="form.errors.phone_number" />
        </div>

        <div class="flex items-center justify-end mt-6">
          <AppButton
            type="submit"
            class="inline-flex items-center gap-3"
            :disabled="form.processing"
          >
            <AppSpinner v-if="form.processing" :size="4" />
            {{ __('app.labels.2fa_enable') }}
          </AppButton>
        </div>
      </form>
    </template>
    <!-- END Authy 2FA Section -->
  </div>
</template>
