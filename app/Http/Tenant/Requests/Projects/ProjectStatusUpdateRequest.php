<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Restore\Actions\ChangeProjectStatusAction;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Rules\ValidProjectStatusTransition;

class ProjectStatusUpdateRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
                Rule::in(array_column(ProjectStatuses::cases(), 'value')),
                new ValidProjectStatusTransition($this->project),
            ],
        ];
    }

    /**
     * Update project status.
     *
     * @return \SAAS\Domain\Restore\Models\Project
     */
    public function updateStatus()
    {
        return ChangeProjectStatusAction::execute($this->project, $this->tenant(), $this->status);
    }
}
