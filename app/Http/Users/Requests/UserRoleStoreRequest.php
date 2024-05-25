<?php

namespace SAAS\Http\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRoleStoreRequest extends FormRequest
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
            'role_id' => [
                'required',
                'numeric',
                Rule::exists('roles', 'id')->where('usable', true),
            ],
            'expires_at' => ['nullable', 'date', 'after_or_equal:+1 day'],
        ];
    }
}
