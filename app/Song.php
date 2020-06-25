<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Song
 *
 * @package App
 */
class Song extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'user_id',
        'artist'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
