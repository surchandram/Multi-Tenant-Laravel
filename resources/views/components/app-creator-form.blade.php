@props([
    'route' => route('admin.apps.store'),
    'apps',
    'updating' => false,
    'app' => null,
    'features',
    'plans',
])

@php
	$planIds = $updating ? $app->plans->pluck('plan_id') : [];
	$appPlans = $updating && !empty($planIds) ? $planIds->toArray() : [];
    $successMessage = $updating ? __('App updated successfully.') : __('App added successfully.');
@endphp

<div
    x-data="{
        form: {
            name: @js(old('name', $updating ? $app->name : '')),
            key: @js(old('key', $updating ? $app->key : '')),
            description: @js(old('description', $updating ? $app->description : '')),
            url: @js(old('url', $updating ? $app->url : '')),
            usable: @js(old('usable', $updating ? $app->usable : false)),
            teams_only: @js(old('teams_only', $updating ? $app->teams_only : false)),
            primary: @js(old('primary', $updating ? $app->primary : false)),
            subscription: @js(old('subscription', $updating ? $app->subscription : false))
        },
        updating: @js($updating),
        addNew: false,
        resetForm() {
            this.form = {
                name: '',
                key: '',
                description: '',
                url: '',
                usable: false,
                teams_only: false,
                primary: false,
                subscription: false
            }
        },
        keyFromName(value) {
            return value.trim().toLowerCase().replace(/_|\s/g, '-');
        },
        plans: @js(old('plans', $appPlans)),
        features: [],
        labels: [],
        errors: [],
        saved: false,
        processing: false,
        init() {
            $watch('form.name', (value) => {
                this.form.key = this.keyFromName(value);
            });
            $watch('form.key', (value) => {
                this.form.key = this.keyFromName(value);
            });
            $watch('form.teams_only', (value) => {
                this.plans = [];
            });
            $watch('form.subscription', (value) => {
                this.plans = [];
            });
        },
        hasErrors() {
            return _.size(this.errors) > 0;
        },
        togglePlan(id) {
            if (_.includes(this.plans, id)) {
                this.plans = _.filter(this.plans, (i) => i != id);
            } else {
                this.plans.push(id);
            }
        },
        store() {
            this.errors = [];
            this.addNew = false;
            this.saved = false;
            this.processing = true;
            document.body.scrollIntoView();

            axios[@js($updating ? 'patch' : 'post')](@js($route),
                Object.assign({}, this.form, {
                    features: this.features,
                    plans: this.plans 
                })
            )
            .then((response) => {
                if (!this.addNew && !this.updating) {
                    window.location.replace(response.data.redirect)
                }

                this.processing = false;
                this.saved = true;

                if (!this.updating) {
                    this.resetForm();
                }

                $dispatch('reset-app-creator-forms');
            }).catch(error => {
                this.processing = false;
                $refs.formErrors.scrollIntoView();

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
    class="card-body"
    x-on:app-draft-features-changed.window="(($event) => features = $event.detail)"
>
    <form method="POST" action="#" x-on:submit.prevent="store">
        @csrf
        @if ($updating)
        	@method('PATCH')
        @endif

        <div class="w-full flex flex-col" x-ref="formAlert">
            <div
                class="px-4 py-2 bg-teal-600 text-white font-semibold"
                x-show="saved"
                style="display: none;"
            >
                {{ $successMessage }}
            </div>
        </div>

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

        <div class="mt-4">
            <x-input-label for="name">{{ __('Name') }}</x-input-label>

            <x-input class="w-full mt-2"
               id="name"
               type="text"
               name="name"
               x-model="form.name"
               placeholder="{{ __('App name, eg. Content Management System') }}"
               value="{{ old('name') }}"
               required
               autofocus
            />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div><!-- /.form-group -->

        <div class="mt-4">
            <x-input-label for="key">{{ __('Key') }}</x-input-label>

            <x-input class="w-full mt-2"
               id="key"
               type="text"
               name="key"
               x-ref="appKey"
               x-model="form.key"
               placeholder="{{ __('A unique identifier for app, eg. cms, content-management-system') }}"
               value="{{ old('key') }}"
            />

            <x-input-error class="mt-2" :messages="$errors->get('key')" />

            <p class="mt-2 text-xs font-semibold text-slate-500 text-danger">
                {{ __('You cannot change this once app is created.') }}
            </p>
        </div><!-- /.form-group -->

        <!-- App Url -->
        <div class="mt-4">
            <x-input-label for="url">{{ __('Url') }}</x-input-label>

            <x-select
                class="w-full mt-2"
                id="url"
                name="url"
                x-model="form.url"
                value="{{ old('url') }}"
            >
                <option value="">{{ __('Pick app url') }}</option>
                @foreach (appUris() as $uri)
                    <option value="{{ $uri }}">{{ $uri }}</option>
                @endforeach
            </x-select>

            <x-input-error class="mt-2" :messages="$errors->get('url')" />

            <p class="mt-2 text-xs font-semibold text-slate-500 text-danger">
                {{ __('The link to the app\'s entry point.') }}
            </p>
        </div><!-- /.form-group -->

        <!-- App Description -->
        <div class="mt-4">
            <x-input-label for="description">{{ __('Description') }}</x-input-label>

            <x-textarea
                class="w-full mt-2"
                id="description"
                name="description"
                x-model="form.description"
                rows="3"
                maxlength="255"
                placeholder="{{ __('A detailed description of the app') }}"
                :value="old('description')"
            />

            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div><!-- /.form-group -->

        <!-- Usable -->
        <div class="mt-4">
            <div class="inline-flex items-center gap-2">
                <input
                    name="usable"
                    x-model="form.usable"
                    class="rounded-md"
                    id="usable"
                    type="checkbox"
                    value="1"
                    {{ old('usable', 1) == 1 ? ' checked' : '' }}
                />

                <x-input-label for="usable">{{ __('Active') }}</x-input-label>

                <x-input-error class="mt-2" :messages="$errors->get('usable')" />
            </div><!-- /.custom-control -->

            <p class="mt-2 text-xs font-semibold text-slate-500">
                {{ __('Uncheck if you do not want app to be active') }}
            </p>
        </div><!-- /.form-group -->

        <!-- App is Primary -->
        <div class="mt-4">
            <div class="inline-flex items-center gap-2">
                <input
                    name="primary"
                    x-model="form.primary"
                    class="rounded-md"
                    id="primary"
                    type="checkbox"
                    value="1"
                    {{ old('primary', 1) == 1 ? ' checked' : '' }}
                />

                <x-input-label for="primary">{{ __('Primary') }}</x-input-label>

                <x-input-error class="mt-2" :messages="$errors->get('primary')" />
            </div><!-- /.custom-control -->

            <p class="mt-2 text-xs font-semibold text-slate-500">
                {{ __('Leave unchecked if you do not want app to be a primary app') }}
            </p>
        </div><!-- /.form-group -->

        <!-- Teams only -->
        <div class="mt-4">
            <div class="inline-flex items-center gap-2">
                <input
                    name="teams_only"
                    x-model="form.teams_only"
                    class="rounded-md"
                    id="teams_only"
                    type="checkbox"
                    value="1"
                    {{ old('teams_only', 1) == 1 ? ' checked' : '' }}
                />

                <x-input-label for="teams_only">
                    {{ __('Teams only') }}
                </x-input-label>

                <x-input-error class="mt-2" :messages="$errors->get('teams_only')" />
            </div><!-- /.custom-control -->

            <p class="mt-2 text-xs font-semibold text-slate-500">
                {{ __('Set whether app should be available only for teams.') }}
            </p>
        </div><!-- /.form-group -->

        <!-- Subscription -->
        <div class="mt-4">
            <div class="inline-flex items-center gap-2">
                <input
                    name="subscription"
                    x-model="form.subscription"
                    class="rounded-md"
                    id="subscription"
                    type="checkbox"
                    value="1"
                    {{ old('subscription', 1) == 1 ? ' checked' : '' }}
                />

                <x-input-label for="subscription">
                    {{ __('Subscription') }}
                </x-input-label>

                <x-input-error class="mt-2" :messages="$errors->get('subscription')" />
            </div><!-- /.custom-control -->

            <p class="mt-2 text-xs font-semibold text-slate-500">
                {{ __('Leave unchecked if you do not want app to be billed.') }}
            </p>
        </div><!-- /.form-group -->

        <!-- Plans -->
        <div class="flex flex-col mt-4 gap-4" x-show="form.subscription" style="display: none;">
            <x-input-label>{{ __('Plans') }}</x-input-label>
            <p class="mb-2 text-xs font-semibold text-slate-500">
                {{ __('Select plans that should include app.') }}
            </p>

            {{-- Plans loop --}}
            @foreach ($plans as $index => $plan)
                <div
                    x-data="{ 
                        for_team: @js($plan->teams),
                        present: @js(in_array($plan->id, $appPlans))
                    }"
                    x-bind:class="{ 'hidden': !for_team && form.teams_only }"
                    class="inline-flex items-center gap-2"
                >
                    <x-checkbox
                        name="plans[]"
                        x-model="plans"
                        class="rounded-md"
                        id="plans-{{ $plan->id }}"
                        type="checkbox"
                        value="{{ $plan->id }}"
                        x-bind:checked="present"
                    />

                    <x-input-label
                        for="plans-{{ $plan->id }}"
                        x-bind:disabled="!for_team && form.teams_only"
                    >
                        {{ $plan->name }}
                    </x-input-label>

                    <x-input-error class="mt-2" :messages="$errors->get('plans')" />
                </div><!-- /.custom-control -->
            @endforeach
        </div><!-- /.form-group -->

        <!-- Features -->
        <div class="flex flex-col mt-4 gap-4">
            <x-input-label>{{ __('Features') }}</x-input-label>

            <p class="mb-2 text-xs font-semibold text-slate-500">
                {{ __('Define app features below.') }}
            </p>

            <!-- features field groups -->
            <x-app-feature-creator-form />

            <!-- add feature  -->
            <p class="mt-4 mb-4">
                <a
                    href="#"
                    class="text-blue-700 hover:underline"
                    @click.prevent="$dispatch('add-app-feature')"
                >
                    {{ __('Add new feature') }}
                </a>
            </p>
        </div><!-- /.form-group -->

        <!-- Form Buttons -->
        <div class="flex items-center gap-4 mt-4">
            <x-button x-bind:disabled="processing"
                light
                size="sm"
                bold
                type="submit"
            >
                {{ __('Save') }}
            </x-button>

            @if (!$updating)
	            <x-button x-bind:disabled="processing"
	                light
	                size="sm"
	                bold
	                variant="teal"
	                type="submit"
	                name="add_new"
	                value="1"
	                @click="addNew = true"
	            >
	                {{ __('Save and Add new') }}
	            </x-button>
            @endif

            <p x-show="processing" class="text-xs text-slate-500" style="display: none;">
                {{ __('Processing...') }}
            </p>

            <p x-show="saved" class="text-xs text-slate-500" style="display: none;">
                &check; {{ __('Saved') }}
            </p>
        </div><!-- /.form-group -->
    </form><!-- /form -->
</div>

@push('scripts')
    <script>
        const keyFromName = function(value) {
            return value.trim().toLowerCase().replace(/_|\s/g, '-');
        };
    </script>
@endpush
