<?php

namespace SAAS\App\Repositories\Eloquent\Criteria;

use SAAS\App\Repositories\Criteria\CriterionInterface;

class Scopes implements CriterionInterface
{
    /**
     * An array of scopes to apply.
     *
     * @var array
     */
    public $scopes;

    /**
     * Scopes constructor.
     *
     * @return void
     */
    public function __construct(array $scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * Applies given logic to entity.
     *
     * @return mixed
     */
    public function apply($entity)
    {
        foreach ($this->scopes as $index => $scope) {
            if (is_numeric($index)) {
                $entity = $entity->{$scope}();
            } else {
                if (is_array($scope)) {
                    $entity = $entity->{$index}(...$scope);
                } else {
                    $entity = $entity->{$index}($scope);
                }
            }
        }

        return $entity;
    }
}
