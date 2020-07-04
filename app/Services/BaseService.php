<?php

namespace App\Services;

/**
 * Class BaseService
 *
 * @package App\Service
 */
abstract class BaseService
{
    public $repo;

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repo->all();
    }

    /**
     * @return mixed
     */
    public function paginated()
    {
        return $this->repo->paginated(config('paginate'));
    }

    /**
     * @param  array  $input
     *
     * @return mixed
     */
    public function create(array $input)
    {
        return $this->repo->create($input);
    }

    /**
     * @param  int  $id
     */
    public function find(int $id)
    {
        return $this->repo->find($id);
    }

    /**
     * @param  int    $id
     * @param  array  $input
     *
     * @return mixed
     */
    public function update(int $id, array $input)
    {
        return $this->repo->update($id, $input);
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}
