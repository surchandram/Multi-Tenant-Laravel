<header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1 dark:bg-boxdark dark:drop-shadow-none">
  <div class="flex flex-grow items-center justify-between py-4 px-4 shadow-2 md:px-6 2xl:px-11">
    <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
      <!-- Hamburger Toggle BTN -->
      <x-sidebar-toggler />
    </div>
    <div class="hidden sm:block">
      <x-header-search-form />
    </div>

    <div class="flex items-center gap-3 2xsm:gap-7">
      <ul class="flex items-center gap-2 2xsm:gap-4">
        <li>
          <!-- Dark Mode Toggler -->
          <x-dark-mode-toggler />
          <!-- Dark Mode Toggler -->
        </li>

        <!-- Notification Menu Area -->
        @if(setting('in_app_notifications', false))
          <x-header-notification-dropdown />
        @endif
        <!-- Notification Menu Area -->

        <!-- Chat Notification Area -->
        @if(setting('chat.enabled', false))
          <x-header-chat-dropdown />
        @endif
        <!-- Chat Notification Area -->
      </ul>

      <!-- User Area -->
      <x-header-user-dropdown />
      <!-- User Area -->
    </div>
  </div>
</header>