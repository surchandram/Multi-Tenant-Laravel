@props(['key', 'value', 'id'])

@if (isset($value['value']) && is_array($value['value']))
    <tr>
        <x-table-col>
            <h5 class="font-medium text-black dark:text-white">{{ $key }}</h5>
        </x-table-col>
        <x-table-col>&nbsp;</x-table-col>
        <x-table-col>&nbsp;</x-table-col>
    </tr>
    @foreach ($value as $keyed => $setting)
        <x-settings-row :key="$keyed" :value="$setting" :id="join('.', [$id, $keyed])" />
    @endforeach
@elseif (!isset($value['value']) && is_array($value))
    <tr>
        <x-table-col>
            <h5 class="font-medium text-black dark:text-white">{{ $key }}</h5>
        </x-table-col>
        <x-table-col>&nbsp;</x-table-col>
        <x-table-col>&nbsp;</x-table-col>
    </tr>
    @foreach ($value as $keyed => $setting)
        <x-settings-row :key="$keyed" :value="$setting" :id="join('.', [$id, $keyed])" />
    @endforeach
@else
    <tr x-data="{
        refId: @js(\Illuminate\Support\Str::studly($id)),
        settingValue: @js(Settings::get($key)),
        updateLabel($event) {
            if ($event.detail.id == this.refId) {
                this.settingValue = $event.detail.value
            }
        }
    }"
        x-on:setting-updated.window="updateLabel"
    >
        <x-table-col>
            <h5 class="font-medium text-black dark:text-white">{{ $key }}</h5>
        </x-table-col>

        <x-table-col>
            <div x-text="settingValue"></div>
        </x-table-col>

        <x-table-col>
            <x-settings-action :key="$key" :id="$id" :setting="$value" />
        </x-table-col>
    </tr>
@endif
