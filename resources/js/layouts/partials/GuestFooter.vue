<script setup>
  import { ref, onMounted, watch } from "vue";
  import { Link } from "@inertiajs/vue3";

  const mobileSidebarOpen = ref(false);
  const sidebarMinimized = ref(false);

  const date = new Date();
  const fullYear = date.getFullYear();

  onMounted(() => {
    watch(mobileSidebarOpen, (val) => {
      $eventBus.emit("mobile-sidebar-toggled", val);
    });

    $eventBus.on(
      "mobile-sidebar-toggled",
      (val) => (mobileSidebarOpen.value = val)
    );
    $eventBus.on("sidebar-minimized", (val) => (sidebarMinimized.value = val));
  });
</script>

<template>
  <footer id="page-footer" class="flex items-center border-t grow-0 border-slate-100">
    <div
      class="container flex flex-col px-4 py-6 mx-auto space-y-2 text-sm font-medium text-center text-slate-600 md:flex-row md:justify-between md:space-y-0 md:text-left lg:px-8 xl:max-w-7xl"
    >
      <div>
        © {{ fullYear }}
        <span class="font-semibold">{{ $page.props.appName }}</span>
      </div>
      <div class="inline-flex items-center justify-center">
        <Link
          class="font-medium text-blue-600 transition hover:text-blue-700"
          :href="route('home')"
          target="_blank"
        >{{ $page.props.appName }}</Link>
      </div>
    </div>
  </footer>
</template>
