<?php

namespace SAAS\Http\TwoFactor\Requests;

use SAAS\Domain\Users\Models\User;
use SAAS\App\TwoFactor\Rules\ValidTwoFactorToken;
use SAAS\App\TwoFactor\TwoFactor;
use Illuminate\Foundation\Http\FormRequest;

class TwoFactorVerifyRequest extends FormRequest
{
    /**
     * TwoFactor instance.
     *
     * @var \SAAS\App\TwoFactor\TwoFactor
     */
    protected $twoFactor;

    /**
     * TwoFactorVerifyRequest constructor.
     *
     * @param \SAAS\App\TwoFactor\TwoFactor $twoFactor
     * @return void
     */
    public function __construct(TwoFactor $twoFactor)
    {
        $this->twoFactor = $twoFactor;
    }

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
        if (session()->has('twofactor')) {
            $this->setUserResolver($this->resolveCurrentUser());
        }

        return [
            'verification_code' => [
                'required',
                new ValidTwoFactorToken($this->user(), $this->twoFactor)
            ],
        ];
    }

    /**
     * Resolve the user verifying their token.
     *
     * @return \Closure
     */
    protected function resolveCurrentUser()
    {
        return function () {
            return User::find(session('twofactor')->user_id);
        };
    }
}
