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
    Schema::table('notifications', function (Blueprint $table) {
        $table->morphs('notifiable');
    });
}

public function down()
{
    Schema::table('notifications', function (Blueprint $table) {
        $table->dropMorphs('notifiable');
    });
}

};
