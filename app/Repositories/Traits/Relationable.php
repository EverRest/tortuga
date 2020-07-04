<?php

namespace App\Repositories\Traits;

/**
 * Trait Relationable
 *
 * @package App\Repositories\Traits
 */
trait Relationable
{
    /**
     * @var array
     */
    public $relations = [];
    /**
     * @param  null  $relations
     */
    public function setRelations($relations = null)
    {
        $this->relations = $relations;
    }
}
