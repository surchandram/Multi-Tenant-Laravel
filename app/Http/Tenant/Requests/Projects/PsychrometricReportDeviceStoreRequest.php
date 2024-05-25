<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PsychrometricReportDeviceStoreRequest extends FormRequest
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
            'device' => [
                'required',
            ],
            'project_affected_area_id' => [
                'required',
                'numeric',
                Rule::exists('tenant.project_affected_areas', 'id')
                    ->where('project_id', $this->project),
            ],
            'psychrometry_measure_point_id' => [
                'required',
                'numeric',
                Rule::exists('tenant.psychrometry_measure_points', 'id'),
            ],
        ];
    }
}
