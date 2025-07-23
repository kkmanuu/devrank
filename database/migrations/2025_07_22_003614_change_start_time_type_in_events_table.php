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
    Schema::table('events', function (Blueprint $table) {
        $table->time('start_time')->change(); 
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dateTime('start_time')->change(); 
    });
}

};
