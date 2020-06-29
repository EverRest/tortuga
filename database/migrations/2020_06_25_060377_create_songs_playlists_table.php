<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('songs_playlists')){
            Schema::create(
                'songs_playlists', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('song_id')->unsigned()->index();
                $table->bigInteger('playlist_id')->unsigned()->index();
            });


            Schema::table('songs_playlists', function (Blueprint $table) {
                $table->foreign('song_id')->references('id')
                    ->on('songs')->onDelete('cascade');
                $table->foreign('playlist_id')->references('id')
                    ->on('playlists')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('songs_playlists', function (Blueprint $table) {
            $table->drop();
        });
    }
}
