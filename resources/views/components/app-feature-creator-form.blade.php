<div
    x-data="{
        features: [],
        init() {
            $watch('features', function (value) {
                $dispatch('app-draft-features-changed', value);
            });
        },
        initFormData() {
            return {
                _id: Date.now() + 1,
                name: '',
                key: '',
                is_unlimited: true,
                usable: true,
            }
        },
        addFeature() {
            const data = this.initFormData();

            this.features.push(data);
        },
        toggleFeatureUsable(index) {
            this.features[index]['usable'] = ! this.features[index]['usable'];
        },
        setFeatureKey(index) {
            this.features[index]['key'] = this.keyFromName(this.features[index]['name']);
        },
        updateFeaturesData(form, index) {
            this.features[index] = form;
        },
        removeFeature(id) {
            console.log(id);
            var filtered = _.filter(this.features, (feature) => feature._id != id);
            console.log(filtered);

            this.features = [];
            this.features = filtered;
        },
        resetForm() {
            while(this.features.length > 0) {
                this.features.pop();
            }
            this.features = []
        }
    }"
    class=""
    x-on:update-features-data.window="updateFeaturesData($event.detail)"
    x-on:add-app-feature.window="addFeature()"
    x-on:reset-app-creator-forms.window="resetForm()"
>
    <template x-for="(feature, index) in features" :key="`featureTemp${index}Wrapper`">
        <div
            x-data="{
                featureForm: initFormData(),
                setFeatureUsable() {
                    this.featureForm.usable = !this.featureForm.usable;
                },
                init () {
                    this.featureForm = this.features[index]

                    $watch('featureForm', function(value) {
                        $dispatch('update-features-data', { form: value, index: index });
                    });
                }
            }"
            :key="`featureKey${feature._id}`"
            x-bind:id="`featureWrapper${feature._id}`"
            :key="`featureWrapper${feature._id}`"
            class="mt-2 mb-4"
        >
            <div
                x-effect="() => featureForm.key = keyFromName(featureForm.name)"
                class="w-full grid grid-cols-5 gap-2 mt-1"
            >
                <!-- feature name -->
                <div class="mt-4 md:mt-0 col-span-2">
                    <x-input-label
                        x-bind:key="`feature${index}NameLabel`"
                        x-bind:for="`feature${index}Name`">
                        {{ __('Name') }}
                    </x-input-label>
    
                    <x-input class="w-full mt-2"
                       type="text"
                       placeholder="{{ __('feature name') }}"
                       x-bind:id="`feature${index}Name`"
                       x-bind:key="`feature${index}Name`"
                       x-ref="`feature${index}Name`"
                       x-bind:name="`features[${index}]['name']`"
                       x-model="featureForm.name"
                       required
                    />
                </div><!-- /.form-group -->
    
                <!-- feature key -->
                <div class="mt-4 md:mt-0 col-span-2">
                    <x-input-label
                        x-bind:key="`feature${index}KeyLabel`"
                        x-bind:for="`feature${index}Key`">
                        {{ __('Key') }}
                    </x-input-label>
    
                    <x-input class="w-full mt-2"
                       type="text"
                       placeholder="{{ __('A unique identifier for the feature') }}"
                       x-bind:id="`feature${index}Key`"
                       x-bind:key="`feature${index}Key`"
                       x-ref="`feature${index}Key`"
                       x-bind:name="`features[${index}]['key']`"
                       x-model="featureForm.key"
                    />
    
    
                    <p class="mt-2 text-xs font-semibold text-slate-500 text-danger">
                        {{ __('You cannot change this once app is created.') }}
                    </p>
                </div><!-- /.form-group -->
    
                <div
                    class="inline-flex items-center gap-2 col-span-1"
                >
                    <x-checkbox
                        class="rounded-md"
                        x-bind:name="`features[${index}]['usable']`"
                        x-model="featureForm.usable"
                        x-bind:id="`feature${index}Usable`"
                        x-bind:key="`feature${index}Usable`"
                        value="1"
                        @click="setFeatureUsable()"
                    />
                
                    <x-input-label
                        x-bind:key="`feature${index}UsableLabel`"
                        x-bind:for="`feature${index}Usable`"
                    >
                        {{ __('Usable') }}
                    </x-input-label>
                </div><!-- /.custom-control -->
            </div>
    
            <p class="mt-3 mb-4">
                <x-button
                    type="button"
                    light
                    bold
                    variant="red"
                    @click="removeFeature(feature._id)"
                >
                    {{ __('Remove') }}
                </x-button>
            </p>
        </div>
    </template>
</div>
