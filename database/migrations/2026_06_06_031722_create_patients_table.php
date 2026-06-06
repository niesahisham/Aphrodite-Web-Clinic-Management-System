<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code')->unique();
            $table->string('full_name');
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('allergies')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};