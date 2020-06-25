<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SongDetails
 *
 * @package App
 */
class SongDetails extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'song_id',
        'filename'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function song()
    {
        return $this->belongsTo('App\Song');
    }
}
