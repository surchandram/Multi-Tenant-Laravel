<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb Start -->
    <x-breadcrumb>
          Form Elements

          <x-slot name="items">
              <x-breadcrumb-item class="font-medium" href="home"></x-breadcrumb-item>
          </x-slot>
          <x-slot name="activeItem">Form Elements</x-slot>
    </x-breadcrumb>
    <!-- Breadcrumb End -->

    <!-- ====== Form Elements Section Start -->
    <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
      <div class="flex flex-col gap-9">
        <!-- Input Fields -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              Input Fields
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Default Input
              </label>
              <input type="text" placeholder="Default Input"
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Active Input
              </label>
              <input type="text" placeholder="Active Input"
                class="w-full rounded-lg border-[1.5px] border-primary bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:bg-form-input" />
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Disabled label
              </label>
              <input type="text" placeholder="Disabled label" disabled=""
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black" />
            </div>
          </div>
        </div>

        <!-- Toggle switch input -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              Toggle switch input
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div x-data="{ switcherToggle: false }">
              <label for="toggle1" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="toggle1" class="sr-only"
                    @change="switcherToggle = !switcherToggle" />
                  <div class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]"></div>
                  <div :class="switcherToggle && '!right-1 !translate-x-full !bg-primary dark:!bg-white'"
                    class="absolute left-1 top-1 h-6 w-6 rounded-full bg-white transition"></div>
                </div>
              </label>
            </div>

            <div x-data="{ switcherToggle: false }">
              <label for="toggle2" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input id="toggle2" type="checkbox" class="sr-only"
                    @change="switcherToggle = !switcherToggle" />
                  <div class="h-5 w-14 rounded-full bg-meta-9 shadow-inner dark:bg-[#5A616B]"></div>
                  <div :class="switcherToggle && '!right-0 !translate-x-full !bg-primary dark:!bg-white'"
                    class="dot absolute left-0 -top-1 h-7 w-7 rounded-full bg-white shadow-switch-1 transition">
                  </div>
                </div>
              </label>
            </div>

            <div x-data="{ switcherToggle: false }">
              <label for="toggle3" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="toggle3" class="sr-only"
                    @change="switcherToggle = !switcherToggle" />
                  <div class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]"></div>
                  <div :class="switcherToggle && '!right-1 !translate-x-full !bg-primary dark:!bg-white'"
                    class="dot absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition">
                    <span :class="switcherToggle && '!block'" class="hidden">
                      <svg width="11" height="8" viewBox="0 0 11 8" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M10.0915 0.951972L10.0867 0.946075L10.0813 0.940568C9.90076 0.753564 9.61034 0.753146 9.42927 0.939309L4.16201 6.22962L1.58507 3.63469C1.40401 3.44841 1.11351 3.44879 0.932892 3.63584C0.755703 3.81933 0.755703 4.10875 0.932892 4.29224L0.932878 4.29225L0.934851 4.29424L3.58046 6.95832C3.73676 7.11955 3.94983 7.2 4.1473 7.2C4.36196 7.2 4.55963 7.11773 4.71406 6.9584L10.0468 1.60234C10.2436 1.4199 10.2421 1.1339 10.0915 0.951972ZM4.2327 6.30081L4.2317 6.2998C4.23206 6.30015 4.23237 6.30049 4.23269 6.30082L4.2327 6.30081Z"
                          fill="white" stroke="white" stroke-width="0.4"></path>
                      </svg>
                    </span>
                    <span :class="switcherToggle && 'hidden'">
                      <svg class="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </span>
                  </div>
                </div>
              </label>
            </div>

            <div x-data="{ switcherToggle: false }">
              <label for="toggle4" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="toggle4" class="sr-only"
                    @change="switcherToggle = !switcherToggle" />
                  <div :class="switcherToggle && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black">
                  </div>
                  <div :class="switcherToggle && '!right-1 !translate-x-full'"
                    class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition">
                  </div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- Time and date -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              Time and date
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Date picker
              </label>
              <div class="relative">
                <input type="date"
                  class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />

                <span
                  class="absolute right-0.5 top-0.5 block rounded-tr rounded-br bg-white p-3.5 dark:bg-form-input">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M15.7504 2.9812H14.2879V2.36245C14.2879 2.02495 14.0066 1.71558 13.641 1.71558C13.2754 1.71558 12.9941 1.99683 12.9941 2.36245V2.9812H4.97852V2.36245C4.97852 2.02495 4.69727 1.71558 4.33164 1.71558C3.96602 1.71558 3.68477 1.99683 3.68477 2.36245V2.9812H2.25039C1.29414 2.9812 0.478516 3.7687 0.478516 4.75308V14.5406C0.478516 15.4968 1.26602 16.3125 2.25039 16.3125H15.7504C16.7066 16.3125 17.5223 15.525 17.5223 14.5406V4.72495C17.5223 3.7687 16.7066 2.9812 15.7504 2.9812ZM1.77227 8.21245H4.16289V10.9968H1.77227V8.21245ZM5.42852 8.21245H8.38164V10.9968H5.42852V8.21245ZM8.38164 12.2625V15.0187H5.42852V12.2625H8.38164V12.2625ZM9.64727 12.2625H12.6004V15.0187H9.64727V12.2625ZM9.64727 10.9968V8.21245H12.6004V10.9968H9.64727ZM13.8379 8.21245H16.2285V10.9968H13.8379V8.21245ZM2.25039 4.24683H3.71289V4.83745C3.71289 5.17495 3.99414 5.48433 4.35977 5.48433C4.72539 5.48433 5.00664 5.20308 5.00664 4.83745V4.24683H13.0504V4.83745C13.0504 5.17495 13.3316 5.48433 13.6973 5.48433C14.0629 5.48433 14.3441 5.20308 14.3441 4.83745V4.24683H15.7504C16.0316 4.24683 16.2566 4.47183 16.2566 4.75308V6.94683H1.77227V4.75308C1.77227 4.47183 1.96914 4.24683 2.25039 4.24683ZM1.77227 14.5125V12.2343H4.16289V14.9906H2.25039C1.96914 15.0187 1.77227 14.7937 1.77227 14.5125ZM15.7504 15.0187H13.8379V12.2625H16.2285V14.5406C16.2566 14.7937 16.0316 15.0187 15.7504 15.0187Z"
                      fill="#64748B" />
                  </svg>
                </span>
              </div>
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Select date
              </label>
              <div class="relative">
                <input type="date"
                  class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />

                <span
                  class="absolute right-0.5 top-0.5 block rounded-tr rounded-br bg-white p-3.5 dark:bg-form-input">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M9.0002 12.825C8.83145 12.825 8.69082 12.7688 8.5502 12.6563L2.08145 6.30002C1.82832 6.0469 1.82832 5.65315 2.08145 5.40002C2.33457 5.1469 2.72832 5.1469 2.98145 5.40002L9.0002 11.2781L15.0189 5.34377C15.2721 5.09065 15.6658 5.09065 15.9189 5.34377C16.1721 5.5969 16.1721 5.99065 15.9189 6.24377L9.45019 12.6C9.30957 12.7406 9.16895 12.825 9.0002 12.825Z"
                      fill="#64748B" />
                  </svg>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- File upload -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              File upload
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Attach file
              </label>
              <input type="file"
                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter dark:file:bg-white/30 dark:file:text-white file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:focus:border-primary" />
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Attach file
              </label>
              <input type="file"
                class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke dark:file:border-strokedark file:bg-[#EEEEEE] dark:file:bg-white/30 dark:file:text-white file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input" />
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-col gap-9">
        <!-- Textarea Fields -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              Textarea Fields
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Default textarea
              </label>
              <textarea rows="6" placeholder="Default textarea"
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"></textarea>
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Active textarea
              </label>
              <textarea rows="6" placeholder="Active textarea"
                class="w-full rounded-lg border-[1.5px] border-primary bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:bg-form-input"></textarea>
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Disabled textarea
              </label>
              <textarea rows="6" disabled="" placeholder="Disabled textarea"
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black"></textarea>
            </div>
          </div>
        </div>

        <!-- Checkbox and radio -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              Checkbox and radio
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div x-data="{ checkboxToggle: false }">
              <label for="checkboxLabelOne" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="checkboxLabelOne" class="sr-only"
                    @change="checkboxToggle = !checkboxToggle" />
                  <div :class="checkboxToggle && 'border-primary bg-gray dark:bg-transparent'"
                    class="mr-4 flex h-5 w-5 items-center justify-center rounded border">
                    <span :class="checkboxToggle && 'bg-primary'" class="h-2.5 w-2.5 rounded-sm"></span>
                  </div>
                </div>
                Checkbox Text
              </label>
            </div>

            <div x-data="{ checkboxToggle: false }">
              <label for="checkboxLabelTwo" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="checkboxLabelTwo" class="sr-only"
                    @change="checkboxToggle = !checkboxToggle" />
                  <div :class="checkboxToggle && 'border-primary bg-gray dark:bg-transparent'"
                    class="mr-4 flex h-5 w-5 items-center justify-center rounded border">
                    <span :class="checkboxToggle && '!opacity-100'" class="opacity-0">
                      <svg width="11" height="8" viewBox="0 0 11 8" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M10.0915 0.951972L10.0867 0.946075L10.0813 0.940568C9.90076 0.753564 9.61034 0.753146 9.42927 0.939309L4.16201 6.22962L1.58507 3.63469C1.40401 3.44841 1.11351 3.44879 0.932892 3.63584C0.755703 3.81933 0.755703 4.10875 0.932892 4.29224L0.932878 4.29225L0.934851 4.29424L3.58046 6.95832C3.73676 7.11955 3.94983 7.2 4.1473 7.2C4.36196 7.2 4.55963 7.11773 4.71406 6.9584L10.0468 1.60234C10.2436 1.4199 10.2421 1.1339 10.0915 0.951972ZM4.2327 6.30081L4.2317 6.2998C4.23206 6.30015 4.23237 6.30049 4.23269 6.30082L4.2327 6.30081Z"
                          fill="#3056D3" stroke="#3056D3" stroke-width="0.4"></path>
                      </svg>
                    </span>
                  </div>
                </div>
                Checkbox Text
              </label>
            </div>

            <div x-data="{ checkboxToggle: false }">
              <label for="checkboxLabelThree" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="checkboxLabelThree" class="sr-only"
                    @change="checkboxToggle = !checkboxToggle" />
                  <div :class="checkboxToggle && 'border-primary bg-gray dark:bg-transparent'"
                    class="box mr-4 flex h-5 w-5 items-center justify-center rounded border">
                    <span :class="checkboxToggle && '!opacity-100'" class="text-primary opacity-0">
                      <svg class="h-3.5 w-3.5 stroke-current" fill="none" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </span>
                  </div>
                </div>
                Checkbox Text
              </label>
            </div>

            <div x-data="{ checkboxToggle: false }">
              <label for="checkboxLabelFour" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="checkboxLabelFour" class="sr-only"
                    @change="checkboxToggle = !checkboxToggle" />
                  <div :class="checkboxToggle && 'border-primary'"
                    class="mr-4 flex h-5 w-5 items-center justify-center rounded-full border">
                    <span :class="checkboxToggle && '!bg-primary'"
                      class="h-2.5 w-2.5 rounded-full bg-transparent">
                    </span>
                  </div>
                </div>
                Checkbox Text
              </label>
            </div>

            <div x-data="{ checkboxToggle: false }">
              <label for="checkboxLabelFive" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                  <input type="checkbox" id="checkboxLabelFive" class="sr-only"
                    @change="checkboxToggle = !checkboxToggle" />
                  <div :class="checkboxToggle && '!border-4'"
                    class="box mr-4 flex h-5 w-5 items-center justify-center rounded-full border border-primary">
                    <span class="h-2.5 w-2.5 rounded-full bg-white dark:bg-transparent">
                    </span>
                  </div>
                </div>
                Checkbox Text
              </label>
            </div>
          </div>
        </div>

        <!-- Select input -->
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
          <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
              Select input
            </h3>
          </div>
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Select Country
              </label>
              <div class="relative z-20 bg-white dark:bg-form-input">
                <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.8">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.0007 2.50065C5.85852 2.50065 2.50065 5.85852 2.50065 10.0007C2.50065 14.1428 5.85852 17.5007 10.0007 17.5007C14.1428 17.5007 17.5007 14.1428 17.5007 10.0007C17.5007 5.85852 14.1428 2.50065 10.0007 2.50065ZM0.833984 10.0007C0.833984 4.93804 4.93804 0.833984 10.0007 0.833984C15.0633 0.833984 19.1673 4.93804 19.1673 10.0007C19.1673 15.0633 15.0633 19.1673 10.0007 19.1673C4.93804 19.1673 0.833984 15.0633 0.833984 10.0007Z"
                        fill="#637381"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.833984 9.99935C0.833984 9.53911 1.20708 9.16602 1.66732 9.16602H18.334C18.7942 9.16602 19.1673 9.53911 19.1673 9.99935C19.1673 10.4596 18.7942 10.8327 18.334 10.8327H1.66732C1.20708 10.8327 0.833984 10.4596 0.833984 9.99935Z"
                        fill="#637381"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.50084 10.0008C7.55796 12.5632 8.4392 15.0301 10.0006 17.0418C11.5621 15.0301 12.4433 12.5632 12.5005 10.0008C12.4433 7.43845 11.5621 4.97153 10.0007 2.95982C8.4392 4.97153 7.55796 7.43845 7.50084 10.0008ZM10.0007 1.66749L9.38536 1.10547C7.16473 3.53658 5.90275 6.69153 5.83417 9.98346C5.83392 9.99503 5.83392 10.0066 5.83417 10.0182C5.90275 13.3101 7.16473 16.4651 9.38536 18.8962C9.54325 19.069 9.76655 19.1675 10.0007 19.1675C10.2348 19.1675 10.4581 19.069 10.6159 18.8962C12.8366 16.4651 14.0986 13.3101 14.1671 10.0182C14.1674 10.0066 14.1674 9.99503 14.1671 9.98346C14.0986 6.69153 12.8366 3.53658 10.6159 1.10547L10.0007 1.66749Z"
                        fill="#637381"></path>
                    </g>
                  </svg>
                </span>
                <select
                  class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                  <option value="">USA</option>
                  <option value="">UK</option>
                  <option value="">Canada</option>
                </select>
                <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.8">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                        fill="#637381"></path>
                    </g>
                  </svg>
                </span>
              </div>
            </div>

            <div>
              <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                Multiselect Dropdown
              </label>
              <div
                class="relative z-20 w-full rounded border border-stroke p-1.5 pr-8 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                <div class="flex flex-wrap items-center">
                  <span
                    class="m-1.5 flex items-center justify-center rounded border-[.5px] border-stroke dark:border-strokedark bg-gray dark:bg-white/30 py-1.5 px-2.5 text-sm font-medium">
                    Design
                    <span class="cursor-pointer pl-2 hover:text-danger">
                      <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.35355 3.35355C9.54882 3.15829 9.54882 2.84171 9.35355 2.64645C9.15829 2.45118 8.84171 2.45118 8.64645 2.64645L6 5.29289L3.35355 2.64645C3.15829 2.45118 2.84171 2.45118 2.64645 2.64645C2.45118 2.84171 2.45118 3.15829 2.64645 3.35355L5.29289 6L2.64645 8.64645C2.45118 8.84171 2.45118 9.15829 2.64645 9.35355C2.84171 9.54882 3.15829 9.54882 3.35355 9.35355L6 6.70711L8.64645 9.35355C8.84171 9.54882 9.15829 9.54882 9.35355 9.35355C9.54882 9.15829 9.54882 8.84171 9.35355 8.64645L6.70711 6L9.35355 3.35355Z"
                          fill="currentColor"></path>
                      </svg>
                    </span>
                  </span>
                  <span
                    class="m-1.5 flex items-center justify-center rounded border-[.5px] border-stroke dark:border-strokedark bg-gray dark:bg-white/30 py-1.5 px-2.5 text-sm font-medium">
                    Development
                    <span class="cursor-pointer pl-2 hover:text-danger">
                      <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.35355 3.35355C9.54882 3.15829 9.54882 2.84171 9.35355 2.64645C9.15829 2.45118 8.84171 2.45118 8.64645 2.64645L6 5.29289L3.35355 2.64645C3.15829 2.45118 2.84171 2.45118 2.64645 2.64645C2.45118 2.84171 2.45118 3.15829 2.64645 3.35355L5.29289 6L2.64645 8.64645C2.45118 8.84171 2.45118 9.15829 2.64645 9.35355C2.84171 9.54882 3.15829 9.54882 3.35355 9.35355L6 6.70711L8.64645 9.35355C8.84171 9.54882 9.15829 9.54882 9.35355 9.35355C9.54882 9.15829 9.54882 8.84171 9.35355 8.64645L6.70711 6L9.35355 3.35355Z"
                          fill="currentColor"></path>
                      </svg>
                    </span>
                  </span>
                </div>
                <select name="" id="" class="absolute top-0 left-0 z-20 h-full w-full bg-transparent opacity-0">
                  <option value="">Option</option>
                  <option value="">Option</option>
                </select>
                <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.8">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                        fill="#637381"></path>
                    </g>
                  </svg>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ====== Form Elements Section End -->
  </div>

    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
          <!-- Breadcrumb Start -->
          <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
              Form Layout
            </h2>

            <nav>
              <ol class="flex items-center gap-2">
                <li><a class="font-medium" href="index.html">Dashboard /</a></li>
                <li class="font-medium text-primary">Form Layout</li>
              </ol>
            </nav>
          </div>
          <!-- Breadcrumb End -->

          <!-- ====== Form Layout Section Start -->
          <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <div class="flex flex-col gap-9">
              <!-- Contact Form -->
              <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                  <h3 class="font-semibold text-black dark:text-white">
                    Contact Form
                  </h3>
                </div>
                <form action="#">
                  <div class="p-6.5">
                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                      <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                          First name
                        </label>
                        <input type="text" placeholder="Enter your first name"
                          class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>

                      <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                          Last name
                        </label>
                        <input type="text" placeholder="Enter your last name"
                          class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                      </div>
                    </div>

                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Email <span class="text-meta-1">*</span>
                      </label>
                      <input type="email" placeholder="Enter your email address"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Subject
                      </label>
                      <input type="text" placeholder="Select subject"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Subject
                      </label>
                      <div class="relative z-20 bg-transparent dark:bg-form-input">
                        <select
                          class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                          <option value="">Type your subject</option>
                          <option value="">USA</option>
                          <option value="">UK</option>
                          <option value="">Canada</option>
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                          <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.8">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                fill=""></path>
                            </g>
                          </svg>
                        </span>
                      </div>
                    </div>

                    <div class="mb-6">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Message
                      </label>
                      <textarea rows="6" placeholder="Type your message"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"></textarea>
                    </div>

                    <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                      Send Message
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="flex flex-col gap-9">
              <!-- Sign In Form -->
              <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                  <h3 class="font-semibold text-black dark:text-white">
                    Sign In Form
                  </h3>
                </div>
                <form action="#">
                  <div class="p-6.5">
                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Email
                      </label>
                      <input type="email" placeholder="Enter your email address"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div>
                      <label class="mb-2.5 block text-black dark:text-white">
                        Password
                      </label>
                      <input type="password" placeholder="Enter password"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mt-5 mb-5.5 flex items-center justify-between">
                      <label for="formCheckbox" class="flex cursor-pointer">
                        <div class="relative pt-0.5">
                          <input type="checkbox" id="formCheckbox" class="taskCheckbox sr-only" />
                          <div
                            class="box mr-3 flex h-5 w-5 items-center justify-center rounded border border-stroke dark:border-strokedark">
                            <span class="text-white opacity-0">
                              <svg class="fill-current" width="10" height="7" viewBox="0 0 10 7" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M9.70685 0.292804C9.89455 0.480344 10 0.734667 10 0.999847C10 1.26503 9.89455 1.51935 9.70685 1.70689L4.70059 6.7072C4.51283 6.89468 4.2582 7 3.9927 7C3.72721 7 3.47258 6.89468 3.28482 6.7072L0.281063 3.70701C0.0986771 3.5184 -0.00224342 3.26578 3.785e-05 3.00357C0.00231912 2.74136 0.10762 2.49053 0.29326 2.30511C0.4789 2.11969 0.730026 2.01451 0.992551 2.01224C1.25508 2.00996 1.50799 2.11076 1.69683 2.29293L3.9927 4.58607L8.29108 0.292804C8.47884 0.105322 8.73347 0 8.99896 0C9.26446 0 9.51908 0.105322 9.70685 0.292804Z"
                                  fill="" />
                              </svg>
                            </span>
                          </div>
                        </div>
                        <p>Remember me</p>
                      </label>

                      <a href="#" class="text-sm text-primary">Forget password?</a>
                    </div>

                    <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                      Sign In
                    </button>
                  </div>
                </form>
              </div>

              <!-- Sign Up Form -->
              <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                  <h3 class="font-semibold text-black dark:text-white">
                    Sign Up Form
                  </h3>
                </div>
                <form action="#">
                  <div class="p-6.5">
                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Name
                      </label>
                      <input type="text" placeholder="Enter your full name"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Email
                      </label>
                      <input type="email" placeholder="Enter your email address"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Password
                      </label>
                      <input type="password" placeholder="Enter password"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-5.5">
                      <label class="mb-2.5 block text-black dark:text-white">
                        Re-type Password
                      </label>
                      <input type="password" placeholder="Re-enter password"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                      Sign Up
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- ====== Form Layout Section End -->
        </div>
