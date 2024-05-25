<?php

namespace SAAS\Http\WebApps\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppFeatureStoreRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                'string',
            ],
            'is_unlimited' => [
                'nullable',
                'boolean',
            ],
            'usable' => [
                'nullable',
                'boolean',
            ],
            'key' => [
                'required',
                'string',
                Rule::unique('features', 'key'),
            ],
        ];
    }
}
