<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 *
 * @package App
 */
class PasswordReset extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'email', 'token'
    ];
}
