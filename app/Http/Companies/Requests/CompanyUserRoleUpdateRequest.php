<?php

namespace SAAS\Http\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUserRoleUpdateRequest extends FormRequest
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
            'role_id' => [
                'required',
                Rule::exists('roles', 'id')
                    ->where(function ($query) {
                        $query->where('type', 'company')
                            ->where('roleable_id', (optional($this->company)->id ?? $this->company))
                            ->orWhere('type', null)
                            ->orWhere('roleable_id', null);
                    })
                    ->where('usable', true),
            ],
        ];
    }
}
