<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixNotificationsTableColumns extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type');
            }
            if (!Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->string('notifiable_type');
            }
            if (!Schema::hasColumn('notifications', 'notifiable_id')) {
                $table->string('notifiable_id');
            }
            if (!Schema::hasColumn('notifications', 'data')) {
                $table->text('data');
            }
            if (!Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('data');
            }
            if (!Schema::hasColumn('notifications', 'created_at') || !Schema::hasColumn('notifications', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->dropColumn('notifiable_type');
            }
            if (Schema::hasColumn('notifications', 'notifiable_id')) {
                $table->dropColumn('notifiable_id');
            }
            if (Schema::hasColumn('notifications', 'data')) {
                $table->dropColumn('data');
            }
            if (Schema::hasColumn('notifications', 'read_at')) {
                $table->dropColumn('read_at');
            }
            if (Schema::hasColumn('notifications', 'created_at') && Schema::hasColumn('notifications', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
}
