# Coding Rules

These rules take PRIORITY over all other guidelines and must be followed at all times.

## Git

- When asked to commit, commit ALL modified files — whether they were in scope or not, whether touched by Claude or not. Every single modified, staged, or untracked file must be committed. No exceptions.
- Always follow commitlint conventions: `feat`, `chore`, `hotfix`, `fix`, `refactor`, `docs`, `style`, `test`, `ci`, `perf` — based on what was actually done.
- Never push code while there are still uncommitted files. If multiple commits are needed, create them all first, then push once everything is committed.
- Never ask to push when there are still modified files pending. Commit everything first.

## Features & Code Replacement

- Never delete code or files before the replacement is written, tested, and functional.
- When updating a feature that replaces another: first build the new version completely, then once it is working and validated, switch over to it and only then delete the old files.
- If a code change requires deleting files, finish the new implementation first. Deletion happens last, after validation.
- The only exception is when modifying a file directly in place (editing the same file) — that is fine.

## Answering Project Questions

- Before answering any question about the project (features, files, code, configuration), re-read the relevant files and code in the project first.
- Never rely on conversation history alone to answer questions about the current state of the project. The user modifies files independently — the conversation history may be outdated.
- If a question is about whether a file exists, a feature is implemented, or a configuration is set — scan the project before responding.
- Never say "this file doesn't exist" without first checking with Glob or Grep.
- The project state at the time of the question is the source of truth, not the history of past exchanges.
