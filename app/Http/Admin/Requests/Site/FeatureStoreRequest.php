<?php

namespace SAAS\Http\Admin\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeatureStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
//                Rule::macro('slug', function ($attribute, $value) {
//
//                })
            ],
            'overview' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'usable' => ['nullable', 'boolean'],
        ];
    }
}
