<?php

namespace SAAS\Http\Addresses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'address_1' => ['required', 'string'],
            'address_2' => ['nullable', 'string'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'postal_code' => ['required', 'min:2'],
            'country_id' => [
                'required',
                'numeric',
                Rule::exists('countries', 'id')->where('usable', true),
            ],
            'default' => ['nullable', 'boolean'],
            'billing' => ['nullable', 'boolean'],
        ];
    }
}
