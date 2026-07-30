# Auto Git Add & Commit Script for Windows PowerShell
# Usage: .\commit.ps1 "Your commit message"
# If no message provided, defaults to timestamp-based message

param(
    [string]$message = ""
)

# Set location to script directory
Set-Location $PSScriptRoot

# Generate default message if not provided
if ([string]::IsNullOrWhiteSpace($message)) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $message = "Auto-commit: $timestamp"
}

Write-Host "📦 Staging all changes..." -ForegroundColor Cyan
git add .

$stagedCount = (git diff --cached --name-only | Measure-Object -Line).Lines
if ($stagedCount -eq 0) {
    Write-Host "✅ No changes to commit" -ForegroundColor Yellow
    exit 0
}

Write-Host "📝 Committing $stagedCount changed files..." -ForegroundColor Cyan
git commit -m $message

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Commit successful: $message" -ForegroundColor Green
} else {
    Write-Host "❌ Commit failed" -ForegroundColor Red
    exit 1
}
