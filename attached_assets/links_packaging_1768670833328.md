Packaging & Distribution Document 📦

Modular Influencer Engine — Clean-Pack & Buyer Delivery Guide (v1.0)

Purpose: Explain exactly how to convert your Replit-developed Laravel app into a clean, sellable installation package, how the installer is activated on the buyer’s side, and step-by-step buyer deployment instructions for typical shared-host (cPanel) environments. Includes checklists, file lists, security notes, update/patch workflow, test plan and buyer-facing README text you can include in the package.

⸻

Executive summary (one sentence)

Build the app on Replit in Development Mode, then run a disciplined Clean-Pack workflow that removes environment-specific data, resets install state, bundles assets (optionally vendor/), produces a signed ZIP plus schema.sql and README_INSTALL, and delivers it to a buyer who uploads it to cPanel and runs the included web-based installer.

⸻

1. Modes & concepts

Development Mode (Replit)
	•	Full-featured working copy: .env, seeded demo data, admin account(s).
	•	Installer disabled or bypassed for developer convenience.
	•	Use this environment to build features, themes, and seed demo content.

Distribution Mode (Packaged)
	•	.env removed; .env.example included.
	•	No database content (no users, no subscribers).
	•	installed flag set to not installed so web installer runs on first visit.
	•	Demo content optional (seeders provided, but not applied by default).
	•	Packaged as ZIP for buyer upload.

Key rule: Never ship a package containing live credentials or production secrets.

⸻

2. What to clear before packaging (the Clean-Pack checklist)

These steps MUST be performed (automatable or manual):
	1.	Remove secrets
	•	Delete .env from project root.
	•	Keep .env.example with placeholders only.
	2.	Reset install state
	•	Ensure there is no storage/installed.lock.
	•	Ensure site_settings (or equivalent) does not contain a populated site_title/admin user (or clear these rows). Ideally seeders create defaults on install only.
	3.	Clear database artifacts
	•	Do not bundle DB dumps.
	•	Drop local/test DB or remove DB dump files.
	•	If including schema.sql, ensure it is clean (no admin user rows).
	4.	Clear user accounts & demo sensitive data
	•	Remove seeded admin users (or replace with placeholder).
	•	Remove subscribers, orders, or any PII.
	5.	Clear uploaded media (optional)
	•	Remove storage/app/public/uploads/*, but keep a small sample_assets/ folder with theme thumbnails and small demo images.
	•	Keep empty directories so the storage structure exists.
	6.	Clear caches
	•	Remove files under bootstrap/cache, storage/framework/cache/*, storage/framework/views/*.
	•	Do not ship compiled caches.
	7.	Remove dev-only tooling
	•	Remove .vscode/, .replit, local-only scripts, and dev Docker artifacts, unless you specifically want to bundle them.
	8.	Confirm installer presence
	•	Ensure the installer controller & install routes exist, are enabled, and that the app’s install check will detect “not installed”.
	9.	Set recommended default in .env.example
	•	APP_ENV=production
	•	APP_DEBUG=false
	•	Provide SMTP placeholders and instructions.
	10.	Include SQL fallback
	•	Provide install/schema.sql (schema-only) and install/seeds_demo.sql (optional demo content) for hosts that block Artisan migrations.
	11.	Documentation
	•	Include README_INSTALL.md, LICENSE.txt, CHANGELOG.md, and SUPPORT.md.
	12.	Build assets
	•	Run the front-end build (e.g., npm run build) and ensure public/ contains built assets (CSS/JS).
	•	Optionally include node_modules build artifacts if you plan to ship compiled assets — but do not ship node_modules unless necessary.
	13.	Optional: include vendor/
	•	If many buyers won’t have Composer or SSH, include vendor/ to make install truly one-click. This increases ZIP size substantially.

⸻

3. Packaging structure & files (what the ZIP contains)

Recommended package root (zip file influencer-engine_v1.0.zip):

influencer-engine_v1.0.zip
├─ app/
├─ bootstrap/
├─ config/
├─ database/
│   ├─ migrations/        (optional)
│   └─ seeds_demo.sql     (optional)
├─ install/
│   ├─ schema.sql         <-- Manual SQL import fallback
│   └─ README_INSTALL.md  <-- Quick import steps (phpMyAdmin)
├─ public/
├─ resources/
├─ routes/
├─ storage/               (folder skeleton, but no uploads)
│   ├─ app/
│   ├─ framework/
│   └─ logs/
├─ .env.example
├─ composer.json
├─ composer.lock
├─ artisan
├─ README_INSTALL.md      <-- primary buyer installation guide
├─ LICENSE.txt
├─ CHANGELOG.md
├─ SUPPORT.md
├─ theme_thumbnails/      <-- small sample images for installer UI
└─ vendor/                (optional, recommended if buyer may lack Composer)

Naming convention
	•	Use semantic versioning: influencer-engine_v1.0.0.zip
	•	Append -vendor if vendor/ included: influencer-engine_v1.0.0-vendor.zip

Checksum
	•	Produce influencer-engine_v1.0.0.zip.sha256 with sha256sum for buyer integrity verification.

⸻

4. How installer gets activated (technical)

Installer activation rule (packaging step):
	•	Ensure the app is in not installed state by one of:
	•	No .env file (safer)
	•	OR storage/installed.lock does not exist
	•	OR APP_INSTALLED not set to true in .env.example

On first HTTP request:
	•	Application checks storage/installed.lock or APP_INSTALLED. If not installed, route to /install UI.
	•	The installer writes .env during DB step, runs migrations (or instructs manual import), creates admin user, and writes storage/installed.lock to finalize install.

Packaging action: set installer to active by not shipping .env. That ensures first run triggers installer.

⸻

5. Automatable Pack Script (example, not executed here)

You can create a script (shell or Node) to automate the Clean-Pack. Example pseudo-commands to run locally (adjust to your environment):

# 1. Set version
VERSION=1.0.0
PKGNAME="influencer-engine_v${VERSION}"

# 2. Clean caches
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 3. Remove local .env
rm -f .env

# 4. Remove uploads (optional)
rm -rf storage/app/public/uploads/*

# 5. Remove installed lock
rm -f storage/installed.lock

# 6. Export schema
mysqldump --no-data --databases your_local_db > install/schema.sql

# 7. Build assets
npm run build

# 8. Ensure .env.example correct
cp .env.example .env.example

# 9. Zip
zip -r ${PKGNAME}.zip . -x ".git/*" "node_modules/*" ".env" ".replit" "*.log" "storage/*"
# Optionally include vendor to make installers easier:
# zip -r ${PKGNAME}-vendor.zip . -x ".git/*" ".env" ...

Note: The exact commands depend on your OS and Replit environment. The goal is reproducibility — script this once and reuse.

⸻

6. README_INSTALL.md — buyer-facing (copy-ready)

Place the following as README_INSTALL.md in the package root (this text is ready to paste):

README_INSTALL.md (for buyers)

Influencer Engine — Quick Install Guide (cPanel)

1) Upload & extract
   - Log into your cPanel.
   - Go to File Manager and upload `influencer-engine_v1.0.0.zip` into your desired folder (usually public_html or a subfolder).
   - Extract the ZIP.

2) Move files to public (if needed)
   - If you extracted into a subfolder, ensure the web root points to the `public` directory.
   - If your host requires files in public_html, move all files from `your-folder/public/*` into `public_html/` and move other files to a folder above public_html if you prefer (advanced).

3) Set permissions
   - Set `storage/` and `bootstrap/cache` directories to writable (use File Manager > Permissions or SSH: `chmod -R 755 storage bootstrap/cache`).
   - Ensure `storage/logs` is writable.

4) Create MySQL database
   - In cPanel, go to "MySQL Databases".
   - Create a new database, create a database user, and assign the user to the database with all privileges.
   - Note: DB host is usually `localhost` in cPanel.

5) Visit site to run installer
   - Open your domain in a browser.
   - The app will detect it's not installed and launch the web installer.
   - You will be asked for DB host, DB name, DB user, DB password and to run the installer steps (migrate, seed, admin user creation).
   - If your host blocks automatic migrations, follow the "Manual SQL import" steps in the installer (we included `install/schema.sql`).

6) After install
   - Log into /admin with the admin account you created.
   - Set SMTP settings under Settings → Email for reliable mail delivery.
   - Update site content and theme via the admin panel.

7) Troubleshooting
   - If installer reports missing PHP extensions, contact your host to enable them (PDO, mbstring, openssl, fileinfo, json).
   - If `php artisan migrate` fails (host blocks exec), use phpMyAdmin to import `install/schema.sql`.
   - If you need support, open a ticket at: support@example.com (replace with your support address).

Thank you for choosing Influencer Engine.


⸻

7. Manual deployment steps for buyers (detailed cPanel flow)
	1.	Upload ZIP
	•	cPanel > File Manager > Upload influencer-engine_v1.0.0.zip.
	2.	Extract
	•	Select the zip > Extract > ensure files placed into the desired directory (ideally above public_html with public content into public_html). If you extract into public_html, make sure public folder contents are at root.
	3.	Create DB
	•	cPanel > MySQL Databases: create DB & user; assign privileges.
	4.	Set permissions
	•	In File Manager select storage and bootstrap/cache > Change Permissions > 755 (or 775 if hosting requires group write).
	5.	Run Installer
	•	Visit your domain in browser → follow web installer.
	•	Input DB credentials created earlier.
	•	If installer fails on migrations due to host restrictions, use phpMyAdmin to import install/schema.sql:
	•	Open phpMyAdmin → Select DB → Import → Choose schema.sql → Go.
	6.	Finish installer
	•	Create admin user and set site settings.
	•	Installer writes installed.lock and disables itself.
	7.	Post-install
	•	Configure SMTP for reliable email.
	•	Ensure scheduled tasks (cron) are configured if using scheduled newsletter sends:
	•	Example cron: * * * * * /usr/bin/php /home/username/path/artisan schedule:run >> /dev/null 2>&1

⸻

8. SQL fallback & manual import details

Include a clean install/schema.sql file generated from your dev DB with no data rows for sensitive tables. It should include:
	•	CREATE TABLE statements for all tables required.
	•	Indexes and foreign keys.
	•	Minimal reference data only for non-sensitive lookup tables (e.g., default block types), or provide seed SQL separately.

Manual import steps (buyer)
	•	cPanel > phpMyAdmin > Select DB > Import > Choose schema.sql > Go.

After import:
	•	Visit installer and click “I have imported the SQL” to continue to stage 3 (admin creation + theme application).

⸻

9. Including vendor/ — pros & cons

Include vendor/ folder
	•	Pros: buyer does NOT need Composer or SSH; instant ready-to-install.
	•	Cons: ZIP size large; potential Composer classifier mismatch (PHP versions/extensions); cannot easily update via Composer.

Exclude vendor/
	•	Pros: smaller package, encourages correct dependency management.
	•	Cons: buyer must run composer install (requires SSH/Composer access) or use a host that provides Composer.

Recommendation: Provide two packages:
	•	...-vendor.zip — full, drop-in package for non-technical buyers.
	•	...-light.zip — no vendor, for advanced users.

⸻

10. Versioning, changelog & updates

Versioning
	•	Use semantic versioning MAJOR.MINOR.PATCH (e.g., 1.0.0).
	•	Tag releases in your Git repo and include CHANGELOG.md.

Delivering updates
	•	Patch updates delivered as a patch ZIP containing only changed files + migration scripts (e.g., update-1.0.0-to-1.0.1.zip).
	•	Provide an update script in package admin that:
	•	Backs up DB (admin must provide credentials)
	•	Applies file replacement (upload update ZIP and extract)
	•	Runs migrations (php artisan migrate) via web UI (optional; documented fallback if blocked)
	•	Alternatively, instruct buyers to replace files manually and run php artisan migrate via SSH or provide SQL update scripts.

Upgrade notes
	•	Always provide a pre-update checklist: backup files & DB, set APP_DEBUG=true in a test environment, run update in staging first.

⸻

11. Licensing & support

License file
	•	Include LICENSE.txt — choose license depending on business model:
	•	Commercial (recommended): Proprietary license with EULA for buyer (restricts redistribution).
	•	Open-source: MIT/GPL etc. (not recommended if you plan to sell copies).

Support policy
	•	Include SUPPORT.md that explains support channels, response SLAs, paid installation options, and refund policy.

Example SUPPORT.md snippet

Support
-------
Email: support@example.com
Response time: 48 business hours (standard)
Paid Installation: $50 (one-time)
Bug fixes: included for 30 days after purchase


⸻

12. Security & privacy considerations for packaging
	•	Never include .env or credentials in package.
	•	Ensure install/schema.sql contains no passwords or emails.
	•	Ensure storage/ folder is empty of logs (storage/logs/*) before zipping.
	•	Provide buyers instructions to set secure file perms and APP_DEBUG=false.
	•	Recommend using HTTPS (TLS) — include short TLS setup notes.

⸻

13. Quality assurance & pre-release checklist (must pass)

Before publishing package:
	•	.env is not included
	•	storage/installed.lock does not exist
	•	All caches cleared
	•	install/schema.sql present & tested via phpMyAdmin import
	•	README_INSTALL.md included and accurate
	•	CHANGELOG.md updated with release notes
	•	Assets built (npm run build) and public/ contains compiled CSS/JS
	•	If shipping vendor, ensure composer install --no-dev was used and vendor is consistent
	•	Create ZIP and verify checksum (sha256)
	•	Test upload & install on at least 3 distinct cPanel hosts (one low-permissions host)
	•	Include theme_thumbnails/ and small sample assets
	•	Include license & support docs

⸻

14. Buyer verification & test plan (what buyers should check post-install)

After installer completes, buyers should test:
	1.	Public landing page renders and is mobile-friendly.
	2.	Admin login works.
	3.	Media uploads work (try one image).
	4.	Create a product and test “Buy via WhatsApp” button (opens wa.me).
	5.	Subscribe to newsletter and test subscriber appears in admin subscribers.
	6.	Upload and crop hero image to verify focal point behavior.
	7.	Run a test migration step (if delivering updates) in a staging environment.

Include a short TEST_AFTER_INSTALL.md in package with these steps.

⸻

15. Delivery & distribution channels

Options to deliver to buyers:
	•	Direct download link from your website (recommended: S3 + CloudFront)
	•	Marketplace (Codecanyon, Gumroad) — ensure license compatibility
	•	Private sales via email attachment (not recommended due to size/transfers)

Delivery best practice
	•	Host the zip on a reliable CDN or S3.
	•	Provide sha256 checksum and size for buyer verification.
	•	Provide download expiry links for security (if selling one-off).

⸻

16. Return, refunds & trial policy (suggested)
	•	Offer a 7-day refund window if buyer cannot install due to package defects after proving they followed README_INSTALL.md.
	•	Offer paid installation/support if buyer prefers hands-off setup.
	•	Provide troubleshooting FAQ before refund.

⸻

17. Example packaging timeline (developer workflow)
	1.	Freeze code & tag release (git tag v1.0.0).
	2.	Run tests & lint.
	3.	Build assets (npm run build).
	4.	Run Clean-Pack script (clear env, exports schema.sql, clear storage).
	5.	Create vendor package (optional).
	6.	Create ZIP and generate checksum.
	7.	Upload to distribution server and test on target hosts.
	8.	Publish product page + support details.

⸻

18. Troubleshooting common packaging problems & remedies
	•	Large ZIP → remove unnecessary assets; provide two variants (vendor / light).
	•	Migration failures on buyer host → include schema.sql and manual import instructions.
	•	Permission errors → include succinct chmod steps for cPanel file manager.
	•	Missing PHP extensions → include list of required extensions in README and common hosting providers that offer them.

⸻

19. Example .env.example (template to ship)

APP_NAME=InfluencerEngine
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_user
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"


⸻

20. Final checklist for release (copy & paste for pack script)

[ ] All tests passing (automated)
[ ] Assets built (public/)
[ ] .env removed
[ ] storage/installed.lock removed
[ ] storage/* cleared of logs & uploads
[ ] install/schema.sql included & validated
[ ] README_INSTALL.md included and double-checked
[ ] LICENSE & SUPPORT included
[ ] vendor/ included or documented
[ ] Zip created and sha256 checksum generated
[ ] Package tested on at least 3 cPanel hosts
