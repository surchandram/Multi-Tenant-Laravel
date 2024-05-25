<?php

namespace SAAS\App\Repositories\Criteria;

interface CriterionInterface
{
    /**
     * Applies given logic to entity.
     *
     * @return mixed
     */
    public function apply($entity);
}
