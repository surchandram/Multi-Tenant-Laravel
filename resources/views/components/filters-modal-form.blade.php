@props([
    'id',
    'title' => __('Filters')
])

<form method="GET" action="">
    <template x-for="(value, name) in selected">
        <input type="hidden" x-bind:name="name" x-bind:value="value">
    </template>

    <x-modal name="{{ $id }}" tabindex="-1" role="dialog">
        <x-card no-wrap-pad no-pad>
            <x-slot name="header" class="flex items-center justify-between border-b">
                <h4 class="text-lg font-semibold">
                    {{ $title }}
                </h4>
    
                <x-button
                    type="button"
                    is-text
                    size="sm"
                    class="focus:ring"
                    aria-hidden="true"
                    @click="$dispatch('close-modal', '{{ $id }}')"
                >
                    &times;
                </x-button>
            </x-slot>
    
            <div class="p-6 h-[60vh] overflow-hidden">
                <div class="h-full flex flex-col overflow-y-scroll">
                    <!-- Filter Group -->
                    <template x-for="(filterGroup, key) in filters">
                        <div
                            x-data="{
                                show: false,
                                get selectedFilter() {
                                    return _.get(filterGroup.map, _.get(this.selected, key))
                                },
                                get inSelectedFilters() {
                                    return _.includes(this.selectedFilters, key)
                                }
                            }"
                            class="w-full px-4 py-2"
                        >
                            <div class="w-full flex items-center gap-4">
                                <!-- Remove filter -->
                                <x-link-button
                                    href="#"
                                    light
                                    size="xs"
                                    bold
                                    rounded="md"
                                    x-show="inSelectedFilters"
                                    @click.prevent="removeFilter(key)"
                                >
                                    {{ __('Remove') }}
                                </x-link-button>

                                <!-- Filter Group Toggler -->
                                <a
                                    href="#"
                                    class="w-full inline-flex items-center gap-2 py-2 mb-3"
                                    @click.prevent="show = ! show"
                                >
                                    <h4
                                        class="text-lg font-semibold"
                                        x-text="filterGroup.heading"
                                    ></h4>

                                    <!-- Selected Filter -->
                                    <p
                                        x-show="inSelectedFilters"
                                        class="px-2 py-1 mr-auto rounded text-xs font-semibold bg-slate-800 text-white"
                                        x-text="selectedFilter"
                                    ></p>

                                    <x-dropdown-toggler-icon />
                                </a>
                            </div>

                            <!-- Filter Group Map -->
                            <ul
                                x-show="show"
                                class="w-full hidden flex-col"
                                :class="{ 'flex': show, 'hidden': ! show }"
                                style="display: none;"
                            >
                                <template x-for="(filter, value) in filterGroup.map">
                                    <li x-data="{
                                        get filterValue() {
                                          return value
                                        },
                                        activateFilter() {
                                            this.addFilter(key, value)
                                            this.show = ! this.show
                                        }
                                    }">
                                        <a
                                            class="
                                                w-full
                                                inline-flex
                                                items-center
                                                px-4
                                                py-2
                                                text-lg
                                                hover:bg-blue-500
                                                hover:text-white
                                                cursor-pointer
                                            "
                                            :class="{
                                                'text-blue-500': selected != filterValue,
                                                'bg-blue-500 text-white': selected == filterValue
                                            }"
                                            x-text="filter"
                                            x-bind:for="`${key}-${filter}-${value}`"
                                            @click.prevent="activateFilter"
                                        >
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>
            </div>
    
            <!-- Modal Actions -->
            <x-slot name="footer" class="flex items-center justify-end gap-2">
                <x-button
                    type="button"
                    light
                    size="sm"
                    bold
                    variant="gray"
                    x-bind:disabled="processing"
                    @click="$dispatch('close-modal', '{{ $id }}')"
                >
                    {{ __('Close') }}
                </x-button>
    
                <x-button
                    type="submit"
                    light
                    size="sm"
                    bold
                    x-bind:disabled="processing"
                    @click="$dispatch('close-modal', '{{ $id }}')">
                    {{ __('Apply Filters') }}
                </x-button>
            </x-slot>
        </x-card>
    </x-modal>
</form>
