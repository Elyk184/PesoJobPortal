<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_submissions', 'reference_code')) {
                $table->string('reference_code', 40)->nullable()->unique()->after('id');
            }

            if (! Schema::hasColumn('contact_submissions', 'status')) {
                $table->string('status', 20)->default('open')->after('message');
            }

            if (! Schema::hasColumn('contact_submissions', 'last_message_at')) {
                $table->timestamp('last_message_at')->nullable()->after('status');
            }

            if (! Schema::hasColumn('contact_submissions', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('last_message_at');
            }
        });

        if (! Schema::hasTable('contact_submission_messages')) {
            Schema::create('contact_submission_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('contact_submission_id')->constrained('contact_submissions')->cascadeOnDelete();
                $table->enum('sender_type', ['user', 'admin']);
                $table->text('message');
                $table->foreignId('sent_by_user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();

                $table->index(['contact_submission_id', 'created_at'], 'csm_submission_created_idx');
            });
        }

        $submissions = DB::table('contact_submissions')->orderBy('id')->get();

        foreach ($submissions as $submission) {
            $referenceCode = $submission->reference_code ?: sprintf('INQ-%s-%06d', now()->format('Y'), $submission->id);

            DB::table('contact_submissions')
                ->where('id', $submission->id)
                ->update([
                    'reference_code' => $referenceCode,
                    'status' => $submission->status ?: 'open',
                    'last_message_at' => $submission->last_message_at ?: $submission->created_at,
                ]);

            $hasMessage = DB::table('contact_submission_messages')
                ->where('contact_submission_id', $submission->id)
                ->exists();

            if (! $hasMessage) {
                DB::table('contact_submission_messages')->insert([
                    'contact_submission_id' => $submission->id,
                    'sender_type' => 'user',
                    'message' => $submission->message,
                    'sent_by_user_id' => null,
                    'created_at' => $submission->created_at,
                    'updated_at' => $submission->created_at,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submission_messages');

        Schema::table('contact_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('contact_submissions', 'reference_code')) {
                $table->dropColumn('reference_code');
            }

            if (Schema::hasColumn('contact_submissions', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('contact_submissions', 'last_message_at')) {
                $table->dropColumn('last_message_at');
            }

            if (Schema::hasColumn('contact_submissions', 'replied_at')) {
                $table->dropColumn('replied_at');
            }
        });
    }
};