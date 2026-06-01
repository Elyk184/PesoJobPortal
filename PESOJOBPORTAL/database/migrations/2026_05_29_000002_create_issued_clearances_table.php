<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('issued_clearances')) {
            return;
        }

        Schema::create('issued_clearances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peso_clearance_id')->constrained('peso_clearances')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('clearance_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('residence_address')->nullable();
            $table->string('document_path')->nullable();
            $table->string('status')->default('saved');
            $table->dateTime('issued_at')->nullable();
            $table->timestamps();

            $table->index(['peso_clearance_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issued_clearances');
    }
};