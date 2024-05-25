<?php

namespace SAAS\App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use SAAS\App\Repositories\Contracts\RepositoryInterface;
use SAAS\App\Repositories\Criteria\CriteriaInterface;
use SAAS\App\Repositories\Criteria\CriterionInterface;
use SAAS\App\Repositories\Exceptions\NoEntityDefinedException;

abstract class RepositoryAbstract implements RepositoryInterface, CriteriaInterface
{
    /**
     * A model or resource that repository should be queried against.
     *
     * @return string
     */
    protected $entity;

    /**
     * RepositoryAbstract constructor.
     */
    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    /**
     * Get all records for a given entity.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->entity->get();
    }

    /**
     * Find a record by given "id".
     *
     * @return mixed
     */
    public function find($id)
    {
        $model = $this->entity->find($id);

        if (! $model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()), $id
            );
        }

        return $model;
    }

    /**
     * Find a record by given "id" or return its model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findFirst($value)
    {
        if (is_numeric($value)) {
            return $this->entity->find($value);
        }

        if (! $value instanceof $this->entity) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()), optional($value)->id
            );
        }

        return $value;
    }

    /**
     * Find records by given "column" value.
     *
     * @return mixed
     */
    public function findWhere($column, $value)
    {
        return $this->entity->where($column, $value)->get();
    }

    /**
     * Find the first record with given "column" value.
     *
     * @return mixed
     */
    public function findWhereFirst($column, $value)
    {
        $model = $this->entity->where($column, $value)->first();

        if (! $model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel())
            );
        }

        return $model;
    }

    /**
     * Paginate records for a given entity.
     *
     * @param  int  $perPage
     * @return mixed
     */
    public function paginate($perPage = 10)
    {
        return $this->entity->paginate($perPage);
    }

    /**
     * Create a record for a given entity.
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Update a record of a given entity.
     *
     * @param  int  $id
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->find($id)->update($data);
    }

    /**
     * Delete a record from an entity.
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Refines a repository's query.
     *
     * @param  array  ...$criteria [relationships, scopes, filters]
     * @return \SAAS\App\Repositories\RepositoryAbstract
     */
    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);

        $criteria = Arr::where($criteria, function ($criterion) {
            return $criterion instanceof CriterionInterface;
        });

        foreach ($criteria as $criterion) {
            $this->entity = $criterion->apply($this->entity);
        }

        return $this;
    }

    /**
     * Resolve's the repository's entity.
     *
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \SAAS\App\Repositories\Exceptions\NoEntityDefinedException
     */
    protected function resolveEntity()
    {
        if (! method_exists($this, 'entity')) {
            throw new NoEntityDefinedException('No entity defined.');
        }

        return app()->make($this->entity());
    }
}
