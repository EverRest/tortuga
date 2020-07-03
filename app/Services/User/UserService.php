<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Repositories\User\IUserRepository;

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
     * @param  IUserRepository  $repository
     */
    public function __construct(IUserRepository $repository)
    {
        $this->repo = $repository;
    }
}
