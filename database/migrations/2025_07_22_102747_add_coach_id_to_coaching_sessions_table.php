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
    Schema::table('coaching_sessions', function (Blueprint $table) {
        $table->unsignedBigInteger('coach_id')->after('topic');
        $table->foreign('coach_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('coaching_sessions', function (Blueprint $table) {
        $table->dropForeign(['coach_id']);
        $table->dropColumn('coach_id');
    });
}

};
