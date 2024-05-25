<button
    class="z-99999 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden"
    @click.stop="sidebarToggle = !sidebarToggle"
>
    <span class="relative block h-5.5 w-5.5 cursor-pointer">
      <span class="du-block absolute right-0 h-full w-full">
        <span
          class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out dark:bg-white"
          :class="{ '!w-full delay-300': !sidebarToggle }"></span>
        <span
          class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white"
          :class="{ '!w-full delay-400': !sidebarToggle }"></span>
        <span
          class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white"
          :class="{ '!w-full delay-500': !sidebarToggle }"></span>
      </span>
      <span class="du-block absolute right-0 h-full w-full rotate-45">
        <span
          class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out dark:bg-white"
          :class="{ 'h-0 delay-[0]': !sidebarToggle }"></span>
        <span
          class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out dark:bg-white"
          :class="{ 'h-0 dealy-200': !sidebarToggle }"></span>
      </span>
    </span>
</button>
<!-- Hamburger Toggle BTN -->
<a class="block flex-shrink-0 lg:hidden" href="{{ route('home') }}">
    <img src="{{ asset('images/logo/logo-icon.svg') }}" alt="Logo" />
</a>
