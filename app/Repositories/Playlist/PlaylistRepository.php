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

    /**
     * @param  array  $input
     *
     * @return mixed|void
     */
    public function create(array $input)
    {
        $playlist = $this->model;
        $playlist->fill($input);
        $playlist->save();
        $playlist->songs()->sync($input['songs']);

        return $playlist;
    }

    /**
     * @param  int    $id
     * @param  array  $input
     *
     * @return mixed|void
     */
    public function update(int $id, array $input)
    {
        $playlist = $this->find($id);
        $playlist->fill($input);
        $playlist->save();
        $playlist->songs()->sync($input['songs']);

        return $playlist;
    }
}
