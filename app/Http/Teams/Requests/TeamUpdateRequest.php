<?php

namespace SAAS\Http\Teams\Requests;

use Illuminate\Validation\Rule;

class TeamUpdateRequest extends TeamStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => [
                'required',
                'min:2',
                Rule::unique('teams', 'name')
                    ->where('teamable_type', get_class($this->company))
                    ->ignore($this->company->id, 'teamable_id'),
            ],
        ]);
    }
}
