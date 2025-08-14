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
        $table->integer('capacity')->default(0); // add default if needed
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('capacity');
    });
}

};
