@props([
	'app' => null,
	'route' => route('admin.apps.store'),
])

<div
    x-data="{
        form: new FormData(),
        resetForm() {
            this.form = new FormData()
        },
        errors: [],
        saved: false,
        processing: false,
		handleLogo($event) {
            const formData = handleSingleFile($event, 'logo', this.form, '.app_logo_wrapper');
            this.form = formData
        },
        hasErrors() {
            return _.size(this.errors) > 0;
        },
        store() {
            this.errors = [];
            this.saved = false;
            this.processing = true;
            document.querySelector('.app_logo_wrapper').scrollIntoView();

            axios.post(@js($route), this.form)
	            .then((response) => {
	                // window.location.replace(response.data.redirect)

	                this.processing = false;
	                this.saved = true;
	                this.resetForm();
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
    x-on:app-created.window="store"
>
    <form method="POST" action="#" x-on:submit.prevent="store">
        @csrf
    	@method('PUT')

    	<div
    		class="app_logo_wrapper w-full md:w-48 max-h-48 mt-2 px-4 py-2 overflow-hidden"
		>
			@if($app->hasMedia('logo'))
				{{ $app->getFirstMedia('logo') }}
			@endif
		</div>

        <div class="w-full flex flex-col" x-ref="formAlert">
            <div
                class="px-4 py-2 bg-teal-600 text-white font-semibold"
                x-show="saved"
                style="display: none;"
            >
                {{ __('Logo added successfully.') }}
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

        <div class="">
            <x-input-label for="app_logo">{{ __('Upload a logo') }}</x-input-label>

            <x-input
            	class="w-full mt-4"
				id="app_logo"
				type="file"
				name="logo"
				allowed="images/*"
				placeholder="{{ __('App logo') }}"
				@change="handleLogo($event)"
            />

            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
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
        </div><!-- /.form-group -->
	</form>
</div>

@push('scripts')
	<script>
		const handleSingleFile = window.handleSingleFile = function (event, fieldName, formData, wrapperElem) {
	      var file = event.target.files[0]

	      try {
	        formData.set(fieldName, file)

	        if (wrapperElem) {
	          var wrapper = document.querySelector(wrapperElem)

	          if (!wrapper) {
	            return
	          }
	          wrapper.innerHTML = ''

	          var img = document.createElement('img')
	          img.src = window.URL.createObjectURL(file)
	          img.height = 60
	          img.onload = function () {
	            window.URL.revokeObjectURL(this.src)
	          }
	          wrapper.appendChild(img)
	        }
	      } catch (e) {
	      	console.log(e)
	      }

	      return formData
	    };

	    const handleImages = window.handleImages = function (event, fieldName, formData, wrapperElem) {
	      var files = event.target.files

	      if (wrapperElem) {
	        var wrapper = document.querySelector(wrapperElem)
	      }

	      for (var i = 0; i < files.length; i++) {
	        formData.set(`${fieldName}[${i}]`, files[i])

	        try {
	          if (wrapperElem && wrapper) {
	            var img = document.createElement('img')
	            img.src = window.URL.createObjectURL(files[i])
	            img.id = `upload-${fieldName}-${i}`
	            img.height = 60
	            img.onload = function () {
	              window.URL.revokeObjectURL(this.src)
	            }
	            wrapper.appendChild(img)
	          }
	        } catch (e) {}
	      }

	      // this.uploadImagesData = formData

	      return formData
	    };

		const handleMainImage = window.handleMainImage = function (event, form) {
			// this.initFormData()

			var file = event.target.files[0]

			var wrapper = document.querySelector('.app_logo_wrapper')

			if (!wrapper) {
			  return
			}

			wrapper.innerHTML = ''
			form.set('form', file)
			this.form = true

			try {
			  var img = document.createElement('img')
			  img.src = window.URL.createObjectURL(file)
			  img.height = 60
			  img.onload = function() {
			    window.URL.revokeObjectURL(this.src)
			  }
			  
			  wrapper.appendChild(img)
			} catch (e) {}
		}
	</script>
@endpush