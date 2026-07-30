#!/usr/bin/env node

const { execSync } = require('child_process');
const fs = require('fs');

// Get commit message from command line or generate default
const message = process.argv[2] || `Auto-commit: ${new Date().toISOString().replace('T', ' ').slice(0, 19)}`;

try {
    console.log('📦 Staging all changes...');
    execSync('git add .', { stdio: 'inherit' });

    // Check if there are staged changes
    const stagedFiles = execSync('git diff --cached --name-only', { encoding: 'utf8' }).trim();
    
    if (!stagedFiles) {
        console.log('✅ No changes to commit');
        process.exit(0);
    }

    const fileCount = stagedFiles.split('\n').filter(f => f).length;
    console.log(`📝 Committing ${fileCount} changed files...`);

    execSync(`git commit -m "${message.replace(/"/g, '\\"')}"`, { stdio: 'inherit' });
    console.log(`✅ Commit successful: ${message}`);
    process.exit(0);
} catch (error) {
    console.error('❌ Commit failed');
    process.exit(1);
}
