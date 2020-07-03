<?php

namespace App\Services\User;

use App\Services\BaseService;

/**
 * Class UserService
 *
 * @package App\Services\User
 */
class UserService extends BaseService implements IUserService
{
    /**
     * UserService constructor.
     *
     * @param  UserRepository  $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }
}
