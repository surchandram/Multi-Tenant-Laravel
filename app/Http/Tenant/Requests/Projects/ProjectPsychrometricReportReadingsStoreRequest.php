<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectPsychrometricReportReadingsStoreRequest extends FormRequest
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
            'psychrometric_report' => [
                'required',
                'array',
                'min:1',
            ],
            'psychrometric_report.*' => [
                'sometimes',
                'array',
                'min:1',
                'exclude_if:psychrometric_report.*.temperature,null',
            ],
            'psychrometric_report.*.recorded_at' => [
                'exclude_without:psychrometric_report.*.temperature',
                'date',
            ],
            'psychrometric_report.*.temperature' => [
                'exclude_if:psychrometric_report.*.temperature,null',
                'required_with:psychrometric_report.*.relative_humidity',
                'numeric',
            ],
            'psychrometric_report.*.relative_humidity' => [
                'exclude_without:psychrometric_report.*.temperature',
                'required_with:psychrometric_report.*.temperature',
                'numeric',
            ],
            'psychrometric_report.*.project_affected_area_id' => [
                'exclude_without:psychrometric_report.*.temperature',
                'required_with:psychrometric_report.*.temperature',
                'numeric',
                Rule::exists('tenant.project_affected_areas', 'id')
                    ->where('project_id', $this->project),
            ],
            'psychrometric_report.*.psychrometry_measure_point_id' => [
                'exclude_without:psychrometric_report.*.temperature',
                'required_with:psychrometric_report.*.temperature',
                Rule::exists('tenant.psychrometry_measure_points', 'id'),
                'numeric',
            ],
        ];
    }
}
