<?php

namespace App\Repositories\Song;

use App\Repositories\BaseRepository;
use App\Repositories\Traits\Sortable;
use App\Song;

/**
 * Class SongRepository
 *
 * @package App\Repositories\Song
 */
class SongRepository extends BaseRepository implements ISongRepository
{
    use Sortable;

    /**
     * @var Song
     */
    protected $model;

    /**
     * SongRepository constructor.
     *
     * @param  Song  $song
     */
    public function __construct(Song $song)
    {
        $this->model = $song;
    }
}
