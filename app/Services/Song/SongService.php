<?php

namespace App\Services\Song;

use App\Services\BaseService;
use App\Repositories\Song\ISongRepository;

/**
 * Class SongService
 *
 * @package App\Services
 */
class SongService extends BaseService implements ISongService
{
    /**
     * SongService constructor.
     *
     * @param  ISongRepository  $repository
     */
    public function __construct(ISongRepository $repository)
    {
        $this->repo = $repository;
    }
}
