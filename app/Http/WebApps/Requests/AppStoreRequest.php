<?php

namespace SAAS\Http\WebApps\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:apps'],
            'key' => ['required', 'string', 'unique:apps'],
            'description' => ['required', 'string', 'max:300'],
            'overview' => ['nullable', 'string', 'max:5000'],
            'url' => ['required', 'string', 'unique:apps'],
            'usable' => ['nullable', 'boolean'],
            'teams_only' => ['nullable', 'boolean'],
            'primary' => ['nullable', 'boolean'],
            'subscription' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image:png,jpg,jpeg'],
            'plans' => ['required', 'array', 'min:1'],
            'plans.*.name' => [
                'required',
                'string',
            ],
            'plans.*.provider_id' => [
                'exclude_if:subscription,false',
                'string',
                Rule::unique('plans', 'provider_id'),
            ],
            'plans.*.per_seat' => [
                'required',
                'boolean',
            ],
            'plans.*.usable' => [
                'nullable',
                'boolean',
            ],
            'plans.*.price' => [
                'required',
                'integer',
            ],
            'plans.*.is_unlimited' => [
                'nullable',
                'boolean',
            ],
            'plans.*.limit' => [
                'nullable',
                'integer',
            ],
            'plans.*.features' => ['required', 'array', 'min:1'],
            'features' => ['required', 'array', 'min:1'],
            'features.*.name' => [
                'required',
                'string',
            ],
            'features.*.is_unlimited' => [
                'nullable',
                'boolean',
            ],
            'features.*.limit' => [
                'nullable',
                'integer',
            ],
            'features.*.usable' => [
                'nullable',
                'boolean',
            ],
            'features.*.key' => [
                'required',
                'string',
                Rule::unique('features', 'key'),
            ],
        ];
    }
}
