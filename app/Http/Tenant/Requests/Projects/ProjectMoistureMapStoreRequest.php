<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectMoistureMapStoreRequest extends FormRequest
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
            'moisture_map' => [
                'required',
                'array',
                'min:1',
            ],

            'moisture_map.*.affected_area_id' => [
                'required',
                'integer',
                Rule::exists(
                    'tenant.project_affected_areas',
                    'affected_area_id'
                ),
            ],

            'moisture_map.*.structure' => [
                'required',
                'string',
            ],

            'moisture_map.*.material' => [
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
