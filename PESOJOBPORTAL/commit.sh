#!/bin/bash
# Auto Git Add & Commit Script for Bash
# Usage: ./commit.sh "Your commit message"
# If no message provided, defaults to timestamp-based message

MESSAGE="$1"

# Generate default message if not provided
if [ -z "$MESSAGE" ]; then
    MESSAGE="Auto-commit: $(date '+%Y-%m-%d %H:%M:%S')"
fi

echo "📦 Staging all changes..."
git add .

STAGED_COUNT=$(git diff --cached --name-only | wc -l)
if [ "$STAGED_COUNT" -eq 0 ]; then
    echo "✅ No changes to commit"
    exit 0
fi

echo "📝 Committing $STAGED_COUNT changed files..."
git commit -m "$MESSAGE"

if [ $? -eq 0 ]; then
    echo "✅ Commit successful: $MESSAGE"
else
    echo "❌ Commit failed"
    exit 1
fi
