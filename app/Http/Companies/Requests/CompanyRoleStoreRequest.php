<?php

namespace SAAS\Http\Companies\Requests;

use Illuminate\Support\Str;
use Miracuthbert\LaravelRoles\Models\Role;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Http\Roles\Requests\RoleStoreRequest;

class CompanyRoleStoreRequest extends RoleStoreRequest
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
        return array_merge(parent::rules(), [
            'name' => [
                'required',
                'max:250',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value.' '.optional($this->company)->getKey() ?? $this->company);

                    if (Role::where('slug', $slug)->count() > 0) {
                        $fail(__('Role already exists.'));
                    }
                },
            ],
        ]);
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $this->merge(['type' => array_search(Company::class, config('laravel-roles.models'))]);

        return parent::validationData();
    }
}
