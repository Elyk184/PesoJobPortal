<?php

namespace App\Console\Commands;

use App\Models\PesoJob;
use Illuminate\Console\Command;

class ArchiveExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:archive-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive active job postings whose application deadline has passed.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $archivedCount = PesoJob::archiveExpiredPostings();

        $this->info(sprintf('Archived %d expired job posting(s).', $archivedCount));

        return self::SUCCESS;
    }
}
