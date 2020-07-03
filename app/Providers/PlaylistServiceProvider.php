<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Playlist\IPlaylistRepository;
use App\Services\Playlist\PlaylistService;
use App\Services\Playlist\IPlaylistService;
use App\Repositories\Playlist\PlaylistRepository;

/**
 * Class PlaylistServiceProvider
 *
 * @package App\Providers
 */
class PlaylistServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IPlaylistRepository::class, PlaylistRepository::class);
        $this->app->bind(IPlaylistService::class, PlaylistService::class);
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
