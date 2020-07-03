<?php

namespace App\Services\Song;

use App\Services\BaseService;

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
     * @param  SongRepository  $repository
     */
    public function __construct(SongRepository $repository)
    {
        $this->repo = $repository;
    }
}
