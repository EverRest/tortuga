<?php

namespace App\Services\Playlist;

use App\Services\BaseService;

/**
 * Class PlaylistService
 *
 * @package App\Services\Playlist
 */
class PlaylistService extends BaseService implements IPlaylistService
{
    /**
     * SongService constructor.
     *
     * @param    $repository
     */
    public function __construct(SongRepository $repository)
    {
        $this->repo = $repository;
    }
}
