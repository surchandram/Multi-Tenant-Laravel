<?php

namespace SAAS\App\Repositories\Eloquent\Criteria;

use SAAS\App\Repositories\Criteria\CriterionInterface;

class EagerLoad implements CriterionInterface
{
    /**
     * An array of relationships to be eager loaded.
     *
     * @var array
     */
    public $relations;

    /**
     * EagerLoad constructor.
     *
     * @return  void
     */
    public function __construct(array $relations)
    {
        $this->relations = $relations;
    }

    /**
     * Applies given logic to entity.
     *
     * @return mixed
     */
    public function apply($entity)
    {
        return $entity->with($this->relations);
    }
}
