# 04 INSTALLER AND SETUP

## Purpose
Specification for the 4-stage setup wizard for shared hosting environments.

## Status
- [x] Not started
- [x] In progress
- [ ] Completed

## First-Run Detection Rules
1. If `storage/installed.lock` exists → Site is installed.
2. Else if `APP_INSTALLED=true` in `.env` → Site is installed.
3. Else if `site_settings` table exists AND contains an admin → Site is installed.
4. Otherwise → Redirect to `/install`.

## 4-Stage Flow
- **Stage 0: Preflight**: Check PHP version (>= 8.2), extensions (PDO, mbstring, etc.), and folder permissions.
- **Stage 1: Database**: Collect DB credentials and test connection.
- **Stage 2: Migrations**: Run `artisan migrate` or provide manual SQL fallback.
- **Stage 3: Admin**: Create first admin user.
- **Stage 4: Identity**: Site title, WhatsApp number, and initial theme selection.

## Fallback Strategy
- If `proc_open` is disabled, provide `install/schema.sql` for manual phpMyAdmin import.
- Lock installer by creating `storage/installed.lock` on completion.
