<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
