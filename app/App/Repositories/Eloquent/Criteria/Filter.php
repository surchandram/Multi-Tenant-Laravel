<?php

namespace SAAS\App\Repositories\Eloquent\Criteria;

use Illuminate\Http\Request;
use SAAS\App\Repositories\Criteria\CriterionInterface;

class Filter implements CriterionInterface
{
    /**
     * Instance of request.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Filter constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Applies given logic to entity.
     *
     * @return mixed
     */
    public function apply($entity)
    {
        return $entity->filter($this->request);
    }
}
