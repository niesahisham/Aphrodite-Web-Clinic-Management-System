<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'queue_no')) {
                $table->integer('queue_no')->nullable()->after('notes');
            }

            if (!Schema::hasColumn('appointments', 'queue_status')) {
                $table->enum('queue_status', ['waiting', 'called', 'completed', 'cancelled'])->nullable()->after('queue_no');
            }

            if (!Schema::hasColumn('appointments', 'checked_in_at')) {
                $table->timestamp('checked_in_at')->nullable()->after('queue_status');
            }

            if (!Schema::hasColumn('appointments', 'called_at')) {
                $table->timestamp('called_at')->nullable()->after('checked_in_at');
            }

            if (!Schema::hasColumn('appointments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('called_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'completed_at')) {
                $table->dropColumn('completed_at');
            }

            if (Schema::hasColumn('appointments', 'called_at')) {
                $table->dropColumn('called_at');
            }

            if (Schema::hasColumn('appointments', 'checked_in_at')) {
                $table->dropColumn('checked_in_at');
            }

            if (Schema::hasColumn('appointments', 'queue_status')) {
                $table->dropColumn('queue_status');
            }

            if (Schema::hasColumn('appointments', 'queue_no')) {
                $table->dropColumn('queue_no');
            }
        });
    }
};