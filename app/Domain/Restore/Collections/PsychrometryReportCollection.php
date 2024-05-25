<?php

namespace SAAS\Domain\Restore\Collections;

use Illuminate\Database\Eloquent\Collection;

class PsychrometryReportCollection extends Collection
{
    public function asDateTree()
    {
        return $this->groupBy(
            fn ($model) => $model->recorded_at->format('Y-m-d')
        )->map(
            fn ($group) => $group->groupBy('affectedArea.affectedArea.name')
                ->map(
                    fn ($affectedAreasMap) => $affectedAreasMap->keyBy('psychrometryMeasurePoint.name')
                )
        );
    }

    public function areaBasedTree()
    {
        return $this->groupBy(
            fn ($model) => $model->affectedArea->affectedArea->name
        )->map(
            fn ($group) => $group->groupBy(
                fn ($model) => $model->recorded_at->format('Y-m-d')
            )
                ->map(
                    fn ($affectedAreasMap) => $affectedAreasMap->keyBy('psychrometryMeasurePoint.name')
                )
        );
    }
}
