<?php

namespace App\Repositories\Playlist;

use App\Repositories\BaseRepository;
use App\Repositories\Traits\Sortable;
use App\Playlist;

/**
 * Class PlaylistRepository
 *
 * @package App\Repositories\Playlist
 */
class PlaylistRepository extends BaseRepository implements IPlaylistRepository
{
    use Sortable;

    /**
     * @var Playlist
     */
    protected $model;

    /**
     * PlaylistRepository constructor.
     *
     * @param  Playlist  $song
     */
    public function __construct(Playlist $playlist)
    {
        $this->model = $playlist;
    }
}
