<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Playlist
 *
 * @package App
 */
class Playlist extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'genre',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_playlist', 'playlist_id', 'user_id');
    }
}
