@props(['key', 'id', 'setting'])

@php
$refKey = \Illuminate\Support\Str::studly($id);
@endphp

@switch($setting['type'])
    @case('boolean')
        <div
            x-data="{
                errors: [],
                saved: false,
                processing: false,
                form: {
                    'key': @js($id),
                    'id': @js($id),
                    'type': @js($setting['type']),
                    'value': Boolean(@js(Settings::get($key)))
                },
                toggled($event) {
                    this.form.value = !Boolean(this.form.value)
                },
                get checked() {
                    return Boolean(this.form.value)
                },
                hasErrors() {
                    return _.size(this.errors) > 0;
                },
                store() {
                    this.errors = [];
                    this.saved = false;
                    this.processing = true;
            
                    axios.post(@js(route('admin.settings.store')), this.form)
                        .then(() => {
                            this.processing = false;
                            this.saved = true;
                            $dispatch('setting-updated', Object.assign({}, this.form, { 'id': @js($refKey) }));
                        }).catch(error => {
                            this.processing = false;
                            this.toggled();
                            $refs.formErrors?.scrollIntoView();
                            $dispatch('switcher-revert', @js($refKey));

                            if (error.response) {
                                if (error.response.status === 422) {
                                    this.errors = error.response.data.errors;
                                }
                                console.log(error.response.status);
                            } else if (error.request) {
                                console.log(error.request);
                            } else {
                                console.log('Error', error.message);
                            }
                        })
                }
            }"
            class="flex flex-col"
        >
            <form action="#" x-on:submit.prevent="store">
                <button
                    type="submit"
                    themed
                    is-text
                    @click="toggled"
                    x-bind:disabled="processing"
                    class="flex cursor-pointer select-none items-center"
                >
                    <div class="relative">
                        <div class="block h-8 w-14 rounded-full bg-slate-200 dark:bg-[#5A616B]"></div>
                        <div :class="checked && '!right-1 !translate-x-full !bg-blue-600 dark:!bg-white'"
                            class="dot absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition">
                            <span :class="checked && '!block'" class="hidden">
                                <svg width="11" height="8" viewBox="0 0 11 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.0915 0.951972L10.0867 0.946075L10.0813 0.940568C9.90076 0.753564 9.61034 0.753146 9.42927 0.939309L4.16201 6.22962L1.58507 3.63469C1.40401 3.44841 1.11351 3.44879 0.932892 3.63584C0.755703 3.81933 0.755703 4.10875 0.932892 4.29224L0.932878 4.29225L0.934851 4.29424L3.58046 6.95832C3.73676 7.11955 3.94983 7.2 4.1473 7.2C4.36196 7.2 4.55963 7.11773 4.71406 6.9584L10.0468 1.60234C10.2436 1.4199 10.2421 1.1339 10.0915 0.951972ZM4.2327 6.30081L4.2317 6.2998C4.23206 6.30015 4.23237 6.30049 4.23269 6.30082L4.2327 6.30081Z"
                                        fill="white" stroke="white" stroke-width="0.4"></path>
                                </svg>
                            </span>
                            <span :class="checked && 'hidden'">
                                <svg class="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </button>
            </form>
            <p x-show="processing" style="display: none;">{{ __('Processing...') }}</p>
        </div>
    @break

    @default
        <a href="#"
            class="flex items-center text-blue-600 hover:underline gap-1"
            @click.prevent="
                $dispatch('change-setting', {
                    'key': @js($id),
                    'id': @js($id),
                    'type': @js($setting['type']),
                    'value': @js(Settings::get($key)),
                    'refKey': @js($refKey)
                })
            ">
            <i class="w-4 h-4 bi bi-pencil-square"></i> {{ __('Change') }}
        </a>
@endswitch
