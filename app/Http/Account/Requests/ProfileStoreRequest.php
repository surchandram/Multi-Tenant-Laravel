<?php

namespace SAAS\Http\Account\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use SAAS\Domain\Account\Actions\UpdateProfileAction;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Http\Auth\Rules\CurrentPassword;

class ProfileStoreRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users', 'username')->ignore(auth()->id()),
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'avatar' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png'])
                    ->max(5 * 1024),
            ],
            'password' => ['required', new CurrentPassword()],
        ];
    }

    /**
     * Update user's profile.
     *
     * @return \SAAS\Domain\Users\Models\User
     */
    public function updateProfile()
    {
        return UpdateProfileAction::execute(UserData::fromProfileRequest($this));
    }
}
