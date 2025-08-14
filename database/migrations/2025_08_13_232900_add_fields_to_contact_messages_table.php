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
    Schema::table('contact_messages', function (Blueprint $table) {
        $table->string('status')->default('pending')->after('message'); // pending, replied, etc.
        $table->string('priority')->default('low')->after('status');   // low, medium, high          // admin reply
        $table->timestamp('replied_at')->nullable()->after('reply');    // when replied
        // who replied
    });
}
    public function down()
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['status', 'priority' , 'replied_at', ]);
        });
    }

};
