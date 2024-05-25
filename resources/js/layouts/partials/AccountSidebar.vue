<script setup>
  import { ref, watch, onMounted } from 'vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import { Link, router } from '@inertiajs/vue3';
  import { vOnClickOutside } from '@vueuse/components';
  import AccountSidebarLink from '../../components/account/AccountSidebarLink.vue';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { Button } from '@/components/ui/button';

  const openMobile = ref(false);

  const emit = defineEmits(['closed']);

  const showSidebar = () => {
    openMobile.value = true;
  };

  const hideSidebar = () => {
    openMobile.value = false;
  };

  onMounted(() => {
    watch(openMobile, (val) => {
      if (!val) {
        emit('closed');
      }
    });

    $eventBus.on('show-mobile-sidebar', () => {
      showSidebar();
    });

    router.on('start', () => {
      hideSidebar();
    });
  });
</script>

<template>
  <div
    v-on-click-outside="hideSidebar"
    class="w-full md:w-56 mb-8 md:mb-auto md:static z-50 md:z-auto top-0 left-0 transition ease-in duration-200"
  >
    <div class="md:rounded-md md:shadow bg-slate-50 dark:bg-slate-900">
      <div class="flex md:hidden items-center justify-between gap-12 px-4 py-2">
        <h4 class="font-medium">{{ __('app.labels.manage_account') }}</h4>

        <Button
          v-if="!openMobile"
          class="md:hidden"
          variant="icon"
          @click="showSidebar"
        >
          <LucideIcon
            name="menu"
            class="w-6 h-6"
          ></LucideIcon>
        </Button>

        <Button
          v-else
          class="md:hidden"
          variant="icon"
          @click="hideSidebar"
        >
          <LucideIcon
            name="x"
            class="w-6 h-6"
          />
        </Button>
      </div>

      <div
        :class="[openMobile ? '' : 'hidden md:block']"
        class="flex flex-col rounded-md dark:px-px"
      >
        <div class="py-px space-y-px rounded-t-md">
          <h4 class="md:hidden py-3 px-4 text-sm text-slate-500 font-medium">{{ __('app.labels.account') }}</h4>

          <!-- Account Overview -->
          <AccountSidebarLink
            :href="route('account.index')"
            active="account.index"
            class="first:rounded-t-md"
            >{{ __('app.labels.account_overview') }}</AccountSidebarLink
          >
          <!-- END Account Overview -->

          <!-- Profile -->
          <AccountSidebarLink
            :href="route('account.profile.index')"
            active="account.profile.index"
            >{{ __('app.labels.profile') }}</AccountSidebarLink
          >
          <!-- END Profile -->

          <!-- Update Password -->
          <AccountSidebarLink
            :href="route('account.password.index')"
            active="account.password.index"
            >{{ __('app.labels.update_password') }}</AccountSidebarLink
          >
          <!-- END Update Password -->

          <!-- Two Factor -->
          <AccountSidebarLink
            :href="route('account.twofactor.index')"
            active="account.twofactor.index"
            >{{ __('app.labels.2fa') }}</AccountSidebarLink
          >
          <!-- END Two Factor -->
        </div>

        <div class="py-px space-y-3">
          <AccountSidebarLink
            :href="route('account.deactivate.index')"
            active="account.deactivate.index"
            >{{ __('app.labels.deactivate_account') }}</AccountSidebarLink
          >
        </div>
      </div>
    </div>
  </div>
</template>
