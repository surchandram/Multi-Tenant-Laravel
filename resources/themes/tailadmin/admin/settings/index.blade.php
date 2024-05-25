@extends('admin.layouts.default')

@section('title', page_title('Settings'))

@section('content')
    <div
        x-data="{ changes: 0, increment() { this.changes = ++this.changes } }"
        class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
        x-on:setting-updated.window="increment"
    >
        <div class="mx-auto max-w-270">
            <!-- Breadcrumb Start -->
            <x-breadcrumb>
                {{ __('Settings Page') }}

                <x-slot name="items">
                    <x-breadcrumb-item href="admin.dashboard">{{ __('Dashboard') }}</x-breadcrumb-item>
                </x-slot>
                <x-slot name="active">{{ __('Settings') }}</x-slot>
            </x-breadcrumb>
            <!-- Breadcrumb End -->

            <div x-show="changes > 0" class="flex items-center gap-2 mb-4" style="display: none;">
                <p>
                    (<span x-text="changes"></span>) {{ __('Some settings have been changed.') }}
                </p>

                <x-link-button themed themed rounded="md"
                    :href="route('admin.settings.index')"
                >
                    {{ __('Refresh page') }}
                </x-link-button>
            </div>

            <!-- ====== Settings Section Start -->
            <div class="grid grid-cols-5 gap-8">
                <div class="col-span-5">
                    <!-- ====== Table One Start -->
                    <div class="col-span-12">
                        <x-table-responsive>
                            <x-slot name="header">
                                <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                    {{ __('Key') }}
                                </th>
                                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                    {{ __('Value') }}
                                </th>
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    {{ __('Actions') }}
                                </th>
                            </x-slot>

                            @forelse ($settings as $setting)
                                <x-settings-row
                                    :key="$setting->key"
                                    :value="$setting"
                                    :id="$setting->key"
                                />
                            @empty
                                <tr>
                                    <x-table-responsive-col colspan="3">{{ __('No settings keys defined.') }}</x-table-responsive-col>
                                </tr>
                            @endforelse
                        </x-table-responsive>
                    </div>
                    <!-- ====== Table One End -->
                </div>
            </div>
            <!-- ====== Settings Section End -->

            <!-- Settings Modal -->
            <div
                x-data="{
                    errors: [],
                    saved: false,
                    processing: false,
                    form: {},
                    hasErrors() {
                        return _.size(this.errors) > 0;
                    },
                    setupForm($event) {
                        this.form = $event.detail;
                        this.saved = false;

                        $dispatch('open-modal', 'settingsModal')
                    },
                    closeModal() {
                        $dispatch('close-modal', 'settingsModal')
                    },
                    store() {
                        this.errors = [];
                        this.saved = false;
                        this.processing = true;
                
                        axios.post(@js(route('admin.settings.store')), this.form)
                            .then(() => {
                                this.processing = false;
                                this.saved = true;
                                $dispatch('setting-updated', Object.assign({}, this.form, { 'id':  this.form.refKey }))
                                $dispatch('close-modal', 'settingsModal')
                            }).catch(error => {
                                this.processing = false;
                                $refs.formErrors?.scrollIntoView();

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
                x-on:change-setting.window="setupForm"
            >
                <x-modal name="settingsModal">
                    <div class="flex flex-col gap-5.5 p-6.5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-medium text-black dark:text-white">
                                {{ __('You are currently editing:') }}
                                <span class="ml-1 text-slate-500" x-text="form.id?.split('.').join(' > ')"></span>
                            </h3>

                            <!-- Close -->
                            <x-link-button themed themed is-text rounded="full" href="#" @click.prevent="closeModal">
                                <span class="w-2 h-2 bi bi-x"></span>
                            </x-link-button>
                        </div>

                        <!-- Validation Errors -->
                        <div
                            class="px-4 py-2 mb-2 bg-red-500 text-white font-semibold"
                            x-ref="formErrors"
                            x-show="hasErrors"
                            style="display: none;"
                        >
                            <template x-for="error in errors">
                                <template x-for="field in error">
                                    <div class="mt-2 first:mt-0" x-text="field"></div>
                                </template>
                            </template>
                        </div>

                        <!-- Form -->
                        <form action="#" x-on:submit.prevent="store">
                            <!-- String Input -->
                            <div x-show="form.type == 'string'">
                                <x-input x-model="form.value" />
                            </div>

                            <!-- Text Input -->
                            <div x-show="form.type == 'text'">
                                <x-textarea x-model="form.value" />
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-4 mt-4">
                                <x-link-button
                                    themed
                                    bg="secondary"
                                    rounded="md"
                                    class="gap-2"
                                    x-bind:class="{ 'opacity-25': processing }"
                                    href="#"
                                    @click.prevent="closeModal"
                                >
                                    <div><span class="w-4 h-4 bi bi-x"></span></div> {{ __('Cancel') }}
                                </x-link-button>

                                <x-button x-bind:disabled="processing" type="submit">{{ __('Update') }}</x-button>
                            </div>
                        </form>
                    </div>
                </x-modal>
            </div>
        </div>
    </div>
@endsection
