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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('status');
            $table->string('email')->nullable()->after('full_name');
            $table->text('question')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'email', 'question']);
        });
    }
};
