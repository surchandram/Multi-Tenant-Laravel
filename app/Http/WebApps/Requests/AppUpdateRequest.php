<?php

namespace SAAS\Http\WebApps\Requests;

use Illuminate\Validation\Rule;

class AppUpdateRequest extends AppStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => [
                'required',
                'string',
                Rule::unique('apps')->ignore($this->app),

            ],
            'key' => [
                'required',
                'string',
                Rule::unique('apps')->ignore($this->app),

            ],
            'url' => [
                'required',
                'string',
                Rule::unique('apps')->ignore($this->app),
            ],
            'features' => ['nullable', 'array'],
            'plans' => ['nullable', 'array'],
        ]);
    }
}
