<?php

namespace SAAS\Http\Features\Requests;

use Illuminate\Validation\Rule;

class FeatureUpdateRequest extends FeatureStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'key' => [
                'required',
                'string',
                'max:255',
                Rule::exists('features', 'key'),
            ],
        ]);
    }
}
