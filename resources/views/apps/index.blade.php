<x-simple-layout>
  <div class="max-w-7xl mx-auto py-16 text-gray-800 text-center md:text-left">
    <!-- Section: Design Block -->
    <section class="mb-32 text-gray-800">
      <div class="flex flex-wrap items-center">
        <div class="grow-0 shrink-0 basis-auto w-full lg:w-4/12 mb-6 md:mb-0 px-3">
          <p class="uppercase text-blue-600 font-bold mb-6">{{ __('Apps') }}</p>
          <h2 class="text-3xl font-bold mb-6">
            {{ __('A list of available apps.') }}
          </h2>

          {{-- <p class="text-gray-500 mb-12"> --}}
            {{-- Nunc tincidunt vulputate elit. Mauris varius purus malesuada neque iaculis malesuada. --}}
            {{-- Aenean gravida magna orci, non efficitur est porta id. Donec magna diam. --}}
          {{-- </p> --}}
        </div>

        <div class="grow-0 shrink-0 basis-auto w-full lg:w-8/12 mb-6 mb-md-0 px-3">
          <div class="flex flex-wrap">
            <!-- Apps -->
            @forelse ($apps as $app)
              <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12 px-3">
                <div class="flex">
                  <div class="shrink-0">
                    <div class="p-4 bg-blue-600 rounded-md shadow-lg">
                      <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor"
                          d="M192 208c0-17.67-14.33-32-32-32h-16c-35.35 0-64 28.65-64 64v48c0 35.35 28.65 64 64 64h16c17.67 0 32-14.33 32-32V208zm176 144c35.35 0 64-28.65 64-64v-48c0-35.35-28.65-64-64-64h-16c-17.67 0-32 14.33-32 32v112c0 17.67 14.33 32 32 32h16zM256 0C113.18 0 4.58 118.83 0 256v16c0 8.84 7.16 16 16 16h16c8.84 0 16-7.16 16-16v-16c0-114.69 93.31-208 208-208s208 93.31 208 208h-.12c.08 2.43.12 165.72.12 165.72 0 23.35-18.93 42.28-42.28 42.28H320c0-26.51-21.49-48-48-48h-32c-26.51 0-48 21.49-48 48s21.49 48 48 48h181.72c49.86 0 90.28-40.42 90.28-90.28V256C507.42 118.83 398.82 0 256 0z">
                        </path>
                      </svg>
                    </div>
                  </div>
                  <div class="grow ml-4">
                    <p class="font-bold mb-1">{{ $app->name }}</p>
                    <p class="text-gray-500">
                      {{ $app->description }}

                      <div class="inline-block px-2 py-2">
                        <x-link-button
                          variant="slate"
                          shades="800,700,700"
                          is-text
                          size="sm"
                          bold
                          rounded="md"
                          href="{{ route('apps.show', $app) }}"
                        >
                          {{ __('More info...') }}
                        </x-link-button>
                      </div>
                    </p>
                  </div>
                </div>
              </div>
            @empty
              <p class="text-lg font-semibold text-slate-700">
                {{ __('Sorry, no apps available for your region yet.') }}
              </p>
            @endforelse
          </div>
        </div>
      </div>
    </section>
  </div>
</x-simple-layout>
