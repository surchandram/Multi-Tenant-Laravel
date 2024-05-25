<?php

namespace SAAS\Http\Permissions\Requests;

use Miracuthbert\LaravelRoles\Rules\ValidPermissionSlug;

class PermissionUpdateRequest extends PermissionStoreRequest
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
                new ValidPermissionSlug($this->input('type'), $this->permission)
            ],
        ]);
    }
}
