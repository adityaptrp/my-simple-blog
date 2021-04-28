<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title', 191);
            $table->string('slug', 191);
            $table->string('subtitle', 191)->nullable();
            $table->text('header');
            $table->text('body');
            $table->text('footer')->nullable();
            $table->string('quote', 191)->nullable();
            $table->string('quote_author', 100)->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('sub_thumbnail1')->nullable();
            $table->string('sub_thumbnail2')->nullable();
            $table->string('youtube_link', 100)->nullable();
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
        Schema::dropIfExists('posts');
    }
}
