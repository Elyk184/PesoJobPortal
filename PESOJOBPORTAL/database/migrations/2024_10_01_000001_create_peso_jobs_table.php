<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesoJobsTable extends Migration
{
    public function up(): void
    {
        Schema::create('peso_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('employer_name');
            $table->string('location');
            $table->string('salary_range')->nullable();
            $table->text('requirements')->nullable();
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peso_jobs');
    }
}

