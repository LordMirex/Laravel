Installation & Setup Wizard Specification 🧩

Modular Influencer Engine — Installer / First-Run Spec (v1.0)

Purpose:
This document describes the full installation experience for a fresh copy of the Laravel app uploaded to a shared-hosting cPanel/File-Manager environment. It covers first-run detection, the 4-stage installer flow, DB setup, migrations, admin creation, category & theme seeding, error handling & fallbacks for hosts that block Artisan, installer locking, logging, security and acceptance criteria. Use it as the single-source spec for engineers and QA when building and testing the installer UI and server logic.

⸻

Quick overview (one line)

When a brand-new package is uploaded and visited, the app detects “not installed” and launches a secure, friendly, 4-step web installer that writes .env, runs migrations (or provides manual SQL fallback), creates admin credentials, seeds starter templates for a chosen category/theme, and locks the installer — all with clear progress, diagnostics and helpful fallback instructions for cPanel environments.

⸻

Table of Contents
	1.	First-run detection rules
	2.	Installer entry point & route rules
	3.	Installer modes & protections
	4.	4-stage Installer UX flow (UI + validations + microcopy)
	•	Stage 0: Welcome & preflight (server checks)
	•	Stage 1: Database Connection (DB credentials & test)
	•	Stage 2: Run migrations & seed (automatic or manual fallback)
	•	Stage 3: Admin creation (create the first admin)
	•	Stage 4: Site identity, category & theme selection (seed content)
	5.	Execution details (programmatic steps & commands)
	6.	Error handling & fallback strategies (cPanel realities)
	7.	Installer logging & diagnostics (what to capture)
	8.	Post-install actions & installer lock
	9.	Security considerations (permissions, endpoints, secrets)
	10.	Rollback & re-install options (support & recovery)
	11.	Acceptance criteria & QA checklist
	12.	Sample microcopy & error messages
	13.	Developer notes: packaging to support installer (recommended files)
	14.	Appendix: manual migration import SQL flow (for hosts that block Artisan)

⸻

1. First-run detection rules

When a request arrives to the application root, run a minimal, fast check BEFORE booting the full frontend:

Check these conditions in order (short circuit on first positive):
	1.	If storage/installed.lock file exists → site is installed. Normal app boot.
	2.	Else if an environment value APP_INSTALLED=true exists in .env → installed.
	3.	Else if site_settings table exists AND contains an admin user → installed.
	4.	Otherwise → not installed → route request to /install UI.

Notes:
	•	Use file flag storage/installed.lock as the canonical authoritative flag after install (created on success).
	•	Do NOT rely solely on .env presence since dev environments may include .env.example.
	•	Install checks must be fast and never attempt heavy DB queries on each request. Use light metadata queries or file checks.

⸻

2. Installer entry point & route rules
	•	Installer base route: GET /install (and POST endpoints under /install/*).
	•	When installed flag present, routes under /install must respond 403 (or redirect to front page).
	•	Installer assets (CSS/JS) are publicly accessible while installer active. After success, remove/disable installer routes and assets if possible.

⸻

3. Installer modes & protections

Default mode: interactive web UI.

Protected mode options (recommended):
	•	Generate a one-time installer token placed temporarily in /storage/installer_token at packaging time (optional). Installer will only run if token file exists or if token not set, the installer runs by default. This is optional—mainly for vendor testing.
	•	Rate-limit installer attempts (to avoid abusive loops).
	•	Log every installer attempt with IP and timestamp.

⸻

4. 4-stage Installer UX flow (UI + validations + microcopy)

Design pattern: stepper UI (Left column: stepper; center: content; right: diagnostics/logs). Provide top breadcrumb and Cancel button. Always show a contextual help link to README and support.

Stage 0 — Welcome & Preflight (Server checks)

Purpose: inform and run automated server checks (PHP version, extensions, folder permissions).

UI elements:
	•	Title: “Welcome — Let’s set up your site”
	•	Short description: explain 4 steps and required values (MySQL credentials, admin email, WhatsApp number).
	•	Checklist (auto-run tests) with green/red indicators:
	•	PHP version >= 8.2
	•	Required PHP extensions: PDO, mbstring, OpenSSL, JSON, ctype, fileinfo, GD or Imagick (optional), tokenizer
	•	storage and bootstrap/cache writable
	•	public directory accessible
	•	exec/proc_open availability (informational: affects automatic migrations)
	•	Disk space (informational)
	•	Buttons: “Continue” only enabled if required checks pass (allow override with caution and show warning if proc_open disabled).

Validation & microcopy:
	•	If PHP version < 8.2 show a warning and list hosts that may support upgrade.
	•	If storage not writable: show exact chmod instructions for cPanel File Manager.
	•	If exec disabled: warn migrations may fail and manual SQL import will be required (explain fallback).

Diagnostics panel (right): raw phpinfo() subset and detected settings helpful for support copy/paste.

⸻

Stage 1 — Database Connection

Purpose: collect DB credentials, validate connection, optionally create DB (if allowed).

Fields:
	•	DB_HOST (default: localhost)
	•	DB_PORT (default: 3306)
	•	DB_DATABASE
	•	DB_USERNAME
	•	DB_PASSWORD
	•	TABLE_PREFIX (optional)
	•	DB_CHARSET (default utf8mb4)

UI behavior:
	•	“Test Connection” button triggers AJAX to validate credentials.
	•	If connection successful:
	•	show existing tables count (if >0 warn: “This database already contains tables. Installing here may overwrite existing data. Confirm to continue.”)
	•	Allow user to continue.
	•	If connection fails:
	•	show concise error (Access denied / Unknown host / Timeout).
	•	Provide cPanel phpMyAdmin import instructions link.

Validation rules:
	•	Host required; port integer 1–65535; DB name required; username required.
	•	On success: write values to .env (temporarily, but keep safe): DB_* keys written immediately but do not write APP_KEY yet.

Security:
	•	.env must be written with file permissions restricting public read (server default).
	•	Clear DB password display immediately after writing; never echo back plaintext on subsequent pages.

⸻

Stage 2 — Run Migrations & Seed (automatic preferred; manual fallback available)

Purpose: run php artisan migrate --force and seed essential data (site settings, default themes, block types).

Automatic path (preferred):
	•	Attempt to run migrations programmatically:
	•	Artisan::call('key:generate', ['--force' => true]) — write APP_KEY to .env.
	•	Artisan::call('migrate', ['--force' => true]);
	•	Artisan::call('db:seed', ['--class' => 'InitialSettingsSeeder']);
	•	Show live progress in UI (progress bar and incremental logs).
	•	On success: mark step passed.

If programmatic migration fails (common on many cPanel hosts because proc_open/exec disabled or timeouts):
	•	Capture the full Artisan error log and display to admin with friendly troubleshooting suggestions (permission, extension missing).
	•	Offer manual SQL import flow:
	1.	Display a link to download database/schema.sql (packaged with app).
	2.	Show step-by-step phpMyAdmin import instructions (screenshots or text).
	3.	Provide a button “I have imported the SQL” which triggers a lightweight post-install check that checks expected tables exist and returns success or shows missing table details.
	4.	After manual import is confirmed, run seeds programmatically if possible (smaller operations). If seeds fail, offer to run seed SQL snippets provided as downloadable files.

UI elements:
	•	Progress log area (append logs as actions happen).
	•	“Retry” button on failure with improved diagnostic message.
	•	If migrations succeed, allow optional checkbox: “Seed demo content (recommended for first time)”. If checked, seed sample blocks & products.

Validation & microcopy:
	•	Warn user if DB had tables (risk of overwriting), provide an option to continue or choose a fresh DB.
	•	Show “Estimated time: <1 min” for migrations in normal environments; warn longer for large migrations.

⸻

Stage 3 — Admin User Creation

Purpose: create the first administrative account.

Fields:
	•	Admin name (required)
	•	Admin email (required, valid email)
	•	Admin password (required, show password strength)
	•	Confirm password (match)
	•	Timezone (select)
	•	Locale (optional)
	•	Enable email verification? (toggle)

UI behavior:
	•	Create admin user in users table, hashed password (Argon2/Bcrypt).
	•	If SMTP configured (we can allow SMTP in Settings later), optionally send a welcome email; otherwise show note that email delivery is not configured.
	•	After creating admin, auto-login option (recommended) or show generated login link.

Validation rules:
	•	Password min length (8–12), at least one uppercase, one number (show tooltip).
	•	Email uniqueness check (DB empty normally so fine).

Security & microcopy:
	•	Never display admin password after submission (store hashed).
	•	On success: store admin id in installation log.

⸻

Stage 4 — Site Identity, Category & Theme Selection

Purpose: capture public site settings and seed category-specific configuration & theme.

Fields:
	•	Site title (required)
	•	Site tagline (optional)
	•	WhatsApp phone (required — suggest E.164 format; helper text)
	•	Currency symbol/code (required)
	•	Choose category (dropdown with thumbnails — e.g., Skit Maker, YouTuber, Seller, Photographer, Author, Musician)
	•	Choose initial theme variant (thumbnail gallery filtered by category)
	•	Install demo content? (checkbox: “Yes — install sample blocks & products”)
	•	Accept license & terms (checkbox)

UI behavior:
	•	Selecting category auto-selects recommended theme variants and default feature toggles (store, newsletter, events). Admin can modify these later in Settings.
	•	If “Install demo content” checked: seed demo blocks/products after theme applied (small content only so admin can preview quickly).
	•	After clicking “Finish”: run finalization steps.

Finalization steps (post-submit):
	1.	Save settings to site_settings table and write any tokens to theme_config.
	2.	If demo content chosen — seed demo blocks and sample products (only for preview; admin can remove).
	3.	Create storage/installed.lock file containing JSON {installed_by: admin_email, timestamp, version}.
	4.	Remove/disable installer routes programmatically (update route config or set APP_INSTALLED=true in .env).
	5.	Redirect admin to /admin/login (or auto login) and display a friendly “Welcome” dashboard modal with next steps.

Microcopy on success: “Congratulations — your site is ready. Click ‘Go to Dashboard’ to customize templates, update content, and publish.”

⸻

5. Execution details (programmatic steps & recommended commands)

Safe programmatic sequence (attempt in order):
	1.	Write DB to .env
	•	Use safe file write with exclusive lock and chmod to restrict reading by other users on some hosts.
	2.	Generate APP_KEY
	•	Artisan::call('key:generate', ['--force' => true]);
	3.	Cache config? do NOT cache config before migrations; avoid config:cache on installer.
	4.	Attempt migrations
	•	Artisan::call('migrate', ['--force' => true]);
	•	If using package migrations ensure they are published.
	5.	Seed defaults
	•	Artisan::call('db:seed', ['--class' => 'InitialSettingsSeeder']);
	•	Seed minimal theme tokens and block type definitions.
	6.	Seed demo (optional)
	•	run DemoSeeder only if admin checked.
	7.	Create admin
	•	Create hashed user record with role=admin.
	8.	Create installed lock
	•	Write storage/installed.lock with minimal JSON.
	9.	Set APP_INSTALLED=true
	•	Optionally write to .env APP_INSTALLED=true for quick checks.
	10.	Log installation
	•	Append to storage/logs/installer.log with admin email, IP, timestamp, PHP version.

Important: All programmatic Artisan calls must be wrapped in try/catch and have clear rollback behavior if partial failure occurs.

⸻

6. Error handling & fallback strategies (cPanel realities)

Shared hosts can behave unpredictably (time limits, disabled functions). The installer must be resilient and provide clear human steps.

Common failure modes & responses
	1.	DB connection errors
	•	Show precise DB error (Access denied / Unknown host). Suggest checking DB user privileges and port. Provide phpMyAdmin import instructions or suggest creating DB via cPanel > MySQL Databases.
	2.	Migrations fail due to disabled proc_open or timeouts
	•	Provide downloadable database/schema.sql and step-by-step instructions to import via phpMyAdmin.
	•	Provide a “small seeds” SQL file for demo content.
	•	Provide a “Continue after manual import” button that validates table existence.
	3.	File permission errors (can’t write .env or installed.lock)
	•	Show exact path and permission instructions for cPanel File Manager (set 755 for directories, 640 for files if possible).
	•	Offer manual instructions to upload .env template and add keys.
	4.	Out of disk space
	•	Show warning and halt install. Suggest cleaning uploads.
	5.	Mail not configured
	•	Not fatal. Warn that password resets and welcome emails won’t send; provide link to SMTP setup later.
	6.	Partial failures
	•	If migrations partially applied, offer “rollback migrations” button if possible (Artisan::call('migrate:rollback')) or instruct to drop all tables and re-run after fix.

UI fallback flows built into installer
	•	“Try automatic migration” → on failure: show “Download SQL & Import via phpMyAdmin” coroutine.
	•	“I imported manually” → verify via DB table existence API → continue to Admin creation.
	•	All errors include “Copy diagnostic” to clipboard to paste in support ticket.

⸻

7. Installer logging & diagnostics

Installer must create and maintain storage/logs/installer.log with structured JSON lines. Each event should log:
	•	timestamp, IP, step name, result (success/failure), error_message (if any), PHP version, DB driver info, memory_limit, disk free space.

Make logs easy to attach in support forms (provide “Copy logs” button).

⸻

8. Post-install actions & installer lock

On final success:
	1.	Create storage/installed.lock with JSON: {install_version, installed_by_email, timestamp, php_version, theme_applied}.
	2.	Optionally set APP_INSTALLED=true in .env (if .env writable).
	3.	Remove or disable installer routes (update route check).
	4.	Clear any temporary files containing secrets.
	5.	Ensure APP_DEBUG=false recommended — show instruction to set in .env if currently true.
	6.	Redirect to Admin dashboard.

Important: Do NOT remove install asset files automatically (so vendor can still patch), but disable access. Consider leaving a small “reinstall” admin tool in admin only that performs reset after authentication (for support).

⸻

9. Security considerations (permissions, endpoints, secrets)
	•	Protect .env write operations: write with file mode 0600 if host supports.
	•	Installer should not echo secrets back into UI.
	•	Files created by installer (e.g., installed.lock) should not be world readable.
	•	Rate-limit installer endpoints (throttle by IP) to avoid brute force.
	•	Admin password creation uses secure hashing (Argon2 if available else bcrypt).
	•	Provide a one-time installer token or require admin to confirm first login to secure admin area (optional).
	•	Sanitize any user input used in seed scripts (avoid injection).

⸻

10. Rollback & re-install options

Provide admin tools for safe re-install/reset (admin only):
	•	Soft reset: delete demo content, re-seed defaults (keeps admin).
	•	Full reset: drop all DB tables and remove installed.lock (dangerous — require strong confirmation & typed passphrase).
	•	Manual re-install: instructions for support to remove installed.lock and re-run installer (only for dev/support use).

Caution: Document that reset destroys data; include export options before reset if data exists.

⸻

11. Acceptance criteria & QA checklist

Installer must pass the following to be accepted:

Functional
	•	Installer launches when app is uninstalled (no .env or installed.lock).
	•	Preflight checks report correct PHP extensions & folder writeability.
	•	DB test connection reliably indicates success/failure with clear error messages.
	•	Migrations run successfully on typical cPanel hosts that allow Artisan; SQL fallback path works on hosts where Artisan is blocked (import via phpMyAdmin).
	•	Admin user can be created and can log in after install.
	•	Category & theme selection seeds demonstrable blocks and products if requested.
	•	Installer writes installed.lock and disables itself after success.

UX
	•	Each step has helpful microcopy and diagnostic info.
	•	Installer progress logs are visible and useful.
	•	All error messages include next steps and links to README.

Security
	•	.env is not included in package; installer writes .env & sets secure file modes when possible.
	•	Installer routes disabled after success.

Automation tests
	•	Simulate install with in-memory DB (for CI) — full flow passes.
	•	Integration test: script that uploads package to a test cPanel account and runs UI install end-to-end (manual or automated via Selenium).

⸻

12. Sample microcopy & error messages (copy-ready)

Welcome screen

Welcome to the Influencer Engine installer — this guided setup will configure your site in four steps. You’ll need your hosting MySQL credentials. If your host blocks automatic installation, we’ll provide a step-by-step manual SQL import.

DB error (access denied)

Error: Access denied for user user@host. Check database username and password, verify the user has privileges for the selected database, or create a new database via cPanel > MySQL Databases.

Migrations fail (proc_open disabled)

Automatic migrations appear to be blocked on this host. Please download the provided schema.sql file and import it into your database using phpMyAdmin. After import, click “I imported the SQL” to continue.

Permissions error

Cannot write configuration file. Please set writable permissions on /storage and /bootstrap/cache (use cPanel File Manager or contact your host). See instructions.

Success

Installation complete! Your site is now live. Click “Go to Dashboard” to sign in and customize your theme and content.

⸻

13. Developer notes: packaging to support installer (recommended files)

Include in packaged ZIP:
	•	/install/schema.sql — full schema dump to import manually
	•	/install/seeds_demo.sql — optional demo data SQL
	•	/install/README_INSTALL.md — step-by-step cPanel import instructions with images
	•	/install/installer_token.example — optional token mechanism
	•	.env.example (must be included)
	•	storage/empty folder placeholders (ensure directories exist after unzip)
	•	public/theme_thumbnails/ sample images for installer UI

⸻

14. Appendix — Manual migration import flow (for hosts that block Artisan)
	1.	From installer, click “Download schema.sql”.
	2.	In cPanel, open phpMyAdmin.
	3.	Select the target database (create one if needed via cPanel > MySQL Databases).
	4.	Click Import, choose schema.sql and run.
	5.	After import completes, return to installer and click I imported the SQL.
	6.	Installer runs seeders (small queries) if server allows; otherwise it will show links to import seeds SQL.
	7.	Continue to Admin creation stage.

Provide screenshots and exact SQL statements where helpful.

⸻

15. Summary of responsibilities by system actor
	•	Installer UI (frontend): stepper, form validations, display progress and logs, copy & links.
	•	Installer controller (backend): write .env, run tests, call Artisan, seed data, create admin, write installed.lock, log actions, produce SQL files if needed.
	•	Support docs: README_INSTALL and troubleshooting guide packaged with the ZIP.
	•	QA: test on 3–5 common cPanel providers, include one low-permission host to exercise manual flow.

⸻

16. Final recommendations (operational)
	•	Provide clear “support copy” in installer (copy/paste diagnostics).
	•	Include a small “System Check” debug page accessible to support (protected via temporary token) during install to capture phpinfo subset and DB status.
	•	Make demo content optional (do not force) — some buyers want a clean install.
	•	Encourage buyers to set SMTP in Settings after admin login for email reliability.
	•	Document reinstallation/reset steps clearly to reduce support overhead.

