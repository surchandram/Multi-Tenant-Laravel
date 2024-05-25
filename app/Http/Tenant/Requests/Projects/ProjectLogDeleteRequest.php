<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Restore\Actions\DestroyProjectLogAction;

class ProjectLogDeleteRequest extends FormRequest
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
            'project_log_id' => [
                'required',
                Rule::exists('tenant.project_logs', 'id'),
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
        $projectLog = $this->projectLog;

        $this->merge([
            'project_log_id' => $projectLog->id,
        ]);
    }

    public function deleteLog()
    {
        return DestroyProjectLogAction::execute($this->projectLog);
    }
}
