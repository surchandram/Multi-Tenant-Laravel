<template>
  <!-- Page Footer -->
  <footer id="page-footer" class="flex grow-0 items-center border-t border-slate-100">
    <div
      class="container mx-auto flex flex-col space-y-2 px-4 py-6 text-center text-sm font-medium text-slate-600 md:flex-row md:justify-between md:space-y-0 md:text-left lg:px-8 xl:max-w-7xl"
    >
      <div>
        ©
        <span class="font-semibold">{{ $page.props.appName }}</span>
      </div>
      <div class="inline-flex items-center justify-center"></div>
    </div>
  </footer>
  <!-- END Page Footer -->
</template>
