<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GitCommit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:commit {message? : The commit message}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Automatically stage all changes and commit with a message';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $message = $this->argument('message');

        // Generate default message if not provided
        if (!$message) {
            $message = 'Auto-commit: ' . now()->format('Y-m-d H:i:s');
        }

        $this->info('📦 Staging all changes...');

        // Stage all changes
        $addProcess = Process::fromShellCommandline('git add .');
        $addProcess->run();

        if (!$addProcess->isSuccessful()) {
            $this->error('❌ Failed to stage changes');
            return 1;
        }

        // Check if there are staged changes
        $statusProcess = Process::fromShellCommandline('git diff --cached --name-only');
        $statusProcess->run();
        $stagedFiles = trim($statusProcess->getOutput());

        if (empty($stagedFiles)) {
            $this->warn('✅ No changes to commit');
            return 0;
        }

        $stagedCount = count(array_filter(explode("\n", $stagedFiles)));
        $this->info("📝 Committing $stagedCount changed files...");

        // Commit changes
        $commitProcess = Process::fromShellCommandline('git commit -m ' . escapeshellarg($message));
        $commitProcess->run();

        if ($commitProcess->isSuccessful()) {
            $this->info("✅ Commit successful: $message");
            return 0;
        } else {
            $this->error('❌ Commit failed');
            $this->error($commitProcess->getErrorOutput());
            return 1;
        }
    }
}
