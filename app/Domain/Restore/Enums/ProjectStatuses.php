<?php

namespace SAAS\Domain\Restore\Enums;

use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\States\ApprovedProjectStatus;
use SAAS\Domain\Restore\States\PendingProjectStatus;

enum ProjectStatuses: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Approved = 'approved';
    case Ongoing = 'ongoing';
    case ApproveCompletion = 'approve_completion';
    case Invoiced = 'invoiced';
    case Paid = 'paid';
    case PaymentFailed = 'payment_failed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Ongoing => 'Ongoing',
            self::ApproveCompletion => 'Approve Completion',
            self::Invoiced => 'Invoiced',
            self::Paid => 'Paid',
            self::PaymentFailed => 'Payment Failed',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function mail(): string
    {
        return match ($this) {
            self::Approved => __('tenant.project.status_mail.approved'),
            self::Ongoing => __('tenant.project.status_mail.ongoing'),
            self::ApproveCompletion => __('tenant.project.status_mail.approve_completion'),
            self::Invoiced => __('tenant.project.status_mail.invoiced'),
            self::Paid => __('tenant.project.status_mail.paid'),
            self::PaymentFailed => __('tenant.project.status_mail.payment_failed'),
            self::Completed => __('tenant.project.status_mail.completed'),
            self::Cancelled => __('tenant.project.status_mail.cancelled'),
        };
    }

    public function createProjectStatus(Project $project)
    {
        return match ($this) {
            ProjectStatuses::Pending => new PendingProjectStatus($project),
            ProjectStatuses::Approved => new ApprovedProjectStatus($project),
        };
    }

    public function hasPriorityOver(ProjectStatuses $status): bool
    {
        $currentPriorityLevel = $this->findPriorityLevel($this);

        $targetPriority = $this->findPriorityLevel($status);

        return $currentPriorityLevel > $targetPriority;

    }

    public function hasNoPriorityOver(ProjectStatuses $status): bool
    {
        $currentPriorityLevel = $this->findPriorityLevel($this);

        $targetPriority = $this->findPriorityLevel($status);

        return $currentPriorityLevel < $targetPriority;
    }

    public function is(ProjectStatuses $status)
    {
        return $this->value == $status->value;
    }

    public function priorityLevel()
    {
        $key = array_search($this->value, array_column(self::cases(), 'value'));

        return $key;
    }

    protected function findPriorityLevel(ProjectStatuses $status)
    {
        $key = array_search($status->value, array_column(self::cases(), 'value'));

        return $key;
    }
}
