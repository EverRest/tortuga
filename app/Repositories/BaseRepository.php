<?php

namespace App\Repositories;

use App\Repositories\Traits\Relationable;
use App\Repositories\Traits\Sortable;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
abstract class BaseRepository
{
    use Sortable, Relationable;
    /**
     * @var string
     */
    public $sortBy = 'created_at';
    /**
     * @var string
     */
    public $sortOrder = 'asc';

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->with($this->relations)
            ->orderBy($this->sortBy, $this->sortOrder)->get();
    }

    /**
     * @param  int  $paginate
     *
     * @return mixed
     */
    public function paginated(int $paginate)
    {
        return $this->model->with($this->relations)
            ->orderBy($this->sortBy, $this->sortOrder)->paginate($paginate);
    }

    /**
     * @param  array  $input
     *
     * @return mixed
     */
    public function create(array $input)
    {
        $model = $this->model;
        $model->fill($input);
        $model->save();

        return $model;
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->with($this->relations)->where('id', $id)->first();
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    /**
     * @param  int    $id
     * @param  array  $input
     *
     * @return mixed
     */
    public function update(int $id, array $input)
    {
        $model = $this->find($id);
        $model->fill($input);
        $model->save();

        return $model;
    }

    /**
     * @param  int  $id
     *
     * @return bool
     */
    public function exists(int $id)
    {
        return !!$this->find($id);
    }
}
