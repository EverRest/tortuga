<?php

namespace App\Providers;

use App\Repositories\Song\ISongRepository;
use App\Repositories\Song\SongRepository;
use App\Services\Song\ISongService;
use App\Services\Song\SongService;
use Illuminate\Support\ServiceProvider;

/**
 * Class SongServiceProvider
 *
 * @package App\Providers
 */
class SongServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ISongRepository::class, SongRepository::class);
        $this->app->bind(ISongService::class, SongService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
