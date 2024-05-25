<?php

namespace SAAS\Http\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Companies\Actions\UpsertCompanyAppAction;
use SAAS\Domain\Companies\DataTransferObjects\CompanyAppData;

class CompanyAppSettingsStoreRequest extends FormRequest
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
            'app_id' => [
                'present',
                'numeric',
                Rule::exists('apps', 'id')->where('usable', true),
            ],
            'company_id' => [
                'present',
                'numeric',
                Rule::exists('companies', 'id'),
            ],
            'data.options' => [
                'array',
            ],
        ];
    }

    /**
     * Update company app settings.
     *
     * @return \SAAS\Domain\Companies\Models\CompanyApp
     */
    public function updateSettings()
    {
        return UpsertCompanyAppAction::execute(
            CompanyAppData::fromRequest($this)
        );
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = $this->input('data');

        if (! filled($this->input('app_id'))) {
            $data['app_id'] = $this->app->id;
        }

        if (! filled($this->input('company_id'))) {
            $data['company_id'] = $this->company->id;
        }

        $data['options'] = $this->input('options');

        $this->merge([
            'data' => $data,
        ]);
    }
}
