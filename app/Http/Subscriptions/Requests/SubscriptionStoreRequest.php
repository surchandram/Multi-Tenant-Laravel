<?php

namespace SAAS\Http\Subscriptions\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Http\Subscriptions\Rules\ValidStripeCoupon;

class SubscriptionStoreRequest extends FormRequest
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
            'plan' => [
                'required',
                Rule::exists('plans', 'id')->where('usable', true)
            ],
            'payment_method' => ['required'],
            'coupon' => ['nullable', new ValidStripeCoupon()],
        ];
    }
}
