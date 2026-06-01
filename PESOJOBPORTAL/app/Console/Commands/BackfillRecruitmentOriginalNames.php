<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\RecruitmentActivityRequest;

class BackfillRecruitmentOriginalNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recruitment:backfill-original-names {--commit : Persist changes to the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill original uploaded filenames for recruitment activity requests (preview or commit).';

    public function handle(): int
    {
        $fields = [
            ['path' => 'letter_of_intent_path', 'orig' => 'letter_of_intent_original_name'],
            ['path' => 'dmw_certificate_path', 'orig' => 'dmw_certificate_original_name'],
            ['path' => 'recruitment_officer_id_path', 'orig' => 'recruitment_officer_id_original_name'],
            ['path' => 'job_order_balance_path', 'orig' => 'job_order_balance_original_name'],
            ['path' => 'deployment_report_path', 'orig' => 'deployment_report_original_name'],
            ['path' => 'affidavit_undertaking_path', 'orig' => 'affidavit_undertaking_original_name'],
            ['path' => 'sra_authority_file_path', 'orig' => 'sra_authority_file_original_name'],
            ['path' => 'business_permit_path', 'orig' => 'business_permit_original_name'],
            ['path' => 'lra_recruitment_officer_id_path', 'orig' => 'lra_recruitment_officer_id_original_name'],
            ['path' => 'job_vacancies_path', 'orig' => 'job_vacancies_original_name'],
        ];

        $previewOnly = ! $this->option('commit');
        $this->info($previewOnly ? 'Preview mode — no DB changes will be made.' : 'Commit mode — changes will be saved.');

        $records = RecruitmentActivityRequest::all();
        $changes = 0;
        foreach ($records as $r) {
            $rowChanges = [];
            foreach ($fields as $f) {
                $path = $r->{$f['path']} ?? null;
                $orig = $r->{$f['orig']} ?? null;

                if ($path && ! $orig) {
                    // Try to determine original name: prefer stored original_name if embedded, else basename
                    $candidate = basename($path);

                    // If file exists on public or default disk, we still use basename as fallback
                    if (Storage::disk('public')->exists($path) || Storage::disk(config('filesystems.default'))->exists($path)) {
                        // keep candidate
                    }

                    $rowChanges[$f['orig']] = $candidate;
                }
            }

            if (! empty($rowChanges)) {
                $changes += count($rowChanges);
                $this->line("ID {$r->id}: will set " . implode(', ', array_map(fn($k, $v) => "{$k}='{$v}'", array_keys($rowChanges), $rowChanges)));
                if (! $previewOnly) {
                    foreach ($rowChanges as $col => $val) {
                        $r->{$col} = $val;
                    }
                    $r->save();
                }
            }
        }

        $this->info("Processed {$records->count()} records; prepared {$changes} original filename values.");
        if ($previewOnly) {
            $this->info('Run with --commit to persist these values.');
        }

        return 0;
    }
}
