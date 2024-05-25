<?php

namespace SAAS\Http\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserInvitationStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:45'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => [
                'nullable',
                'numeric',
                Rule::exists('roles', 'id')->where('usable', true),
            ],
            'role_expires_at' => ['nullable', 'exclude_if:role_id,null', 'date', 'after_or_equal:+1 day'],
        ];
    }
}
