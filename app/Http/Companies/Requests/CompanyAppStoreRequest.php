<?php

namespace SAAS\Http\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Companies\Actions\SetupCompanyAppAction;
use SAAS\Domain\Companies\DataTransferObjects\CompanyAppData;
use SAAS\Domain\Companies\Jobs\SetupApp;

class CompanyAppStoreRequest extends FormRequest
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
                'required',
                'numeric',
                Rule::exists('apps', 'id')->where('usable', true),
            ],
            'company_id' => [
                'nullable',
                'numeric',
                Rule::exists('companies', 'id'),
            ],
            'data' => [
                'nullable',
                'array',
            ],
        ];
    }

    /**
     * Setup the app for the company.
     *
     * @return \SAAS\Domain\Companies\Models\CompanyApp
     */
    public function setupApp()
    {
        $app = SetupCompanyAppAction::execute(
            CompanyAppData::fromRequest($this),
            $this->company
        );

        SetupApp::dispatch($app, $this->company);

        return $app;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = $this->input('data');
        $data['options'] = $this->input('options');

        $this->merge([
            'data' => $data,
        ]);
    }
}
