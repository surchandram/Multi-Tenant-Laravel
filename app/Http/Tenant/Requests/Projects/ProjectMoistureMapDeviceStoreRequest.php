<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class ProjectMoistureMapDeviceStoreRequest extends FormRequest
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
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'moisture_map' => [
                'required' => __('Define at least one structure to save moisture map'),
            ],
        ];
    }
}
