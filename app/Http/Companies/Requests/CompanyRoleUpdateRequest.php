<?php

namespace SAAS\Http\Companies\Requests;

use Miracuthbert\LaravelRoles\Models\Role;

class CompanyRoleUpdateRequest extends CompanyRoleStoreRequest
{
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
                    $count = Role::where('name', $value)->where('type', $this->input('type'))
                        ->where('roleable_id', optional($this->company)->id ?? $this->company)
                        ->where('id', '!=', $this->role->id)->count();

                    if ($count >= 1) {
                        $fail(__('Role :name already exists.', ['name' => $value]));
                    }
                },
            ],
        ]);
    }
}
