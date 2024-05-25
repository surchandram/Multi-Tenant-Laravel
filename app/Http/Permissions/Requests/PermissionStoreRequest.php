<?php

namespace SAAS\Http\Permissions\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Miracuthbert\LaravelRoles\Rules\ValidPermissionSlug;

class PermissionStoreRequest extends FormRequest
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
            'name' => ['required', 'max:250', new ValidPermissionSlug($this->input('type'))],
            'description' => ['nullable', 'max:255'],
            'type' => ['required', Rule::in(array_keys(config('laravel-roles.permitables')))],
            'usable' => ['nullable', 'boolean'],
        ];
    }
}
