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
        if (!Schema::hasColumn('contact_messages', 'name')) {
            $table->string('name');
        }
        if (!Schema::hasColumn('contact_messages', 'email')) {
            $table->string('email');
        }
        if (!Schema::hasColumn('contact_messages', 'company')) {
            $table->string('company')->nullable();
        }
        if (!Schema::hasColumn('contact_messages', 'message')) {
            $table->text('message');
        }
        if (!Schema::hasColumn('contact_messages', 'is_read')) {
            $table->boolean('is_read')->default(false);
        }
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'company', 'message', 'is_read']);
        });
    }
};
