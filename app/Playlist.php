<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Playlist
 *
 * @package App
 */
class Playlist extends Model
{
    use SoftDeletes;
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'users_playlists', 'playlist_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs()
    {
        return $this->belongsToMany('App\Song', 'songs_playlists', 'playlist_id', 'song_id');
    }
}
