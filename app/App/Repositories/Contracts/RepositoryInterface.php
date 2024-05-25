<?php

namespace SAAS\App\Repositories\Contracts;

interface RepositoryInterface
{
    /**
     * Get all records for a given entity.
     *
     * @return mixed
     */
    public function all();

    /**
     * Find a record by given "id".
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Find records by given "column" value.
     *
     * @return mixed
     */
    public function findWhere($column, $value);

    /**
     * Find the first record with given "column" value.
     *
     * @return mixed
     */
    public function findWhereFirst($column, $value);

    /**
     * Paginate records for a given entity.
     *
     * @param  int  $perPage
     * @return mixed
     */
    public function paginate($perPage = 10);

    /**
     * Create a record for a given entity.
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a record for an entity.
     *
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a record from an entity.
     *
     * @return mixed
     */
    public function delete($id);
}
