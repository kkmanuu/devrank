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
    Schema::table('users', function (Blueprint $table) {
        $table->string('role', 20)->change();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role', 5)->change(); 
    });
}

};
