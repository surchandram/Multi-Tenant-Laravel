<?php

namespace SAAS\Http\Features\Requests;

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
            ],
            'key' => [
                'required',
                'string',
                'max:255',
                Rule::unique('features', 'key'),
            ],
            'description' => ['nullable', 'string'],
            'usable' => ['nullable', 'boolean'],
            'is_unlimited' => ['nullable', 'boolean'],
            'trial_limit' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
