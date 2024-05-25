<?php

namespace SAAS\Http\Plans\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Plans\Models\Plan;

class PlanStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3'],
            'interval' => [
                'required',
                'string',
                Rule::in(array_keys(Plan::$intervals)),
            ],
            'provider_id' => [
                'required',
                'string',
                Rule::unique('plans', 'provider_id'),
            ],
            'price' => ['required', 'integer', 'min:1'],
            'teams' => ['nullable', 'boolean'],
            'team_limit' => [
                Rule::requiredIf(function () {
                    return $this->input('teams', false) == true;
                }),
                'integer',
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'per_seat' => ['nullable', 'boolean'],
            'usable' => ['nullable', 'boolean'],
        ];
    }
}
