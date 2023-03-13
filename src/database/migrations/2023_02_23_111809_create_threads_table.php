<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('channel_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('body');
            $table->string('slug')->unique()->nullable();
            $table->integer('replies_count')->unsigned()->default(0);
            $table->integer('solved_flag')->unsigned()->default(0);
            $table->integer('like_flag')->unsigned()->default(0);
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
};
