<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Restore\Actions\UpdateProjectLogAction;
use SAAS\Domain\Restore\DataTransferObjects\ProjectLogData;

class ProjectLogUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->projectLog->user_id !== $this->user()->id) {
            return false;
        }

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
            'body' => ['required', 'string', 'max:5000'],
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'project_id' => [
                'required',
                Rule::exists('tenant.projects', 'id'),
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
            'project_id' => $project->id,
            'user_id' => $this->user()?->id,
        ]);
    }

    public function updateProjectLog()
    {
        return UpdateProjectLogAction::execute(ProjectLogData::fromRequest($this), $this->projectLog);
    }
}
