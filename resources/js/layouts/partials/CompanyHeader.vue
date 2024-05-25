<script setup>
  import { ref, onMounted, watch } from 'vue';
  import { Link } from '@inertiajs/vue3';
  import AccountNotifications from '@/components/notifications/AccountNotifications.vue'
  import AccountDropdown from '@/components/account/AccountDropdown.vue';
  import AppColorModeSwitcher from '@/components/AppColorModeSwitcher.vue';
  import LucideIcon from '@/components/LucideIcon.vue';
  import { Button } from '@/components/ui/button';

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);

  onMounted(() => {
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit('mobile-sidebar-toggled', val);
    });

    $eventBus.on('mobile-sidebar-toggled', (val) => (mobileSidebarOpen.value = val));
    $eventBus.on('sidebar-minimized', (val) => (sidebarMinimized.value = val));
  });
</script>

<template>
  <header
    id="page-header"
    class="flex items-center flex-none h-20 lg:mb-8 bg-slate-100 lg:bg-slate-50 dark:bg-primary-foreground"
  >
    <div class="container flex justify-between px-4 mx-auto lg:px-8 xl:max-w-7xl">
      <!-- Left Section -->
      <div class="flex items-center space-x-2">
        <!-- Toggle Sidebar on Mobile -->
        <Button
          variant="ghost"
          class="lg:hidden gap-2"
          @click="$eventBus.emit('expand-sidebar')"
        >
          <LucideIcon name="menu" />
        </Button>
        <!-- END Toggle Sidebar on Mobile -->
      </div>
      <!-- END Left Section -->

      <!-- Middle Section -->
      <div class="flex items-center lg:mr-auto space-x-2">
        <!-- Brand -->
        <component
          :is="!route().current('tenant.*') ? 'a' : Link"
          :href="
            route().current('tenant.*') ? route('tenant.home') : route('tenant.switch', { tenant: $page.props.tenant })
          "
          class="inline-flex lg:hidden items-center space-x-2 text-lg font-bold tracking-wide transition text-slate-800 hover:opacity-75 active:opacity-100"
        >
          <img
            :src="$page.props.tenant.logo"
            alt
            class="w-16 h-16"
          />
        </component>
        <!-- END Brand -->
      </div>
      <!-- END Middle Section -->

      <!-- Right Section -->
      <div class="flex items-center space-x-2">
        <AccountNotifications size="icon"/>

        <!-- Dark Mode Switcher -->
        <div class="mx-4 relative">
          <AppColorModeSwitcher size="icon" />
        </div>
        <!-- END Dark Mode Switcher -->

        <!-- Settings -->
        <AccountDropdown
          native
          hide-small
          right
          class="z-[60]"
        />
        <!-- END Toggle Sidebar on Mobile -->
      </div>
      <!-- END Right Section -->
    </div>
  </header>
</template>
