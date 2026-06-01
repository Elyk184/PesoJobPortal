<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobseeker_disability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('visual')->default(false);
            $table->boolean('speech')->default(false);
            $table->boolean('mental')->default(false);
            $table->boolean('hearing')->default(false);
            $table->boolean('physical')->default(false);
            $table->boolean('other')->default(false);
            $table->string('other_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobseeker_disability');
    }
};
