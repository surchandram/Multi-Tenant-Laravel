
<x-dashboard-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('New Ticket | Support Center')) }}
    </x-slot>
    
    <div class="mb-5">
        <x-card class="mt-4 ml-28 first:mt-0">
            <x-slot name="header" class="flex items-start justify-between border-b">
                <h4 class="text-lg font-semibold tracking-wider">
                    {{ __('New Ticket') }}
                </h4>
                
                <p class="text-sm text-slate-600">
                    <!-- actions -->
                </p>
            </x-slot>
                        
            <div
                x-data="{
                    form: {
                        title: @js(old('title')),
                        message: @js(old('message')),
                        priority: @js(old('priority')),
                        categories: @js(old('categories'))                        
                    },
                    labels: [],
                    errors: [],
                    processing: false,
                    hasErrors() {
                        return _.size(this.errors) > 0
                    },
                    toggleLabel(id) {
                        if (_.includes(this.labels, id)) {
                            this.labels = _.filter(this.labels, (i) => i != id)
                        } else {
                            this.labels.push(id)
                        }
                    },
                    store() {
                        this.errors = []
                        this.processing = true
    
                        axios.post(@js(route('support.tickets.store')), 
                            Object.assign({}, this.form, { labels: this.labels })
                        )
                        .then((response) => {
                            this.body = ''
                            window.location.replace(@js(route('support.tickets.index')))
                        }).catch(error => {
                            this.processing = false
                            if (error.response) {
                                if (error.response.status === 422) {
                                    this.errors = error.response.data.errors
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
                class="mt-2"
            >
                <form method="POST" action="#" x-on:submit.prevent="store">
                    @csrf
    
                    <div
                        class="px-4 py-2 mb-2 bg-red-500 text-white font-semibold"
                        x-show="hasErrors"
                        style="display: none;"
                    >
                        <template x-for="error in errors">
                            <template x-for="field in error">
                                <div class="mt-2 first:mt-0" x-text="field"></div>
                            </template>
                        </template>
                    </div>
    
                    <div>
                        <x-input-label for="title">
                            {{ __('Title') }}
                        </x-input-label>

                        <x-input
                            type="text"
                            name="form.title"
                            id="title"
                            class="w-full mt-2"
                            x-model="form.title"
                        />
                    </div>
    
                    <div class="mt-4">
                        <x-input-label for="priority" class="mb-2">
                            {{ __('Priority') }}
                        </x-input-label>

                        <x-select
                            type="text"
                            name="form.priority"
                            id="priority"
                            class="w-full mt-2"
                            x-model="form.priority"
                        >
                            <option value="">{{ __('Set priority') }}</option>
                                @foreach ($priorities as $key => $priority)
                                    <option value="{{ $priority }}">{{ $priority }}</option>
                                @endforeach
                        </x-select>
                    </div>
    
                    <div class="mt-4">
                        <x-input-label for="categories" class="mb-2">
                            {{ __('Category') }}
                        </x-input-label>

                        <x-select
                            type="text"
                            name="form.categories"
                            id="categories"
                            class="w-full mt-2"
                            x-model.number="form.categories"
                        >
                            <option value="">{{ __('Choose category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
    
                    <div class="mt-4">
                        <x-input-label for="labels" class="mb-2">
                            {{ __('Label') }}
                        </x-input-label>

                        <x-select
                            class="w-full mt-2"
                            id="labels"
                            x-model="labels"
                            multiple
                        >
                            @foreach ($labels as $label)
                                <option value="{{ $label->id }}">
                                    {{ $label->name }}
                                </option>
                            @endforeach
                        </x-select>
                        {{-- <div --}}
                            {{-- class="w-full grid grid-cols-1 grid-cols-3 gap-4 mt-2" --}}
                            {{-- x-model="form.labels" --}}
                        {{-- > --}}
                            {{-- @foreach ($labels as $label) --}}
                                {{-- <div class="flex items-center gap-2"> --}}
                                    {{-- <input --}}
                                        {{-- type="checkbox" --}}
                                        {{-- class=" --}}
                                            {{-- rounded --}}
                                            {{-- border-gray-300 --}}
                                            {{-- text-indigo-600 --}}
                                            {{-- shadow-sm --}}
                                            {{-- focus:border-indigo-300 --}}
                                            {{-- focus:ring --}}
                                            {{-- focus:ring-indigo-200 focus:ring-opacity-50 --}}
                                        {{-- " --}}
                                        {{-- value="{{ $label->id }}" --}}
                                        {{-- id="{{ $label->slug }}" --}}
                                        {{-- @click="toggleLabel(@js($label->id))" --}}
                                    {{-- /> --}}
                                    {{-- <x-input-label for="{{ $label->slug }}"> --}}
                                        {{-- {{ $label->name }} --}}
                                    {{-- </x-input-label> --}}
                                {{-- </div> --}}
                            {{-- @endforeach --}}
                        {{-- </div> --}}
                    </div>
    
                    <div class="mt-4">
                        <x-input-label for="message">
                            {{ __('Message') }}
                        </x-input-label>

                        <x-textarea
                            name="form.message"
                            id="message"
                            class="w-full mt-2"
                            x-model="form.message"
                        />
                    </div>
    
                    <div class="flex items-center justify-end mt-4">
                        <x-button type="submit" x-bind:disabled="processing" light bold uppercase size="sm">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </x-card>
    </div>
</x-dashboard-layout>
