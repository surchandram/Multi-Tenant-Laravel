<?php

namespace SAAS\App\Filters\Ordering;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Miracuthbert\Filters\FilterAbstract;
use SAAS\App\Filters\FilterExtensionTrait;

class SortFilter extends FilterAbstract
{
    use FilterExtensionTrait;

    protected function filterColumnsMapping()
    {
        return [
            'name_order' => 'first_name',
            'email_order' => 'email',
            'team_count_order' => 'team_count',
            'email_verified_at_order' => 'email_verified_at',
        ];
    }

    protected function resolveColumnFromKey(string $filterKey): string
    {
        $map = $this->filterColumnsMapping();

        $default = Str::replaceLast('_order', '', $filterKey);

        return Arr::get($map, $filterKey, $default);
    }

    /**
     * Apply filter to order results by given column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value, $filterKey = null)
    {
        $sortKey = is_array($value) ? $value['key'] : $filterKey;
        $sortValue = is_array($value) ? $value['value'] : $value;

        $column = $this->resolveColumnFromKey($sortKey);

        if (! in_array($column, ['asc', 'desc'])) {
            return $builder;
        }

        return $builder->orderBy(
            $column, $this->resolveOrderDirection($sortValue)
        );
    }
}
