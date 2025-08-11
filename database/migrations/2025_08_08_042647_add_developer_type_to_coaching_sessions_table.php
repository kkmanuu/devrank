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
    public function up(): void
{
    Schema::table('coaching_sessions', function (Blueprint $table) {
        $table->string('developer_type')->default('fresher')->after('type');
    });
}

public function down(): void
{
    Schema::table('coaching_sessions', function (Blueprint $table) {
        $table->dropColumn('developer_type');
    });
}

};
