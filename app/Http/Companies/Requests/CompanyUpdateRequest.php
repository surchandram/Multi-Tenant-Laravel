<?php

namespace SAAS\Http\Companies\Requests;

use SAAS\Domain\Companies\Actions\UpdateCompanyAction;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;

class CompanyUpdateRequest extends CompanyStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'domain' => [
                'exclude',
            ],
            'apps' => [
                'nullable',
                'array',
            ],
        ]);
    }

    /**
     * Update company.
     *
     * @return \SAAS\Domain\Companies\Models\Company
     */
    public function updateCompany()
    {
        return UpdateCompanyAction::execute(
            CompanyData::fromRequest($this),
            $this->company
        );
    }
}
