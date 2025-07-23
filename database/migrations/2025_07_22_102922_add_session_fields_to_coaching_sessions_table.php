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
            $table->date('session_date')->after('coach_id');
            $table->time('start_time')->after('session_date');
            $table->integer('capacity')->default(10)->after('start_time');
            
            $table->unsignedBigInteger('created_by')->nullable()->after('status');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('coaching_sessions', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['session_date', 'start_time', 'capacity',  'created_by']);
        });
    }
};
