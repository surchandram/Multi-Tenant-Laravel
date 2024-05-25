<?php

namespace SAAS\Domain\Restore\Builders;

use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Shared\Filters\DateFilter;

class ProjectBuilder extends Builder
{
    public function whereCreatedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween(
            'created_at',
            $dateFilter->toArray()
        );
    }

    public function whereStatus(array $statuses): self
    {
        return $this->whereHas('status', function (Builder $query) use ($statuses) {
            $query->whereIn('slug', $statuses);
        });
    }

    public function whereStatusNot(array $statuses): self
    {
        return $this->whereHas('status', function (Builder $query) use ($statuses) {
            $query->whereNotIn('slug', $statuses);
        });
    }

    public function whereTeamOnAssignment(): self
    {
        return $this->whereNotNull('team_id')
            ->whereStatus([
                ProjectStatuses::Ongoing,
            ]);
    }

    public function whereOwnedByUser($user): self
    {
        return $this->whereNotNull('user_id')
            ->where('user_id', ! is_numeric($user) ? optional($user)->id : $user);
    }
}
