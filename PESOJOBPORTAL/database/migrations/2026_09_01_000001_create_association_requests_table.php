<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('association_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->text('details');
            $table->string('association_name');
            $table->string('contact_person');
            $table->string('contact_number', 50);
            $table->string('email')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('request_type', 100);
            $table->string('document_path')->nullable();
            $table->string('status', 50)->default('open');
            $table->json('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('association_requests');
    }
};
