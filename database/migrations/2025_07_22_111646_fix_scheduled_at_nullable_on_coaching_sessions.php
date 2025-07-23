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
            $table->dropColumn('scheduled_at');
        });

        Schema::table('coaching_sessions', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('coaching_sessions', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
        });

        Schema::table('coaching_sessions', function (Blueprint $table) {
            $table->timestamp('scheduled_at');
        });
    }
};
