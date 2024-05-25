<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectAuthorizationStoreRequest extends FormRequest
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
            'documents' => ['required', 'array', 'min:1'],
            'documents.*.document_id' => [
                'required',
                'integer',
                Rule::exists('tenant.documents', 'id')->where('usable', true),
            ],
            'documents.*.signature' => [
                'required',
                'base64image',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $project = $this->project;

        $this->merge([
            'id' => $project->id,
            'name' => $project->name,
            'type_id' => $project->type_id,
            'class_id' => $project->class_id,
            'category_id' => $project->category_id,
            'loss_occurred_at' => $project->loss_occurred_at,
            'contacted_at' => $project->contacted_at,
        ]);
    }
}
