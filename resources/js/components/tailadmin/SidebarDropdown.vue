<script setup>
  import { reactive, useAttrs } from 'vue';
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    href: String,
    active: String,
    plain: Boolean
  });

  const attrs = useAttrs();

  const uniqId = slugify(Date.now() + _ + _.random(99, 999, false), {
    replacement: '_'
  });

  const state = reactive({
    defaultStyles: "group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4",
    activeStyles: "bg-graydark dark:bg-meta-4",
    isActive: false
  });

  $eventBus.on('route::changed', () => {
    state.isActive = window.route().current(props.active)
  });
</script>

<template>
  <li
    x-data="{
      uniqId: '',
      route: '',
      isActive: false,
      toggle() {
        selected != this.uniqId ? (selected = this.uniqId) : (selected = '');
      },
      init() {
        setTimeout(() => {
          this.uniqId = $el.dataset.id;
          this.route = $el.dataset.route;
          if (this.route) {
            this.isActive = window.route().current($el.dataset.route);
          }

          if (this.isActive) {
            this.selected = this.uniqId;
          }
        }, 1000);

        $eventBus.on('route::changed', () => {
          if (this.route) {
            this.isActive = window.route().current($el.dataset.route);
          }
        });
      }
    }"
    :data-route="props.active"
    :data-id="uniqId"
  >
    <a
      href="#"
      class="sidebar-link group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 focus:outline-none"
      x-bind:class="{ 'bg-graydark dark:bg-meta-4': isActive ? true : selected == uniqId }"
      :data-id="uniqId"
      x-on:click.prevent="toggle"
    >
      <slot name="icon" />
      <slot name="label" />

      <svg
        class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
        x-bind:class="{ 'rotate-180': (selected === uniqId) }"
        width="20"
        height="20"
        viewBox="0 0 20 20"
        fill="none" xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
          fill=""
        />
      </svg>
    </a>

    <!-- Dropdown Menu Start -->
    <div
      class="overflow-hidden"
      x-bind:class="{ 'block': isActive ? true : selected == uniqId, 'hidden': !isActive && selected != uniqId }"
    >
      <ul class="sidebar-dropdown-menu mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
        <slot></slot>
      </ul>
    </div>
    <!-- Dropdown Menu End -->
  </li>
</template>