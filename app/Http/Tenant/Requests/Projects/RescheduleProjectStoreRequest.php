<?php

namespace SAAS\Http\Tenant\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class RescheduleProjectStoreRequest extends FormRequest
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
            'name' => ['present'],
            'loss_occurred_at' => ['nullable', 'date', 'before_or_equal:today'],
            'contacted_at' => ['nullable', 'date', 'after_or_equal:loss_occurred_at'],
            'starts_at' => ['required', 'date', 'after:contacted_at'],
            'ends_at' => ['nullable', 'date', 'after:contacted_at'],
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
