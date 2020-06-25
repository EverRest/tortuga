<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users_playlists')){
            Schema::create(
                'users_playlists', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('playlist_id')->index();
            });


            Schema::table('users_playlists', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');
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
        Schema::table('users_playlists', function (Blueprint $table) {
            $table->drop();
        });
    }
}
