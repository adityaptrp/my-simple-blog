<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio')->nullable()->after('password');
            $table->string('instagram')->nullable()->after('bio');
            $table->string('twitter')->nullable()->after('instagram');
            $table->string('facebook')->nullable()->after('twitter');
            $table->string('website')->nullable()->after('facebook');
            $table->string('youtube_link_id')->nullable()->after('website');
            $table->string('profile_picture')->nullable()->after('youtube_link_id');
            $table->unsignedBigInteger('count_likes')->nullable()->default(0)->after('profile_picture');
            $table->string('banner')->nullable()->after('profile_picture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bio');
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('facebook');
            $table->dropColumn('website');
            $table->dropColumn('youtube_link_id');
            $table->dropColumn('profile_picture');
            $table->dropColumn('count_likes');
            $table->dropColumn('banner');
        });
    }
}
