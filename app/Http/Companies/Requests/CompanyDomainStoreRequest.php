<?php

namespace SAAS\Http\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Companies\Actions\UpdateCompanyDomainAction;

class CompanyDomainStoreRequest extends FormRequest
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
            'domain' => [
                'required',
                'min:2',
                Rule::prohibitedIf(fn () => ($this->company->getDomainChangeInDaysFromToday()) < 60),
                Rule::unique('companies', 'domain')->ignore($this->company),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'domain.prohibited' => __('app.company.domain_changes_locked', ['date' => $this->company->getDateDomainIsUnlocked()]),
        ];
    }

    public function updateDomain()
    {
        return UpdateCompanyDomainAction::execute($this->domain, $this->company);
    }
}
