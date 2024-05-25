<?php

namespace SAAS\Http\TwoFactor\Requests;

use SAAS\Http\Auth\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TwoFactorStoreRequest extends FormRequest
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
            'phone_number' => ['required'],
            'dial_code' => ['required', Rule::exists('countries', 'dial_code')],
            'current_password' => ['required', new CurrentPassword()],
        ];
    }
}
