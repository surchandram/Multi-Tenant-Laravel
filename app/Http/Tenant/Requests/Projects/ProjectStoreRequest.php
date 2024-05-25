<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Tenant\Enums\OrganizationType;

class ProjectStoreRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('insurance.company.name')) {
            $insurance = $this->insurance;
            $insurance['company']['type'] = OrganizationType::Insurance->value;

            $this->merge([
                'insurance' => $insurance,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'type_id' => ['required', 'exists:tenant.project_types,id'],
            'description' => ['nullable', 'max:100'],
            'overview' => ['nullable', 'max:5000'],
            'point_of_loss' => ['nullable', 'string'],
            'category_id' => [
                'required',
                'numeric',
                Rule::exists('tenant.project_categories', 'id')->where('usable', true),
            ],
            'class_id' => [
                'required',
                'numeric',
                Rule::exists('tenant.project_classes', 'id')->where('usable', true),
            ],
            'loss_occurred_at' => ['nullable', 'date', 'before_or_equal:today'],
            'contacted_at' => ['nullable', 'date', 'after_or_equal:loss_occurred_at'],
            'starts_at' => ['nullable', 'date', 'after_or_equal:contacted_at'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'team_id' => [
                'nullable',
                'numeric',
                Rule::exists('teams', 'id')
                    ->where('usable', true)
                    ->where('teamable_id', request()->tenant()->id)
                    ->where('teamable_type', get_class(request()->tenant())),
            ],
            'affected_areas' => [
                'nullable',
                'array',
            ],
            'affected_areas.*' => [
                'min:1',
                'string',
            ],
            'address' => ['array', 'exclude_if:address.name,null'],
            'address.name' => ['nullable', 'string'],
            'address.address_1' => [
                'nullable',
                'string',
                'exclude_without:address.name',
            ],
            'address.address_2' => [
                'nullable',
                'string',
                'exclude_without:address.name',
            ],
            'address.state' => [
                'nullable',
                'string',
                'exclude_without:address.address_1',
            ],
            'address.city' => [
                'nullable',
                'string',
                'exclude_without:address.address_1',
            ],
            'address.postal_code' => [
                'nullable',
                'min:2',
                'exclude_without:address.address_1',
            ],
            'address.country_id' => [
                'required_unless:address.address_1,null',
                'numeric',
                'exclude_without:address.address_1',
                Rule::exists('countries', 'id')->where('usable', true),
            ],
            'insurance' => ['nullable', 'array', 'exclude_if:insurance.company.name,null'],
            'insurance.company.name' => ['nullable', 'string'],
            'insurance.company.type' => ['nullable', 'string'],
            'insurance.company.email' => ['nullable', 'string', 'email', 'required_unless:insurance.company.name,null'],
            'insurance.company.phone' => ['nullable', 'numeric', 'required_unless:insurance.company.name,null'],
            'insurance.agent' => ['nullable', 'array', 'exclude_if:insurance.agent.name,null'],
            'insurance.agent.name' => ['nullable', 'string'],
            'insurance.agent.email' => ['nullable', 'string', 'email', 'required_unless:insurance.agent.name,null'],
            'insurance.agent.phone' => ['nullable', 'numeric', 'required_unless:insurance.agent.name,null'],
            'insurance.adjuster' => ['nullable', 'array', 'exclude_if:insurance.adjuster.name,null'],
            'insurance.adjuster.name' => ['nullable', 'string'],
            'insurance.adjuster.email' => ['nullable', 'string', 'email', 'required_unless:insurance.adjuster.name,null'],
            'insurance.adjuster.phone' => ['nullable', 'numeric', 'required_unless:insurance.adjuster.name,null'],
            'insurance.claim_no' => [
                'nullable',
                'required_unless:insurance.company.name,null',
                'string',
                Rule::unique('tenant.project_insurance', 'claim_no')->ignore(
                    $this->insurance['id'] ?? null
                ),
            ],
            'insurance.policy_no' => ['nullable', 'string'],
            'insurance.deductible' => [
                'nullable',
                'exclude_without:insurance.company.name',
                'integer',
                'max_digits:8',
            ],
            'owner.name' => ['required', 'string'],
            'owner.email' => ['required', 'string', 'email'],
            'owner.phone' => ['required', 'numeric'],
            'owner.address' => ['array', 'exclude_if:owner.address.name,null'],
            'owner.address.id' => ['nullable', 'exclude_if:owner.name,null'],
            'owner.address.name' => ['nullable', 'string'],
            'owner.address.default' => ['nullable', 'boolean', 'exclude_without:owner.address.name'],
            'owner.address.billing' => ['nullable', 'boolean', 'exclude_without:owner.address.name'],
            'owner.address.address_1' => [
                'nullable',
                'string',
                'exclude_without:owner.address.name',
            ],
            'owner.address.address_2' => [
                'nullable',
                'string',
                'exclude_without:owner.address.address_1',
            ],
            'owner.address.state' => [
                'nullable',
                'string',
                'exclude_without:owner.address.address_1',
            ],
            'owner.address.city' => [
                'nullable',
                'string',
                'exclude_without:owner.address.address_1',
            ],
            'owner.address.postal_code' => [
                'nullable',
                'min:2',
                'exclude_without:owner.address.address_1',
            ],
            'owner.address.country_id' => [
                'required_unless:address.address_1,null',
                'numeric',
                'exclude_without:owner.address.address_1',
                Rule::exists('countries', 'id')->where('usable', true),
            ],
            'documents' => ['nullable', 'array'],
            'documents.*' => [
                'nullable',
                Rule::exists('tenant.documents', 'id')->where('usable', true),
            ],
        ];
    }
}
