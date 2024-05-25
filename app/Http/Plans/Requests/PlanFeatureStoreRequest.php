<?php

namespace SAAS\Http\Plans\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanFeatureStoreRequest extends FormRequest
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
            'feature' => [
                'required',
                'integer',
                Rule::unique('plan_features', 'feature_id')->where('plan_id', optional($this->plan)->id)
            ],
            'limit' => ['nullable', 'integer', 'min:0'],
            'default' => ['nullable', 'boolean'],
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
            'feature.unique' => __('This feature already exists in the plan.'),
        ];
    }
}
