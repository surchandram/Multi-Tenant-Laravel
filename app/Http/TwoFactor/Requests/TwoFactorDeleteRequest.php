<?php

namespace SAAS\Http\TwoFactor\Requests;

use SAAS\Http\Auth\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class TwoFactorDeleteRequest extends FormRequest
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
            'current_password' => ['required', new CurrentPassword()],
        ];
    }
}
