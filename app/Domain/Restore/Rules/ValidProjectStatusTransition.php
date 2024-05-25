<?php

namespace SAAS\Domain\Restore\Rules;

use Illuminate\Contracts\Validation\Rule;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Models\Project;

class ValidProjectStatusTransition implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Project $project
    ) {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $enum = ProjectStatuses::tryFrom($value);

        if (! filled($enum)) {
            return false;
        }

        return $this->project->currentStatus->hasNoPriorityOver($enum) == true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('tenant.project.status_transition_failed');
    }
}
