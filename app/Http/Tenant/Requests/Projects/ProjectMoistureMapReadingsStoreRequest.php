<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class ProjectMoistureMapReadingsStoreRequest extends FormRequest
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
            'readings' => ['array', 'min:1'],
            'readings.*.recorded_at' => [
                'required_with:readings.*.value,null',
                'date',
            ],
            'readings.*.value' => [
                'required_with:readings.*.recorded_at',
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'readings' => collect($this->readings)->filter(fn ($arr) => filled($arr['value']))->all(),
        ]);
    }
}
