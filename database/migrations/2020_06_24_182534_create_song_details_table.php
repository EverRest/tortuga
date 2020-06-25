<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('song_id')->unsigned()->index();
            $table->string('filename');
            $table->timestamps();
        });

        Schema::table('song_details', function (Blueprint $table) {
            $table->foreign('song_id')->references('id')->on('songs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('song_details', function (Blueprint $table) {
            $table->dropForeign(['song_id']);
            $table->drop();
        });
    }
}
