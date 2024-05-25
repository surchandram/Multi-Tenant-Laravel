<script setup>
  import { onMounted, ref } from "vue";
  import tippy from "tippy.js";

  const props = defineProps({
    role: {
      required: true,
      type: Object,
    },
    editShareable: {
      default: false,
      type: Boolean,
    },
  });

  const emit = defineEmits(["edit"]);

  const permissionsRef = ref(null);

  onMounted(() => {
    if (props.role.permissions?.length > 0) {
      const data = props.role.permissions.map(function (permission) {
        return `<li>${permission.name}</li>`;
      });

      tippy(permissionsRef.value, {
        content:
          '<ul class="flex flex-col space-y-1 font-medium">' +
          data.join("") +
          "</ul>",
        allowHTML: true,
        theme: "light",
        interactive: true,
      });
    }
  });
</script>

<template>
  <div
    class="px-4 py-3 space-y-2 text-sm font-medium bg-slate-50 first:rounded-t-md last:rounded-b-md"
  >
    <div class="flex items-center justify-between py-3">
      <p class="inline-flex items-center text-sm font-semibold leading-none text-slate-600">
        <span ref="permissionsRef">{{ role.name }}</span>
        <template v-if="role.is_shared">
          <span
            class="px-2 py-1 ml-2 rounded-full bg-indigo-300 text-xs"
          >{{ __('app.labels.default') }}</span>
        </template>
      </p>

      <aside class="inline-flex items-center">
        <a
          v-if="!role.is_shared"
          href="#"
          class="py-2 px-2 border border-transparent rounded-md font-semibold tracking-widest text-white text-sm shadow-sm bg-blue-600 hover:bg-blue-700 focus:bg-blue-900 transition duration-100 ease-in-out"
          @click.prevent="emit('edit', role)"
        >{{ __('app.labels.edit') }}</a>
      </aside>
    </div>

    <div class="py-2">
      <span
        class="px-2 py-1 rounded-full text-xs leading-none font-semibold text-white"
        :class="[role.usable ? 'bg-teal-600' : 'bg-rose-600']"
      >{{ role.usable ? __('app.labels.active') : __('app.labels.disabled') }}</span>
    </div>
  </div>
</template>
