<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('songs')) {

            Schema::create('songs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->index();
                $table->string('title', 255)->default('Unknown');
                $table->string('artist', 255)->default('Unknown');
                $table->string('filename', 255)->unique();
                $table->timestamps();
            });

            Schema::table('songs', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade');
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
        Schema::table('songs', function (Blueprint $table) {
            $table->drop();
        });
    }
}
