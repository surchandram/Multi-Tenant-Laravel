<div class="mt-4">
    <x-input-label for="type">{{ __('Type') }}</x-input-label>

    <x-select class="w-full mt-2" id="type" name="type">
        @foreach($types as $key => $type)
            <option value="{{ $key }}" {{ old('type', (isset($permitable) ? $permitable : 'admin')) === $key ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </x-select>

    <x-input-error :messages="$errors->get('type')" />
</div><!-- /.form-group -->

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selector = document.querySelector('select[id="type"]');
    
            var $selectors = document.querySelectorAll(`input[type=checkbox].select-all.permissions-toggle`);
            var $all = document.querySelectorAll(`input[type=checkbox].permission-item`);
    
            var disableCheckboxes = function (selected) {
                if (!selected) return
        
                var $typeToggler = _.filter($selectors, (item) => item.dataset.target === `permissions-${selected}`);

                [].forEach.call($typeToggler, function (item) {
                    item.disabled = false;
                })
        
                var $rivals = _.filter($selectors, (item) => item.dataset.target !== `permissions-${selected}`);

                [].forEach.call($rivals, function (item) {
                    item.disabled = true;
                })
        
                var $owned = _.filter($all, (item) => item.dataset.toggle === `permissions-${selected}`);

                [].forEach.call($owned, function (item) {
                    item.disabled = false;
                })

                var $boxes = _.filter($all, (item) => item.dataset.toggle !== `permissions-${selected}`);
    
                [].forEach.call($boxes, function (item) {
                    item.checked = false;
                    item.disabled = true;
                })
            }
    
            disableCheckboxes(selector.value)
    
            selector.addEventListener('change', function () {
                const selected = this.value;
    
                disableCheckboxes(selected);
            })
        })
    </script>
@endpush