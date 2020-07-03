<?php

namespace App\Repositories\Traits;

/**
 * Trait Sortable
 *
 * @package App\Repositories\Traits
 */
trait Sortable
{
    /**
     * @var string
     */
    public $sortBy = 'created_at';

    /**
     * @var string
     */
    public $sortOrder = 'asc';

    /**
     * @param  string  $sortBy
     */
    public function setSortBy( string $sortBy='created_at')
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @param  string  $sortOrder
     */
    public function setSortOrder(string $sortOrder='desc')
    {
        $this->sortOrder = $sortOrder;
    }
}
