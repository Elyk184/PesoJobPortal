<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('course')->nullable();
            $table->unsignedSmallInteger('hours')->nullable();
            $table->string('institution')->nullable();
            $table->string('inclusive_dates', 100)->nullable();
            $table->text('skills_acquired')->nullable();
            $table->string('certificates')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_training');
    }
};
