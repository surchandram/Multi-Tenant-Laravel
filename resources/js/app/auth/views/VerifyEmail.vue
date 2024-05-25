<script>
  export default {
    pageLayout: "guest",
  };
</script>

<script setup>
  import { computed } from "vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AuthSessionStatus from "@/components/AuthSessionStatus.vue";

  const props = defineProps({
    status: String,
  });

  const form = useForm({});

  const submit = () => {
    form.post(route("verification.send"));
  };

  const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
  );
</script>

<template>
  <Head title="Email Verification" />

  <!-- Section -->
  <section class="w-full h-full py-24 relative">
    <div
      class=" absolute top-0 w-full h-full bg-gray-900"
      style="background-size: 100%; background-repeat: no-repeat;"
      :style="{ backgroundImage: `url('/assets/img/register_bg_2.png')` }"
    ></div>
  
    <div class="container h-full mx-auto px-4">
      <div class="flex flex-col items-center justify-center">
        <div class="w-full lg:w-6/12 px-4 relative">
          <!-- Application Mark -->
          <div class="flex items-center px-4 mb-6">
            <Link :href="route('dashboard')" class="p-2 focus:ring rounded-md">
              <div class="text-xl text-center text-white font-bold">
                <i class="bi bi-arrow-left"></i>
              </div>
            </Link>

            <div class="flex flex-wrap justify-self-stretch mx-auto">
              <Link :href="route('home')" class="mr-6">
                <div class="text-xl text-center text-white font-bold">
                  {{ $page.props.appName }}
                </div>
              </Link>
            </div>
          </div>
        </div>

        <!-- Form Section -->
        <div class="relative flex flex-col min-w-0 break-words w-full lg:w-6/12 mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
          <div class="p-6 text-slate-800">
            <div>
              Thanks for signing up! Before getting started, could you verify
              your email address by clicking on the link we just emailed to you?
              If you didn't receive the email, we will gladly send you another.
            </div>

            <AuthSessionStatus
              v-if="$page.props.flash.status == 'verification-link-sent'" class="mt-4"
            >
              A new verification link has been sent to the email address you
              provided during registration.
            </AuthSessionStatus>
          </div>

          <div class="px-6 mt-2 flex items-center justify-between">
            <form action="#" @submit.prevent="submit">
              <div>
                <button
                  type="submit"
                  data-mdb-ripple="true"
                  data-mdb-ripple-color="light"
                  class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    px-6
                    py-2.5
                    mb-6
                    w-full
                    px-6
                    py-2.5
                    bg-slate-800
                    text-white
                    font-medium
                    text-xs
                    leading-tight
                    uppercase
                    rounded
                    shadow-md
                    hover:bg-slate-700 hover:shadow-lg
                    focus:bg-slate-700 focus:shadow-lg focus:outline-none focus:ring-0
                    active:bg-slate-800 active:shadow-lg
                    transition
                    duration-150
                    ease-in-out
                    disabled:opacity-25
                  "
                >
                  Resend Verification Email
                </button>
              </div>
            </form>

            <!-- Logout button -->
            <div>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                class="
                  inline-flex
                  items-center
                  justify-center
                  gap-2
                  px-6
                  py-2.5
                  mb-6
                  w-full
                  px-6
                  py-2.5
                  bg-white
                  text-slate-700
                  font-medium
                  text-xs
                  leading-tight
                  uppercase
                  rounded
                  shadow-md
                  hover:bg-slate-200 hover:shadow-lg
                  focus:bg-slate-200 focus:shadow-lg focus:outline-none focus:ring-0
                  active:bg-slate-200 active:shadow-lg
                  transition
                  duration-150
                  ease-in-out
                  disabled:opacity-25
                "
              >
                Log Out
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Section -->
</template>
