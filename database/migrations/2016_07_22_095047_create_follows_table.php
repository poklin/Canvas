<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            // Edit 2 without an incremental id
            // $table->increments('id');
            $table->integer('follower_id')->unsigned();
            $table->integer('followee_id')->unsigned();
            $table->foreign('follower_id')->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('followee_id')->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Edit 2: with primary and unique constraint
            $table->primary(['follower_id', 'followee_id']);
            $table->unique(['follower_id', 'followee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
