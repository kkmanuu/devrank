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
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->boolean('newsletter')->default(false)->after('is_read');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['phone', 'newsletter']);
        });
    }
};
