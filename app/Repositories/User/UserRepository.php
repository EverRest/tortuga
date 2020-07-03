<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Repositories\Traits\Sortable;
use App\User;

/**
 * Class UserRepository
 *
 * @package App\Repositories\User
 */
class UserRepository extends BaseRepository implements IUserRepository
{
    use Sortable;

    /**
     * @var User
     */
    protected $model;

    /**
     * SongRepository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
