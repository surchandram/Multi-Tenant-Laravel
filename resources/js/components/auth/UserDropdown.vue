<script setup>
  import { ref } from "vue";
  import { Link } from "@inertiajs/vue3";
  import { createPopper } from "@popperjs/core";
  import DropdownDivider from "./DropdownDivider.vue";
  import DropdownHeader from "./DropdownHeader.vue";
  import DropdownLink from "./DropdownLink.vue";

  const dropdownPopoverShow = ref(false);

  const btnDropdownRef = ref(null);
  const popoverDropdownRef = ref(null);

  const toggleDropdown = function(event) {
    event.preventDefault();

    if (dropdownPopoverShow.value) {
      dropdownPopoverShow.value = false;
    } else {
      dropdownPopoverShow.value = true;

      createPopper(btnDropdownRef.value, popoverDropdownRef.value, {
        placement: "bottom-end"
      });
    }
  };
</script>

<template>
  <div>
    <!-- DropdownToggler -->
    <a
      class="text-slate-500 block"
      href="#"
      v-on:click.prevent="toggleDropdown($event)"
      ref="btnDropdownRef"
    >
      <div class="items-center flex">
        <span
          class="w-12 h-12 text-sm text-white bg-slate-800 inline-flex items-center justify-center rounded-full"
        >
          <img
            v-if="$page.props.auth.user.avatar"
            alt="..."
            class="w-full rounded-full align-middle border-none shadow-lg"
            src="/assets/img/team-1-800x800.jpg"
          />
          <span v-else class="text-xl text-slate-200">
            <i class="bi bi-person-circle"></i>
          </span>
        </span>
      </div>
    </a>
    <!-- /DropdownToggler -->

    <!-- DropdownMenu -->
    <div
      ref="popoverDropdownRef"
      class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
      v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow
      }"
      style="min-width: 12rem"
      @click.outside="dropdownPopoverShow = false"
    >
      <DropdownHeader>
        <span class="text-black">Logged in as&colon;</span>
        <br>
        {{ $page.props.auth.user.name }}
        <br>
        <span class="text-xs text-slate-600">
          ({{ $page.props.auth.user.email }})
        </span>
      </DropdownHeader>

      <DropdownLink
        v-if="$page.props.auth.impersonating"
        method="delete"
        :href="route('admin.users.impersonate.destroy')"
      >
        Stop Impersonating
      </DropdownLink>

      <DropdownLink
        v-permission="'browse admin'"
        native
        :href="route('admin.dashboard')"
      >
        Admin Dashboard
      </DropdownLink>

      <DropdownLink native :href="route('account.index')">
        Account
      </DropdownLink>

      <DropdownLink native :href="route('account.profile.index')">
        Update Profile
      </DropdownLink>

      <DropdownLink native :href="route('companies.index')">
        Companies
      </DropdownLink>

      <DropdownLink native :href="route('account.addresses.index')">
        Addresses
      </DropdownLink>

      <DropdownDivider />

      <DropdownLink
        method="post"
        as="button"
        :href="route('logout')"
        class="text-left"
      >
        <i class="bi bi-box-arrow-right mr-2 text-xl"></i> Logout
      </DropdownLink>
    </div>
    <!-- /DropdownMenu -->
  </div>
</template>
