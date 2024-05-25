<?php

namespace SAAS\Http\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use SAAS\Domain\Companies\Actions\CreateCompanyAction;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;

class CompanyStoreRequest extends FormRequest
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
            'name' => ['required', 'min:2'],
            'domain' => [
                'required',
                'min:2',
                'unique:companies,domain',
            ],
            'email' => ['required', 'string', 'email', 'max:255'],
            'logo' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png'])
                    ->max(5 * 1024),
            ],
            'measurement_unit' => [
                'required',
                'string',
                'min:2',
            ],
            'currency' => [
                'required',
                'string',
                'min:2',
            ],
            'default_tax' => [
                'nullable',
                'numeric',
                'min:2',
            ],
            'license_no' => [
                'nullable',
                'string',
                'min:2',
            ],
            'tax_id' => [
                'nullable',
                'string',
                'min:2',
            ],
            'projects_prefix' => [
                'nullable',
                'string',
                'min:2',
            ],
            'apps' => [
                'required',
                'array',
                'min:1',
            ],
            'apps.*.app_id' => [
                'required',
                'numeric',
                Rule::exists('apps', 'id')->where('usable', true),
            ],
            'apps.*.data' => [
                'nullable',
                'array',
            ],
        ];
    }

    /**
     * Create company.
     *
     * @return \SAAS\Domain\Companies\Models\Company
     */
    public function createCompany()
    {
        return CreateCompanyAction::execute(
            CompanyData::fromRequest($this),
            $this->user()
        );
    }
}
