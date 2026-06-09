<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->integer('queue_no')->nullable()->after('notes');
            $table->enum('queue_status', ['waiting', 'called', 'completed', 'cancelled'])->nullable()->after('queue_no');
            $table->timestamp('checked_in_at')->nullable()->after('queue_status');
            $table->timestamp('called_at')->nullable()->after('checked_in_at');
            $table->timestamp('completed_at')->nullable()->after('called_at');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'queue_no',
                'queue_status',
                'checked_in_at',
                'called_at',
                'completed_at',
            ]);
        });
    }
};