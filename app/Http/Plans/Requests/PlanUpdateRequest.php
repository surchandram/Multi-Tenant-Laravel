<?php

namespace SAAS\Http\Plans\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
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
            'name' => ['present'],
            'interval' => ['present'],
            'provider_id' => ['present'],
            'price' => ['present'],
            'description' => ['nullable', 'string', 'max:255'],
            'usable' => ['nullable', 'boolean'],
        ];
    }
}