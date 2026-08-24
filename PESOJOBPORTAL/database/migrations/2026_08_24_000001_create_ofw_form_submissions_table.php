<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ofw_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('form_type', 20);
            $table->string('status', 30)->default('submitted');
            $table->string('pdf_path');
            $table->string('pdf_filename');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'form_type']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ofw_form_submissions');
    }
};
