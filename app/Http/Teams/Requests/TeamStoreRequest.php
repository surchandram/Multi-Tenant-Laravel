<?php

namespace SAAS\Http\Teams\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamStoreRequest extends FormRequest
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
            'name' => [
                'required',
                'min:2',
                Rule::unique('teams', 'name')
                    ->where('teamable_id', $this->company->id)
                    ->where('teamable_type', get_class($this->company)),
            ],
            'description' => [
                'nullable',
                'min:2',
            ],
            'usable' => [
                'required',
                'boolean',
            ],
        ];
    }
}
