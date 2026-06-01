# Git Auto Commit Scripts

Automated git staging and commit scripts for easy workflow management.

## Available Options

### 1. **PowerShell Script (Windows)**
```powershell
.\commit.ps1 "Your commit message"
.\commit.ps1  # Uses timestamp as message
```

### 2. **Bash Script (Cross-platform)**
```bash
./commit.sh "Your commit message"
./commit.sh  # Uses timestamp as message
```

### 3. **PHP Artisan Command (Laravel)**
```bash
php artisan git:commit "Your commit message"
php artisan git:commit  # Uses timestamp as message
```

### 4. **NPM Script**
```bash
npm run commit "Your commit message"
npm run commit  # Uses timestamp as message
npm run git:add  # Just stage changes (git add .)
npm run git:status  # Check git status
```

## Features

- ✅ Automatically stages all changes (`git add .`)
- ✅ Commits with a custom message or timestamp
- ✅ Shows count of changed files
- ✅ Validates if there are changes before committing
- ✅ Color-coded output for better readability
- ✅ Works on Windows and Unix-based systems

## Setup

All scripts are ready to use. For bash scripts on Windows, ensure you have:
- Git Bash installed, or
- WSL (Windows Subsystem for Linux)

## Examples

**PowerShell:**
```powershell
.\commit.ps1 "Fixed A4 print layout"
```

**Bash:**
```bash
./commit.sh "Updated authentication controller"
```

**Artisan:**
```bash
php artisan git:commit "Added new clearance feature"
```

**NPM:**
```bash
npm run commit "Database migration"
```

## Default Behavior

If no message is provided, all scripts automatically generate a message with:
- Current date and time
- Format: `Auto-commit: YYYY-MM-DD HH:MM:SS`

## Notes

- Scripts check for staged changes before committing
- If no changes are detected, scripts exit gracefully
- Use quotes for multi-word commit messages
- PowerShell: Make sure execution policy allows script execution
