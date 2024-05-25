<script setup>
  import { computed } from 'vue';
  import { Link, usePage } from '@inertiajs/vue3';
  import ApplicationMark from '@/components/ApplicationMark.vue';
  import DropdownHeader from '@/components/DropdownHeader.vue';
  import DropdownMenu from '@/components/DropdownMenu.vue';
  import NavbarDropdown from '@/components/NavbarDropdown.vue';
  import DropdownLink from '@/components/DropdownLink.vue';
  import DropdownDivider from '@/components/DropdownDivider.vue';
  import NavbarMegaMenu from '@/components/NavbarMegaMenu.vue';
  import PersonIcon from '@/components/PersonIcon.vue';

  const chunkedApps = computed(() => {
    return _.chunk(usePage().props.apps, 3);
  });
</script>
<template>
	<nav
    x-data="{ show: false }"
    class="navbar navbar-expand-lg shadow-md py-2 bg-white relative flex items-center w-full justify-between">
    <div class="px-6 w-full flex flex-wrap items-center justify-between">
      <!-- Navbar Logo -->
      <div class="flex items-center gap-2 mr-2">
        <button
          class="navbar-toggler border-0 py-3 lg:hidden leading-none text-xl bg-transparent text-gray-600 hover:text-gray-700 focus:text-gray-700 transition-shadow duration-150 ease-in-out mr-2"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContentY"
          aria-controls="navbarSupportedContentY"
          aria-expanded="false"
          aria-label="Toggle navigation"
          x-on:click="show = ! show"
        >
          <svg
            aria-hidden="true"
            focusable="false"
            data-prefix="fas"
            class="w-5"
            role="img"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
          >
            <path
              fill="currentColor"
              d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"
            ></path>
          </svg>
        </button>
        <a
class="navbar-brand flex items-center gap-1 text-blue-600 font-semibold mr-2"
          :href="route('home')"
        >
          <ApplicationMark />
          {{ $page.props.appName }}
        </a>
      </div>

      <!-- Navbar Collapse -->
      <div id="navbarSupportedContentY" class="navbar-collapse collapse grow items-center">
        <!-- Navbar Left -->
        <ul class="navbar-nav mr-auto lg:flex lg:flex-row gap-2">
          <!-- Pricing -->
          <li class="nav-item">
            <a class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out" :href="route('plans.index')" data-mdb-ripple="true" data-mdb-ripple-color="light">Pricing</a>
          </li>

          <!-- Blade Version -->
          <li class="nav-item mb-2 lg:mb-0">
            <a class="nav-link flex items-center gap-1 pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out" href="https://saasprodemo.saasplayground.store/" data-mdb-ripple="true" data-mdb-ripple-color="light">
              Blade Version
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
              </svg>
            </a>
          </li>
        </ul>

        <!-- Navbar Right -->
        <ul
          class="navbar-nav lg:flex lg:items-center lg:flex-row gap-2 mb-2 md:mb-0"
        >
          <!-- Support -->
          <li class="nav-item">
            <NavbarDropdown content-classes="md:w-48" label="Support">
              <!-- New ticket -->
              <li>
                <DropdownLink
                  class=""
                  :href="route('support.tickets.create')"
                >
                  Open Ticket
                </DropdownLink>
              </li>

              <!-- User's tickets index -->
              <li>
                <DropdownLink
                  class=""
                  :href="route('support.tickets.index')"
                >
                  My Tickets
                </DropdownLink>
              </li>

              <DropdownDivider />
              
              <DropdownHeader label="More Resources" />

              <!-- Docs link -->
              <li>
                <DropdownLink
                  :href="route('docs.index')"
                  class=""
                  target="_blank"
                >
                  Documentation
                </DropdownLink>
              </li>
            </NavbarDropdown>
          </li>

          <!-- Auth Links -->
          <template v-if="$page.props.auth.loggedIn">
            <!-- Teams Dropdown -->
            <li class="nav-item">
              <a
                class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                :href="route('teams.index')"
              >
                Teams
              </a>
            </li>

            <!-- Dashboard -->
            <li class="nav-item">
              <a
                class="nav-link block pr-2 lg:px-2 py-2 text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out"
                :href="route('dashboard')" data-mdb-ripple="true"
                data-mdb-ripple-color="light"
              >
                Dashboard
              </a>
            </li>

            <!-- Account Dropdown -->
            <li class="flex items-center relative mb-2 lg:mb-0">
              <NavbarDropdown
                id="dropdownMenuAccount"
                :content-class="['left-auto', 'right-0', 'md:w-48']"
              >
                <template #trigger>
                  <button
                    id="dropdownMenuAccount"
                    type="button"
                    class="dropdown-toggle flex items-center hidden-arrow"
                    role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"
                  >
                    <PersonIcon />
                    <!-- <img src="https://mdbootstrap.com/img/new/avatars/2.jpg" class="rounded-full"style="height: 25px; width: 25px" alt="" loading="lazy" /> -->
                  </button>
                </template>
                
                <DropdownHeader :label="`Hi, ${$page.props.auth.user.first_name}`" />
                
                <li>
                  <DropdownLink
                    :href="route('account.index')"
                  >Account</DropdownLink>
                </li>
                
                <li>
                  <DropdownLink
                    :href="route('account.addresses.index')"
                  >My Addresses</DropdownLink>
                </li>
                
                <li v-permission="'browse admin'">
                  <DropdownLink
                    :href="route('admin.dashboard')"
                  >Admin Panel</DropdownLink>
                </li>

                <!-- Logout form / link -->
                <li x-data="">
                  <form x-ref="logoutForm" method="POST" :action="route('logout')">
                    <a
                      class="
                        dropdown-item
                        text-sm
                        py-2
                        px-4
                        font-normal
                        block
                        w-full
                        whitespace-nowrap
                        bg-transparent
                        text-gray-700
                        hover:bg-gray-100
                      "
                      x-on:click.prevent="$refs.logoutForm.submit()"
                    >Logout</a>
                  </form>
                </li>
              </NavbarDropdown><!-- /.dropdown -->
            </li>
          </template>
        </ul>
      </div>

      <!-- Auth links -->
      <template v-if="!$page.props.auth.loggedIn">
        <div class="flex items-center gap-2 lg:ml-auto">
          <!-- Login -->
          <Link
            :href="route('login')"
            class="h-full inline-flex px-6 py-4 mr-2 bg-transparent text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:text-blue-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring-0 active:bg-gray-200 transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light">
            Login
          </Link>
          <!-- Register -->
          <Link
            :href="route('register')"
            class="h-full inline-flex px-6 py-4 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light">
            Get Started
          </Link>
        </div>
      </template>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'AppNavigation'
};
</script>

<style lang="css" scoped>
</style>
