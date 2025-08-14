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
    Schema::table('payments', function (Blueprint $table) {
        $table->unsignedBigInteger('coaching_session_id')->nullable()->after('user_id');

        // Optional: add foreign key if you want
        $table->foreign('coaching_session_id')->references('id')->on('coaching_sessions')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropForeign(['coaching_session_id']);
        $table->dropColumn('coaching_session_id');
    });
}

};
