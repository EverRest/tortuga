<?php

namespace App\Services\Playlist;

use App\Repositories\Playlist\IPlaylistRepository;
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
    public function __construct(IPlaylistRepository $repository)
    {
        $this->repo = $repository;
    }
}
