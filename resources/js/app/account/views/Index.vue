<script>
  export default {
    pageLayout: 'account',
  };
</script>

<script setup>
  import { Head } from '@inertiajs/vue3';
  import { useMomentJS } from '@/composables/momentjs';

  const { dateFormat } = useMomentJS();
</script>

<template>
  <div class="p-7 rounded-md shadow bg-white dark:bg-slate-900 dark:text-secondary-foreground">
    <h3 class="mb-6 text-slate-600 dark:text-primary font-medium">Account Overview</h3>

    <div class="py-2 space-y-4">
      <!-- Name -->
      <div class="flex flex-col md:flex-row gap-3">
        <img
          :src="$page.props.auth.user.avatar"
          alt=""
          class="w-12 h-12 rounded-full"
        />

        <div class="space-y-2">
          <div class="text-sm text-slate-500 font-semibold">{{ __('app.labels.name') }}</div>
          <div class="font-medium">{{ $page.props.auth.user.name }}</div>
        </div>
      </div>
      <!-- END Name -->

      <!-- Username -->
      <div class="space-y-2">
        <div class="text-sm text-slate-500 font-semibold">{{ __('app.labels.username') }}</div>
        <div class="font-medium">{{ $page.props.auth.user.username }}</div>
      </div>
      <!-- END Username -->

      <!-- Email -->
      <div class="space-y-2">
        <div class="text-sm text-slate-500 font-semibold">{{ __('app.labels.email') }}</div>
        <div class="font-medium">{{ $page.props.auth.user.email }}</div>
      </div>
      <!-- END Email -->

      <!-- Phone -->
      <div
        v-if="$page.props.auth.user.phone"
        class="space-y-2"
      >
        <div class="text-sm text-slate-500 font-semibold">{{ __('app.labels.phone') }}</div>
        <div class="font-medium">{{ $page.props.auth.user.phone }}</div>
      </div>
      <!-- END Phone -->

      <!-- Joined date -->
      <div class="space-y-2">
        <div class="text-sm text-slate-500 font-semibold">{{ __('app.labels.joined_on') }}</div>
        <div class="font-medium">{{ dateFormat($page.props.auth.user.created_at, 'MMM Do, YYYY') }}</div>
      </div>
      <!-- END Joined date -->
    </div>
  </div>
</template>
